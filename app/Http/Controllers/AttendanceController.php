<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * Management view of IT employees' office entry/exit, derived from login history:
 *   entry = first successful login of the day, exit = last successful login of the day,
 *   counting only logins from the configured office IP addresses.
 */
class AttendanceController extends Controller
{
    public function index(Request $r)
    {
        $d = $r->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'employee_id' => 'nullable|integer',
            'status' => 'nullable|in:Present,Absent,Weekend,Not in yet',
        ]);

        $cfg = config('itsm.attendance');
        $today = today();
        $to = Carbon::parse($d['to'] ?? $today)->startOfDay();
        if ($to->gt($today)) {
            $to = $today->copy();
        }
        $from = Carbon::parse($d['from'] ?? $to->copy()->startOfMonth())->startOfDay();
        if ($from->gt($to)) {
            $from = $to->copy();
        }
        if (abs($from->diffInDays($to)) >= $cfg['max_days']) {
            $from = $to->copy()->subDays($cfg['max_days'] - 1);
        }

        $everyone = User::active()
            ->whereHas('roles', fn ($q) => $q->whereIn('slug', $cfg['roles']))
            ->orderBy('name')->get();
        $employees = ! empty($d['employee_id']) ? $everyone->where('id', (int) $d['employee_id']) : $everyone;

        // Successful logins from office IPs only, grouped by employee and calendar day (GMT+6)
        $logins = LoginHistory::where('successful', true)
            ->whereIn('user_id', $employees->pluck('id'))
            ->whereIn('ip_address', $cfg['office_ips'])
            ->whereBetween('created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()])
            ->orderBy('created_at')
            ->get(['user_id', 'created_at'])
            ->groupBy(fn ($l) => $l->user_id . '|' . $l->created_at->format('Y-m-d'));

        $rows = [];
        for ($day = $to->copy(); $day->gte($from); $day->subDay()) {
            $key = $day->format('Y-m-d');
            foreach ($employees as $e) {
                if ($day->lt($e->created_at->copy()->startOfDay())) {
                    continue; // account did not exist yet – not an absence
                }
                $set = $logins->get($e->id . '|' . $key);
                $entry = $set?->first()?->created_at;
                $exit = $set?->last()?->created_at;

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
                    'seconds' => $entry ? max(0, $entry->diffInSeconds($exit, true)) : null,
                    'logins' => $set?->count() ?? 0,
                    'status' => $status,
                ];
            }
        }

        if (! empty($d['status'])) {
            $rows = array_values(array_filter($rows, fn ($x) => $x->status === $d['status']));
        }

        $present = collect($rows)->where('status', 'Present');
        $summary = [
            'present' => $present->count(),
            'absent' => collect($rows)->where('status', 'Absent')->count(),
            'avg' => $present->where('logins', '>=', 2)->count()
                ? (int) round($present->where('logins', '>=', 2)->avg('seconds')) : null,
        ];

        return view('attendance.index', [
            'rows' => $rows, 'summary' => $summary, 'everyone' => $everyone,
            'from' => $from, 'to' => $to, 'ips' => $cfg['office_ips'],
            'filters' => ['employee_id' => $d['employee_id'] ?? '', 'status' => $d['status'] ?? ''],
        ]);
    }
}
