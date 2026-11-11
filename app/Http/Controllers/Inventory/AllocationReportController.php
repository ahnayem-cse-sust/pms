<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Equipment, Movement};
use App\Support\BanglaPdf;
use App\Support\Inv;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Item wise Allocation report: for a date range, how much of each equipment was allocated, how much came back, and to whom
 * (screen, PDF with an optional detailed listing of every allocation, CSV). Previous allocations count on the date they were handed over.
 */
class AllocationReportController extends InvController
{
    public function index(Request $r)
    {
        $d = $this->data($r);
        if ($r->input('format') === 'csv') return $this->csvOut($d);
        if ($r->input('format') === 'pdf') return $this->pdfOut($d);

        return view('inventory.allocation-report', $d + ['cats' => $this->categories(), 'subs' => $this->subcategories(), 'items' => Equipment::orderBy('name')->get(['id', 'code', 'name', 'brand', 'model'])]);
    }

    protected function date(?string $v, Carbon $default): Carbon
    {
        try { return $v ? Carbon::parse($v)->startOfDay() : $default; } catch (\Throwable) { return $default; }
    }

    protected function data(Request $r): array
    {
        $from = $this->date($r->from, now()->startOfMonth());
        $to = $this->date($r->to, now()->startOfDay());
        if ($to->lt($from)) [$from, $to] = [$to, $from];

        $moves = Movement::with(['equipment.category', 'equipment.subcategory', 'user', 'holderUser.department', 'holderDepartment', 'holderSection.department'])
            ->whereIn('type', ['ALLOCATE', 'RETURN'])
            ->whereBetween('moved_on', [$from->toDateString(), $to->toDateString()])
            ->whereHas('equipment', fn ($e) => $e
                ->when($r->equipment_id, fn ($q, $v) => $q->where('id', $v))
                ->when($r->category_id, fn ($q, $v) => $q->where('category_id', $v))
                ->when($r->subcategory_id, fn ($q, $v) => $q->where('subcategory_id', $v)))
            ->orderBy('moved_on')->orderBy('id')->get();

        $rows = $moves->groupBy('equipment_id')->map(function ($g) {
            $alloc = $g->where('type', 'ALLOCATE');
            $ret = (float) $g->where('type', 'RETURN')->sum('qty');
            $allocated = abs((float) $alloc->sum('qty'));

            return (object) [
                'equipment' => $g->first()->equipment,
                'allocated' => round($allocated, 2),
                'returned' => round($ret, 2),
                'net' => round($allocated - $ret, 2),
                'entries' => $alloc->pluck('entry_no')->filter()->unique()->count(),
                'holders' => $alloc->map(fn ($m) => $m->holder_type.'-'.($m->holder_user_id ?? $m->holder_department_id ?? $m->holder_section_id))->unique()->count(),
                'lines' => $alloc->values(),   // every allocation line, for the detailed PDF
            ];
        })->filter(fn ($x) => $x->allocated > 0 || $x->returned > 0)
            ->sortBy(fn ($x) => ($x->equipment->category->name ?? '').'|'.($x->equipment->subcategory->name ?? '').'|'.$x->equipment->name)->values();

        // One item chosen: just its allocation records (Allocate ID, date, allocated to, quantity, reference), one line per entry and receiver
        $item = $r->equipment_id ? Equipment::find($r->equipment_id) : null;
        $records = $item ? $rows->flatMap(fn ($x) => $x->lines)->groupBy(fn ($m) => ($m->entry_no ?? $m->ref).'|'.$m->holder_type.$m->holder_user_id.$m->holder_department_id.$m->holder_section_id)
            ->map(function ($ls) {
                $m = $ls->first();

                return (object) ['entry' => $m->entry_no ?: $m->ref, 'date' => $m->moved_on, 'to' => $m->holder_name.($m->holderUser?->department ? ' ('.$m->holderUser->department->name.')' : ''), 'qty' => round($ls->sum(fn ($l) => abs((float) $l->qty)), 2), 'reference' => $m->reference_no];
            })->values() : collect();

        return ['rows' => $rows, 'from' => $from, 'to' => $to, 'detail' => $r->boolean('detail'), 'item' => $item, 'records' => $records,
            'totals' => ['allocated' => $rows->sum('allocated'), 'returned' => $rows->sum('returned'), 'net' => $rows->sum('net'),
                'entries' => $moves->where('type', 'ALLOCATE')->pluck('entry_no')->filter()->unique()->count()]];
    }

    protected function csvOut(array $d)
    {
        if ($d['item']) {
            return $this->csv('allocations_'.$d['item']->code.'_'.$d['from']->format('Ymd').'-'.$d['to']->format('Ymd'), ['Allocate ID', 'Date', 'Allocate to', 'Quantity', 'Reference'],
                $d['records']->map(fn ($x) => [$x->entry, $x->date->format('Y-m-d'), $x->to, Inv::qty($x->qty), $x->reference]));
        }

        $out = $d['detail']
            ? $d['rows']->flatMap(fn ($x) => $x->lines->map(fn ($m) => [$x->equipment->code, $x->equipment->name, $x->equipment->category->name ?? '', $x->equipment->subcategory->name ?? '', $m->moved_on->format('Y-m-d'), $m->entry_no, $m->holder_name, Inv::qty(abs($m->qty)), $m->reference_no]))
            : $d['rows']->map(fn ($x) => [$x->equipment->code, $x->equipment->name, $x->equipment->category->name ?? '', $x->equipment->subcategory->name ?? '', Inv::qty($x->allocated), Inv::qty($x->returned), Inv::qty($x->net), $x->entries, $x->holders, $x->equipment->unit]);

        return $this->csv('allocation_report_'.$d['from']->format('Ymd').'-'.$d['to']->format('Ymd'),
            $d['detail'] ? ['Equipment ID', 'Equipment', 'Category', 'Sub category', 'Date', 'Entry', 'Allocated to', 'Quantity', 'Reference']
                : ['Equipment ID', 'Equipment', 'Category', 'Sub category', 'Allocated', 'Returned', 'Net out', 'Allocation entries', 'Allocated to (people / places)', 'Unit'], $out);
    }

    protected function pdfOut(array $d)
    {
        $d += ['generatedBy' => auth()->user()->name, 'generatedAt' => now()];
        $name = 'Allocation-Report_'.$d['from']->format('Y-m-d').'_to_'.$d['to']->format('Y-m-d').'.pdf';

        if (BanglaPdf::available()) {
            $html = view('inventory.allocation-report-pdf', $d + ['mpdf' => true])->render();
            $foot = '<div style="text-align:center;font-size:8pt;color:#6a7389">Generated '.$d['generatedAt']->format('d M Y h:i A').' (GMT+6) by '.e($d['generatedBy']).' &middot; Page {PAGENO} of {nbpg}</div>';

            return response(BanglaPdf::render($html, $foot, ['format' => 'A4-L']), 200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'attachment; filename="'.$name.'"']);
        }

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('inventory.allocation-report-pdf', $d + ['mpdf' => false])->setPaper('a4', 'landscape')->download($name);
    }
}
