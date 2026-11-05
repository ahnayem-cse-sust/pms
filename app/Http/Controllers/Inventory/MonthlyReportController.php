<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\Equipment;
use App\Models\Inventory\Movement;
use App\Support\BanglaPdf;
use App\Support\Inv;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/** Month-wise stock report: opening, received, returned, allocated and closing quantity of every equipment (screen, PDF and CSV). */
class MonthlyReportController extends InvController
{
    public function index(Request $r)
    {
        $d = $this->data($r);
        if ($r->input('format') === 'csv') return $this->csvOut($d);
        if ($r->input('format') === 'pdf') return $this->pdfOut($d);

        return view('inventory.monthly', $d);
    }

    protected function data(Request $r): array
    {
        $r->validate(['month' => 'nullable|date_format:Y-m']);
        $month = $r->input('month') ?: now()->format('Y-m');   // an empty month box means the current month
        $from = Carbon::createFromFormat('Y-m-d', $month.'-01')->startOfDay();
        $to = $from->copy()->endOfMonth();

        $opening = Movement::where('moved_on', '<', $from->toDateString())->selectRaw('equipment_id, SUM(qty) as q')->groupBy('equipment_id')->pluck('q', 'equipment_id');
        $in = Movement::whereBetween('moved_on', [$from->toDateString(), $to->toDateString()])->selectRaw('equipment_id, type, SUM(qty) as q')->groupBy('equipment_id', 'type')->get()->groupBy('equipment_id');

        $rows = Equipment::with(['assetType', 'category'])->get()->map(function ($e) use ($opening, $in) {
            $m = ($in[$e->id] ?? collect())->pluck('q', 'type');
            $o = round((float) ($opening[$e->id] ?? 0), 2);
            $recv = round((float) ($m['RECEIVE'] ?? 0) + (float) ($m['OPENING'] ?? 0) + (float) ($m['PRIOR'] ?? 0), 2);   // new stock and previous items taken into store
            $ret = round((float) ($m['RETURN'] ?? 0), 2);
            $alloc = round(abs((float) ($m['ALLOCATE'] ?? 0)), 2);
            $other = round(collect($m)->except(['RECEIVE', 'OPENING', 'PRIOR', 'RETURN', 'ALLOCATE'])->sum(), 2);   // old corrections, if any

            return (object) ['equipment' => $e, 'opening' => $o, 'received' => $recv, 'returned' => $ret, 'allocated' => $alloc, 'other' => $other,
                'closing' => round($o + $recv + $ret - $alloc + $other, 2)];
        })->filter(fn ($x) => $x->opening != 0 || $x->received != 0 || $x->returned != 0 || $x->allocated != 0 || $x->other != 0 || $x->closing != 0)
            ->sortBy(fn ($x) => ($x->equipment->assetType->name ?? '').'|'.$x->equipment->name)->values();

        $totals = ['opening' => $rows->sum('opening'), 'received' => $rows->sum('received'), 'returned' => $rows->sum('returned'),
            'allocated' => $rows->sum('allocated'), 'other' => $rows->sum('other'), 'closing' => $rows->sum('closing')];

        return ['month' => $month, 'monthLabel' => $from->format('F Y'), 'rows' => $rows, 'totals' => $totals, 'showOther' => $rows->contains(fn ($x) => $x->other != 0)];
    }

    protected function csvOut(array $d)
    {
        $head = ['Code', 'Equipment', 'Asset type', 'Category', 'Opening', 'Received', 'Returned', 'Allocated'];
        if ($d['showOther']) $head[] = 'Other';
        $head[] = 'Closing';

        return $this->csv('inventory_monthly_'.$d['month'], $head, $d['rows']->map(function ($x) use ($d) {
            $row = [$x->equipment->code, $x->equipment->name, $x->equipment->assetType->name ?? '', $x->equipment->category->name ?? '',
                Inv::qty($x->opening), Inv::qty($x->received), Inv::qty($x->returned), Inv::qty($x->allocated)];
            if ($d['showOther']) $row[] = Inv::qty($x->other);
            $row[] = Inv::qty($x->closing);

            return $row;
        }));
    }

    protected function pdfOut(array $d)
    {
        $d += ['generatedBy' => auth()->user()->name, 'generatedAt' => now()];
        $name = 'Inventory-Monthly-Report_'.$d['month'].'.pdf';

        // Equipment names may be Bangla: use mPDF when installed (composer require mpdf/mpdf), else DomPDF
        if (BanglaPdf::available()) {
            $html = view('inventory.monthly-pdf', $d + ['mpdf' => true])->render();
            $foot = '<div style="text-align:center;font-size:8pt;color:#6a7389">Generated '.$d['generatedAt']->format('d M Y h:i A').' (GMT+6) by '.e($d['generatedBy']).'</div>';

            return response(BanglaPdf::render($html, $foot, ['format' => 'A4-L']), 200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'attachment; filename="'.$name.'"']);
        }

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('inventory.monthly-pdf', $d + ['mpdf' => false])->setPaper('a4', 'landscape')->download($name);
    }
}
