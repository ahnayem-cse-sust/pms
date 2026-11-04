<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Support\BanglaPdf;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    protected function scope(Request $r)
    {
        $month = $r->input('month') ?: now()->format('Y-m');   // an empty month box means the current month
        $from = Carbon::createFromFormat('Y-m-d', $month . '-01')->startOfDay();
        $to = $from->copy()->endOfMonth();
        $q = Ticket::visibleTo(auth()->user())->whereBetween('tickets.created_at', [$from, $to]);
        return [$month, $q];
    }

    public function index(Request $r)
    {
        return view('reports.index', $this->data($r));
    }

    /** Month-wise report as a PDF (summary, department / category counts, IT team table and the request list). */
    public function pdf(Request $r)
    {
        $d = $this->data($r) + ['generatedBy' => auth()->user()->name, 'generatedAt' => now()];
        $d['monthLabel'] = Carbon::createFromFormat('Y-m-d', $d['month'].'-01')->format('F Y');
        $name = "joplc-it-report-{$d['month']}.pdf";

        // Request subjects are often Bangla, which DomPDF cannot shape: use mPDF when it is installed (composer require mpdf/mpdf)
        if (BanglaPdf::available()) {
            $html = view('reports.pdf', $d + ['mpdf' => true])->render();
            $foot = '<div style="text-align:center;font-size:8pt;color:#6a7389">Generated '.$d['generatedAt']->format('d M Y h:i A').' (GMT+6) by '.e($d['generatedBy']).' &middot; Page {PAGENO} of {nbpg}</div>';

            return response(BanglaPdf::render($html, $foot), 200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'attachment; filename="'.$name.'"']);
        }

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', $d + ['mpdf' => false])->setPaper('a4', 'portrait')->download($name);
    }

    protected function data(Request $r): array
    {
        $r->validate(['month' => 'nullable|date_format:Y-m']);
        [$month, $q] = $this->scope($r);

        $tickets = (clone $q)->with(['status', 'department', 'category', 'assignee', 'assignees'])->get();

        $summary = [
            'Total requests' => $tickets->count(),
            'New (unassigned)' => $tickets->whereNull('assigned_to')->filter(fn ($t) => $t->status->is_open)->count(),
            'Resolved' => $tickets->whereNotNull('resolved_at')->count(),
            'Closed' => $tickets->where('status.code', 'CLOSED')->count(),
            'Pending (open)' => $tickets->filter(fn ($t) => $t->status->is_open)->count(),
            'Avg resolution (hours)' => round($tickets->whereNotNull('resolved_at')
                ->avg(fn ($t) => $t->created_at->diffInMinutes($t->resolved_at, true)) / 60, 1),
        ];

        $byDept = $tickets->groupBy(fn ($t) => $t->department->name)->map->count()->sortDesc();
        $byCat = $tickets->groupBy(fn ($t) => $t->category->name)->map->count()->sortDesc();

        // Operational (not a performance score): per IT member
        $perMember = User::assignable()->orderBy('name')->get()->map(function ($m) use ($tickets) {
            // A task is any request the employee is on the team of, as primary or as a supporting employee
            $mine = $tickets->filter(fn ($t) => $t->assigned_to === $m->id || $t->assignees->contains('employee_id', $m->id));
            $primary = $mine->where('assigned_to', $m->id)->count();
            $done = $mine->whereNotNull('resolved_at');
            return (object) [
                'name' => $m->name,
                'tasks' => $mine->count(),
                'primary' => $primary,
                'supporting' => $mine->count() - $primary,
                'completed' => $done->count(),
                'pending' => $mine->filter(fn ($t) => $t->status->is_open && ! $t->resolved_at)->count(),
            ];
        });

        return compact('month', 'summary', 'byDept', 'byCat', 'perMember', 'tickets');
    }

    public function csv(Request $r)
    {
        $r->validate(['month' => 'nullable|date_format:Y-m']);
        [$month, $q] = $this->scope($r);
        $rows = $q->with(['status', 'department', 'category', 'subcategory', 'assignee', 'type'])->orderBy('tickets.created_at')->get();

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so Excel opens it correctly
            fputcsv($out, ['Request ID', 'Service Type', 'Created', 'Department', 'Requester', 'Employee ID', 'Category', 'Sub-category', 'Subject', 'Status', 'Assigned To', 'Due', 'Resolved', 'Closed']);
            foreach ($rows as $t) {
                fputcsv($out, [
                    $t->ticket_no, $t->type->name, $t->created_at->format('Y-m-d h:i A'), $t->department->name,
                    $t->requester_name, $t->requester_employee_id, $t->category->name, $t->subcategory?->name,
                    $t->subject, $t->status->name, $t->assignee?->name,
                    optional($t->due_date)->format('Y-m-d'), optional($t->resolved_at)?->format('Y-m-d h:i A'),
                    optional($t->closed_at)?->format('Y-m-d h:i A'),
                ]);
            }
            fclose($out);
        }, "joplc-it-report-{$month}.csv", ['Content-Type' => 'text/csv']);
    }
}
