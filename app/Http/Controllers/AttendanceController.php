<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

/**
 * Office entry/exit derived from login history:
 *   entry = first successful login of the day, exit = last logout of the day (manual, or the
 *   last activity when the 15-minute inactivity timeout ended the session),
 *   counting only events from the configured office IP addresses.
 *
 * index()  – Management: all IT employees (+ PDF export)
 * mine()   – IT employees: their own record
 */
class AttendanceController extends Controller
{
    private const PER_PAGE = 15;

    public function index(Request $r)
    {
        $f = $this->filters($r);
        $everyone = $this->itEmployees();
        $employees = $f['employee_id'] ? $everyone->where('id', $f['employee_id']) : $everyone;
        $rows = $this->buildRows($employees, $f['from'], $f['to'], $f['status']);

        return $this->render($r, $rows, $f, ['everyone' => $everyone, 'mine' => false]);
    }

    public function mine(Request $r)
    {
        $f = $this->filters($r);
        $rows = $this->buildRows(collect([$r->user()]), $f['from'], $f['to'], $f['status']);

        return $this->render($r, $rows, $f, ['everyone' => collect(), 'mine' => true]);
    }

    public function pdf(Request $r)
    {
        $f = $this->filters($r);

        $everyone = $this->itEmployees();
        $employees = $f['employee_id'] ? $everyone->where('id', $f['employee_id']) : $everyone;
        $rows = $this->buildRows($employees, $f['from'], $f['to'], $f['status']);

        $pdf = Pdf::loadView('attendance.pdf', [
            'rows' => $rows, 'from' => $f['from'], 'to' => $f['to'],
            'employeeName' => $f['employee_id'] ? optional($everyone->firstWhere('id', $f['employee_id']))->name : 'All IT employees',
            'status' => $f['status'], 'generatedBy' => $r->user()->name, 'generatedAt' => now(),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('IT-Attendance_' . $f['from']->format('Y-m-d') . '_to_' . $f['to']->format('Y-m-d') . '.pdf');
    }

    // ------------------------------------------------------------------ helpers

    protected function itEmployees()
    {
        return User::active()
            ->whereHas('roles', fn ($q) => $q->whereIn('slug', config('itsm.attendance.roles')))
            ->orderBy('name')->get();
    }

    protected function filters(Request $r): array
    {
        $d = $r->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'employee_id' => 'nullable|integer',
            'status' => 'nullable|in:Present,Absent,Weekend,Not in yet',
        ]);

        $today = today();
        $to = Carbon::parse($d['to'] ?? $today)->startOfDay();
        if ($to->gt($today)) {
            $to = $today->copy();
        }
        $from = Carbon::parse($d['from'] ?? $to->copy()->startOfMonth())->startOfDay();

        if ($from->gt($to)) {
            throw ValidationException::withMessages(['from' => 'From date cannot be after To date.']);
        }
        $months = (int) config('itsm.attendance.max_months', 6);
        if ($to->gt($from->copy()->addMonthsNoOverflow($months))) {
            throw ValidationException::withMessages(['to' => "The date range cannot be more than {$months} months."]);
        }

        return [
            'from' => $from, 'to' => $to,
            'employee_id' => ! empty($d['employee_id']) ? (int) $d['employee_id'] : null,
            'status' => $d['status'] ?? null,
        ];
    }

    /** One row per employee per day, newest day first. */
    protected function buildRows($employees, Carbon $from, Carbon $to, ?string $statusFilter): array
    {
        $cfg = config('itsm.attendance');

        // Office-IP events only (successful logins and logouts), grouped by employee and calendar day (GMT+6)
        $events = LoginHistory::where('successful', true)
            ->whereIn('user_id', $employees->pluck('id'))
            ->whereIn('ip_address', $cfg['office_ips'])
            ->whereBetween('created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()])
            ->orderBy('created_at')
            ->get(['user_id', 'event', 'created_at'])
            ->groupBy(fn ($l) => $l->user_id . '|' . $l->created_at->format('Y-m-d'));

        $rows = [];
        for ($day = $to->copy(); $day->gte($from); $day->subDay()) {
            $key = $day->format('Y-m-d');
            foreach ($employees as $e) {
                if ($day->lt($e->created_at->copy()->startOfDay())) {
                    continue; // account did not exist yet – not an absence
                }
                $set = $events->get($e->id . '|' . $key);
                $logins = $set ? $set->where('event', 'login') : collect();
                $logouts = $set ? $set->where('event', 'logout') : collect();

                // Entry = first login of the day, exit = last logout of the day
                $entry = $logins->first()?->created_at;
                $exit = $logouts->last()?->created_at;

                if ($set) {
                    $status = 'Present';
                } elseif ($day->isToday()) {
                    $status = 'Not in yet';
                } elseif (in_array($day->dayOfWeek, $cfg['weekend_days'], true)) {
                    $status = 'Weekend';
                } else {
                    $status = 'Absent';
                }

                $rows[] = (object) [
                    'employee' => $e,
                    'date' => $day->copy(),
                    'entry' => $entry,
                    'exit' => $exit,
                    'seconds' => ($entry && $exit && $exit->gte($entry)) ? (int) $entry->diffInSeconds($exit, true) : null,
                    'logins' => $logins->count(),
                    'logouts' => $logouts->count(),
                    'status' => $status,
                ];
            }
        }

        if ($statusFilter) {
            $rows = array_values(array_filter($rows, fn ($x) => $x->status === $statusFilter));
        }
        return $rows;
    }

    protected function render(Request $r, array $rows, array $f, array $extra)
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $paginator = new LengthAwarePaginator(
            array_slice($rows, ($page - 1) * self::PER_PAGE, self::PER_PAGE),
            count($rows), self::PER_PAGE, $page,
            ['path' => $r->url(), 'query' => $r->query()]
        );

        return view('attendance.index', $extra + [
            'rows' => $paginator,
            'from' => $f['from'], 'to' => $f['to'],
            'filters' => ['employee_id' => $f['employee_id'] ?? '', 'status' => $f['status'] ?? ''],
        ]);
    }
}
