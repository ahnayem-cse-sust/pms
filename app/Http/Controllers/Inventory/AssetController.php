<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\Asset;
use Illuminate\Http\Request;

class AssetController extends InvController
{
    public function index(Request $r)
    {
        $u = auth()->user();
        abort_unless($u->hasPermission('inv.view') || $u->hasPermission('inv.view.own'), 403);
        $q = Asset::query()->visibleTo($u)->with(['product.category', 'location', 'holderUser', 'holderDepartment'])
            ->when($r->q, fn ($x, $s) => $x->where(fn ($w) => $w->where('asset_code', 'like', "%$s%")->orWhere('serial_no', 'like', "%$s%")
                ->orWhereHas('product', fn ($p) => $p->where('name', 'like', "%$s%")->orWhere('model', 'like', "%$s%"))))
            ->when($r->status, fn ($x, $v) => $x->where('status', $v))
            ->when($r->category_id, fn ($x, $v) => $x->whereHas('product', fn ($p) => $p->where('category_id', $v)))
            ->when($r->department_id, fn ($x, $v) => $x->where(fn ($w) => $w->where('holder_department_id', $v)->orWhereIn('holder_user_id', \App\Models\User::where('department_id', $v)->select('id'))))
            ->when($r->employee, fn ($x, $s) => $x->whereHas('holderUser', fn ($w) => $w->where('name', 'like', "%$s%")))
            ->orderBy('asset_code');

        if ($r->input('format') === 'csv' && $u->hasPermission('inv.view')) {
            return $this->csv('assets', ['Asset code', 'Product', 'Serial', 'Status', 'Store', 'Held by', 'Allocated on', 'Purchased', 'Cost', 'Supplier', 'Warranty end'],
                $q->get()->map(fn ($a) => [$a->asset_code, $a->product->name, $a->serial_no, \App\Support\Inv::label($a->status), $a->location->name ?? '', $a->holder_name, $a->allocated_at?->format('Y-m-d'),
                    $a->purchase_date?->format('Y-m-d'), $a->cost, $a->supplier, $a->warranty_end?->format('Y-m-d')]));
        }

        return view('inventory.assets.index', ['rows' => $q->paginate(25)->withQueryString(), 'categories' => $this->categories(), 'departments' => $this->departments()]);
    }

    public function show(Asset $asset)
    {
        abort_unless(Asset::query()->visibleTo(auth()->user())->whereKey($asset->id)->exists(), 403);
        $asset->load(['product.category', 'location', 'holderUser.department', 'holderDepartment', 'movements.user', 'movements.holderUser', 'movements.holderDepartment', 'movements.location']);

        return view('inventory.assets.show', compact('asset'));
    }

    public function edit(Asset $asset) { return view('inventory.assets.form', ['asset' => $asset, 'locations' => $this->locations()]); }

    public function update(Request $r, Asset $asset)
    {
        $d = $r->validate(['serial_no' => 'nullable|string|max:100', 'purchase_date' => 'nullable|date', 'cost' => 'nullable|numeric|min:0', 'supplier' => 'nullable|string|max:255',
            'warranty_end' => 'nullable|date', 'location_id' => 'nullable|exists:inv_locations,id', 'notes' => 'nullable|string|max:2000']);
        $this->svc()->assertSerialFree($d['serial_no'] ?? null, $asset->id);
        if ($asset->status === 'ALLOCATED') unset($d['location_id']);   // where it is follows from who holds it; change it by returning the item
        $old = $asset->only(array_keys($d));
        $asset->update($d);
        $this->audit('asset.updated', $asset, $old, $d);

        return redirect()->route('inv.assets.show', $asset)->with('ok', 'Saved.');
    }

    public function status(Request $r, Asset $asset)
    {
        $d = $r->validate(['to' => 'required|in:DAMAGED,LOST,RETIRED,RESTORE', 'note' => 'required|string|max:500']);
        $this->svc()->setStatus($asset, $d['to'], $d['note']);

        return back()->with('ok', 'Status updated and recorded.');
    }

    public function handover(Asset $asset)
    {
        abort_unless(Asset::query()->visibleTo(auth()->user())->whereKey($asset->id)->exists(), 403);
        abort_unless($asset->status === 'ALLOCATED', 404, 'This unit is not allocated.');
        $asset->load(['product', 'holderUser.department', 'holderDepartment']);

        return view('inventory.handover', compact('asset'));
    }
}
