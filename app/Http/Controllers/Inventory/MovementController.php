<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Asset, Item, Transfer};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/** Assignment to a custodian (ASSIGN), transfer between custodians/locations (TRANSFER), return to store (RETURN) and store-to-store consumable transfer (STOCK). */
class MovementController extends InvController
{
    protected array $kinds = ['ASSIGN' => 'Assign asset', 'TRANSFER' => 'Transfer asset', 'RETURN' => 'Return asset', 'STOCK' => 'Transfer stock between stores'];

    public function index(Request $r)
    {
        $rows = Transfer::with(['asset.item', 'item', 'requester', 'fromUser', 'toUser', 'fromDepartment', 'toDepartment', 'fromLocation', 'toLocation'])
            ->when($r->kind, fn ($q, $v) => $q->where('kind', $v))->when($r->status, fn ($q, $v) => $q->where('status', $v))
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('ref', 'like', "%$s%")->orWhereHas('asset', fn ($a) => $a->where('asset_code', 'like', "%$s%")->orWhere('serial_no', 'like', "%$s%"))))
            ->latest('id')->paginate(25)->withQueryString();

        return view('inventory.movements.index', ['rows' => $rows, 'kinds' => $this->kinds]);
    }

    public function create(Request $r, string $kind)
    {
        abort_unless(isset($this->kinds[$kind]), 404);
        $statuses = ['ASSIGN' => ['AVAILABLE'], 'TRANSFER' => ['AVAILABLE', 'ASSIGNED'], 'RETURN' => ['ASSIGNED']][$kind] ?? [];
        $assets = $kind === 'STOCK' ? collect() : Asset::with(['item', 'custodianUser', 'custodianDepartment', 'location'])->whereIn('status', $statuses)->orderBy('asset_code')->limit(1000)->get();

        return view('inventory.movements.create', ['kind' => $kind, 'title' => $this->kinds[$kind], 'assets' => $assets, 'pre' => $r->asset, 'people' => $this->people(),
            'departments' => $this->departments(), 'locations' => $this->locations(), 'stores' => $this->stores(), 'conditions' => $this->lookup('condition'), 'items' => $this->items('CONSUMABLE')]);
    }

    public function store(Request $r)
    {
        $kind = $r->validate(['kind' => 'required|in:ASSIGN,TRANSFER,RETURN,STOCK'])['kind'];
        $common = ['remarks' => 'nullable|string|max:1000', 'effective_date' => 'nullable|date'];
        $t = new Transfer(['kind' => $kind, 'status' => 'REQUESTED', 'requested_by' => auth()->id()]);
        $newRef = fn () => $this->svc()->ref($kind === 'RETURN' ? 'return' : 'transfer');   // numbered only after validation passes

        if ($kind === 'STOCK') {
            $d = $r->validate($common + ['item_id' => 'required|exists:inv_items,id', 'qty' => 'required|numeric|gt:0', 'from_location_id' => 'required|exists:inv_locations,id',
                'to_location_id' => 'required|different:from_location_id|exists:inv_locations,id']);
            if (Item::find($d['item_id'])->type !== 'CONSUMABLE') throw ValidationException::withMessages(['item_id' => 'Only consumables can be transferred by quantity.']);
            $t->fill($d + ['from_type' => 'LOCATION', 'to_type' => 'LOCATION', 'ref' => $newRef()]);
            $t->save();
        } else {
            $rules = $common + ['asset_id' => 'required|exists:inv_assets,id', 'condition_id' => 'nullable|exists:inv_lookups,id', 'accessories' => 'nullable|string|max:500'];
            $rules += $kind === 'RETURN' ? ['to_location_id' => 'required|exists:inv_locations,id'] : $this->toRules('to');
            $d = $r->validate($rules);
            if ($kind === 'RETURN') $d['to_type'] = 'LOCATION';
            DB::transaction(function () use ($t, $d, $newRef) {
                $a = Asset::findOrFail($d['asset_id']);
                if ($t->kind === 'TRANSFER' && $a->custodian_type === $d['to_type'] && ($d['to_user_id'] ?? null) == $a->custodian_user_id
                    && ($d['to_department_id'] ?? null) == $a->custodian_department_id && ($d['to_location_id'] ?? null) == $a->location_id) {
                    throw ValidationException::withMessages(['asset_id' => 'The asset is already with that custodian / location.']);
                }
                $t->ref = $newRef();
                $t->fill($d + ['from_type' => $a->custodian_type, 'from_user_id' => $a->custodian_user_id, 'from_department_id' => $a->custodian_department_id, 'from_location_id' => $a->location_id]);
                $this->svc()->openTransfer($t);   // locks the asset and sets IN_TRANSFER – blocks conflicting assignments
                $t->save();
                $this->audit('movement.requested', $t, null, ['ref' => $t->ref, 'kind' => $t->kind, 'asset' => $a->asset_code]);
            });
        }

        return redirect()->route('inv.movements.show', $t)->with('ok', "{$t->ref} created.");
    }

    public function show(Transfer $transfer)
    {
        $transfer->load(['asset.item', 'item', 'requester', 'approver', 'condition', 'fromUser', 'toUser', 'fromDepartment', 'toDepartment', 'fromLocation', 'toLocation']);

        return view('inventory.movements.show', ['t' => $transfer, 'needApproval' => \App\Services\Inventory\InventoryService::on('inventory.approval_assignment')]);
    }

    public function act(Request $r, Transfer $transfer, string $action)
    {
        $s = $this->svc();
        switch ($action) {
            case 'approve':
                $this->authorize('inv.assign.approve');
                abort_unless($transfer->status === 'REQUESTED', 422);
                $s->separation($transfer->requested_by);
                $transfer->update(['status' => 'APPROVED', 'approved_by' => auth()->id(), 'approved_at' => now()]);
                break;
            case 'reject':
                $this->authorize('inv.assign.approve');
                abort_unless(in_array($transfer->status, ['REQUESTED', 'APPROVED'], true), 422);
                $s->closeTransferWithoutPosting($transfer, 'REJECTED', $r->validate(['reason' => 'required|string|max:500'])['reason']);
                break;
            case 'post':
                $this->authorize('inv.assign.complete');
                $s->postTransfer($transfer);
                break;
            case 'cancel':
                abort_unless(auth()->user()->hasPermission('inv.assign.create') || auth()->user()->hasPermission('inv.assign.approve'), 403);
                abort_unless(in_array($transfer->status, ['REQUESTED', 'APPROVED'], true), 422);
                $s->closeTransferWithoutPosting($transfer, 'CANCELLED', (string) $r->input('reason', 'Cancelled'));
                break;
            default:
                abort(404);
        }
        $this->audit("movement.$action", $transfer, null, ['ref' => $transfer->ref, 'status' => $transfer->fresh()->status]);

        return back()->with('ok', 'Done.');
    }
}
