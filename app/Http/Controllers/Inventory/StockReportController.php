<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\Equipment;
use App\Models\Inventory\Movement;
use App\Support\BanglaPdf;
use App\Support\Inv;
use Illuminate\Http\Request;

/** Stock report: what is in the store now, what is out with employees / departments, and low / out-of-stock status (screen, PDF, CSV). */
class StockReportController extends InvController
{
    /** Inventory > Reports: the one place where every inventory report is listed. */
    public function hub()
    {
        return view('inventory.reports');
    }

    public function index(Request $r)
    {
        $d = $this->data($r);
        if ($r->input('format') === 'csv') return $this->csvOut($d);
        if ($r->input('format') === 'pdf') return $this->pdfOut($d);

        return view('inventory.stock', $d + ['types' => $this->types(), 'cats' => $this->categories()]);
    }

    protected function data(Request $r): array
    {
        $status = in_array($r->status, ['ok', 'low', 'out'], true) ? $r->status : '';

        // quantity currently with employees / departments = allocated minus returned
        $inUse = Movement::whereIn('type', ['ALLOCATE', 'RETURN'])->selectRaw('equipment_id, -SUM(qty) as q')->groupBy('equipment_id')->pluck('q', 'equipment_id');

        $rows = Equipment::with(['assetType', 'category', 'subcategory'])
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('name', 'like', "%$s%")->orWhere('code', 'like', "%$s%")->orWhere('brand', 'like', "%$s%")->orWhere('model', 'like', "%$s%")))
            ->when($r->asset_type_id, fn ($q, $v) => $q->where('asset_type_id', $v))->when($r->category_id, fn ($q, $v) => $q->where('category_id', $v))
            ->get()
            ->map(function ($e) use ($inUse) {
                $store = round((float) $e->stock_qty, 2);
                $use = max(round((float) ($inUse[$e->id] ?? 0), 2), 0);
                $min = (float) $e->min_stock;
                $st = $store <= 0 ? 'out' : ($min > 0 && $store <= $min ? 'low' : 'ok');

                return (object) ['equipment' => $e, 'store' => $store, 'use' => $use, 'total' => round($store + $use, 2), 'min' => $min, 'status' => $st];
            })
            // live equipment always; inactive equipment only while it still has stock or is still out with someone
            ->filter(fn ($x) => $x->equipment->is_live || $x->store != 0 || $x->use != 0)
            ->when($status, fn ($c) => $c->where('status', $status))
            ->sortBy(fn ($x) => ($x->equipment->assetType->name ?? '').'|'.($x->equipment->category->name ?? '').'|'.$x->equipment->name)->values();

        return ['rows' => $rows, 'asOf' => now(), 'status' => $status,
            'totals' => ['store' => $rows->sum('store'), 'use' => $rows->sum('use'), 'total' => $rows->sum('total')],
            'counts' => ['items' => $rows->count(), 'low' => $rows->where('status', 'low')->count(), 'out' => $rows->where('status', 'out')->count()]];
    }

    protected function csvOut(array $d)
    {
        return $this->csv('inventory_stock', ['Equipment ID', 'Equipment', 'Asset type', 'Category', 'Sub category', 'Brand', 'Model', 'In store', 'With employees / departments', 'Total', 'Unit', 'Minimum stock', 'Status'],
            $d['rows']->map(fn ($x) => [$x->equipment->code, $x->equipment->name, $x->equipment->assetType->name ?? '', $x->equipment->category->name ?? '', $x->equipment->subcategory->name ?? '',
                $x->equipment->brand, $x->equipment->model, Inv::qty($x->store), Inv::qty($x->use), Inv::qty($x->total), $x->equipment->unit, $x->min > 0 ? Inv::qty($x->min) : '', ['ok' => 'In stock', 'low' => 'Low stock', 'out' => 'Out of stock'][$x->status]]));
    }

    protected function pdfOut(array $d)
    {
        $d += ['generatedBy' => auth()->user()->name, 'generatedAt' => now()];
        $name = 'Inventory-Stock-Report_'.now()->format('Y-m-d').'.pdf';

        // Equipment names may be Bangla: use mPDF when installed (composer require mpdf/mpdf), else DomPDF
        if (BanglaPdf::available()) {
            $html = view('inventory.stock-pdf', $d + ['mpdf' => true])->render();
            $foot = '<div style="text-align:center;font-size:8pt;color:#6a7389">Generated '.$d['generatedAt']->format('d M Y h:i A').' (GMT+6) by '.e($d['generatedBy']).' &middot; Page {PAGENO} of {nbpg}</div>';

            return response(BanglaPdf::render($html, $foot, ['format' => 'A4-L']), 200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'attachment; filename="'.$name.'"']);
        }

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('inventory.stock-pdf', $d + ['mpdf' => false])->setPaper('a4', 'landscape')->download($name);
    }
}
