<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\Movement;
use App\Support\Inv;
use Illuminate\Http\Request;

/** The complete record: every receive, allocation and return (and any old corrections). */
class RecordController extends InvController
{
    public function index(Request $r)
    {
        $q = Movement::with(['equipment.assetType', 'equipment.category', 'equipment.subcategory', 'user', 'holderUser', 'holderDepartment'])
            ->when($r->type, fn ($x, $v) => $x->where('type', $v))->when($r->equipment_id, fn ($x, $v) => $x->where('equipment_id', $v))
            ->when($r->from, fn ($x, $v) => $x->whereDate('moved_on', '>=', $v))->when($r->to, fn ($x, $v) => $x->whereDate('moved_on', '<=', $v))
            ->when($r->q, fn ($x, $s) => $x->where(fn ($w) => $w->where('ref', 'like', "%$s%")->orWhere('entry_no', 'like', "%$s%")->orWhere('reference_no', 'like', "%$s%")->orWhere('party', 'like', "%$s%")
                ->orWhereHas('holderUser', fn ($u) => $u->where('name', 'like', "%$s%"))->orWhereHas('holderDepartment', fn ($d) => $d->where('name', 'like', "%$s%"))))
            ->latest('id');

        if ($r->input('format') === 'csv') {
            return $this->csv('inventory_records', ['Record', 'Entry', 'Date', 'Type', 'Equipment', 'Asset type', 'Category', 'Sub category', 'Asset ID', 'Quantity', 'Balance after', 'Person / department', 'Reference', 'Supplier', 'Remarks', 'By'],
                $q->get()->map(fn ($m) => [$m->ref, $m->entry_no, $m->moved_on->format('Y-m-d'), Inv::label($m->type), $m->equipment->name, $m->equipment->assetType->name ?? '', $m->equipment->category->name ?? '', $m->equipment->subcategory->name ?? '', $m->serial_no,
                    Inv::qty($m->qty), Inv::qty($m->balance_after), $m->holder_name, $m->reference_no, $m->party, $m->remarks, $m->user->name ?? '']));
        }

        return view('inventory.records', ['rows' => $q->paginate(40)->withQueryString(), 'equipment' => $this->equipment()]);
    }

    /** View one record line with all its details, and a link to the entry it belongs to. */
    public function show(Movement $movement)
    {
        $movement->load(['equipment.assetType', 'equipment.category', 'equipment.subcategory', 'user', 'holderUser.department', 'holderDepartment']);
        $entryRoute = match ($movement->type) { 'ALLOCATE' => 'inv.allocations.show', 'RECEIVE', 'OPENING', 'RETURN' => 'inv.receives.show', default => null };
        $entryCount = $entryRoute ? Movement::where('entry_no', $movement->entry_no)->count() : 0;

        return view('inventory.record-show', ['m' => $movement, 'entryRoute' => $entryRoute, 'entryCount' => $entryCount]);
    }
}
