<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Equipment, Movement};

class DashboardController extends InvController
{
    public function index()
    {
        $items = Equipment::with('assetType')->where('is_active', true)->get();
        $out = $items->filter(fn ($e) => (float) $e->stock_qty <= 0)->values();
        $low = $items->filter(fn ($e) => (float) $e->stock_qty > 0 && $e->is_low)->values();

        return view('inventory.dashboard', [
            'stats' => ['Equipment items' => $items->count(), 'Units in stock' => $items->sum('stock_qty'), 'Units allocated' => -Movement::whereIn('type', ['ALLOCATE', 'RETURN'])->sum('qty'),
                'Low or out of stock' => $low->count() + $out->count()],
            'low' => $low->sortBy('stock_qty')->values(), 'out' => $out,
            'byType' => $items->groupBy(fn ($e) => $e->assetType->name ?? 'Unclassified')->map(fn ($g) => ['units' => (float) $g->sum('stock_qty'), 'items' => $g->count()])->sortByDesc('units'),
            'recent' => Movement::with(['equipment', 'user', 'holderUser', 'holderDepartment'])->latest('id')->limit(10)->get(),
        ]);
    }
}
