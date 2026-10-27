<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Asset, Disposal, Document};
use Illuminate\Http\Request;

class DisposalController extends InvController
{
    public function index(Request $r)
    {
        $rows = Disposal::with(['asset.item', 'proposer'])->when($r->status, fn ($q, $v) => $q->where('status', $v))->latest('id')->paginate(25)->withQueryString();
        $assets = auth()->user()->hasPermission('inv.disposal.create')
            ? Asset::with('item')->whereNotIn('status', ['DISPOSED', 'IN_TRANSFER'])->whereDoesntHave('disposals', fn ($q) => $q->whereIn('status', ['PROPOSED', 'APPROVED']))->orderBy('asset_code')->limit(1000)->get()
            : collect();

        return view('inventory.disposals.index', ['rows' => $rows, 'assets' => $assets, 'pre' => $r->asset, 'conditions' => $this->lookup('condition')]);
    }

    public function store(Request $r)
    {
        $d = $r->validate(['asset_id' => 'required|exists:inv_assets,id', 'reason' => 'required|in:'.implode(',', array_keys(config('inventory.disposal_reasons'))),
            'condition_id' => 'nullable|exists:inv_lookups,id', 'proposed_action' => 'nullable|string|max:255', 'proposed_date' => 'nullable|date', 'remarks' => 'required|string|max:2000']);
        $a = Asset::findOrFail($d['asset_id']);
        $this->svc()->assertMovable($a, ['AVAILABLE', 'ASSIGNED', 'RESERVED', 'MAINTENANCE', 'UNAVAILABLE', 'LOST', 'DAMAGED'], 'disposal');
        $x = Disposal::create($d + ['ref' => $this->svc()->ref('disposal'), 'status' => 'PROPOSED', 'proposed_by' => auth()->id()]);
        $this->svc()->event($a, 'DISPOSAL_PROPOSED', null, null, $x->ref, ['reason' => $x->reason]);
        $this->audit('disposal.proposed', $x, null, ['ref' => $x->ref, 'asset' => $a->asset_code]);

        return redirect()->route('inv.disposals.show', $x)->with('ok', "{$x->ref} proposed. Attach evidence below.");
    }

    public function show(Disposal $disposal)
    {
        $disposal->load(['asset.item', 'proposer', 'approver']);
        $docs = Document::where('owner_type', 'disposal')->where('owner_id', $disposal->id)->latest('id')->get();

        return view('inventory.disposals.show', ['d' => $disposal, 'docs' => $docs]);
    }

    public function act(Request $r, Disposal $disposal, string $action)
    {
        switch ($action) {
            case 'approve':
                $this->authorize('inv.disposal.approve');
                abort_unless($disposal->status === 'PROPOSED', 422);
                $this->svc()->separation($disposal->proposed_by);
                $disposal->update(['status' => 'APPROVED', 'approved_by' => auth()->id(), 'approved_at' => now()]);
                break;
            case 'reject':
                $this->authorize('inv.disposal.approve');
                abort_unless($disposal->status === 'PROPOSED', 422);
                $disposal->update(['status' => 'REJECTED', 'reject_reason' => $r->validate(['reason' => 'required|string|max:500'])['reason']]);
                break;
            case 'complete':
                $this->authorize('inv.disposal.complete');
                $d = $r->validate(['method' => 'required|string|max:255', 'disposal_date' => 'required|date', 'recipient' => 'nullable|string|max:255', 'proceeds' => 'nullable|numeric|min:0', 'remarks' => 'nullable|string|max:2000']);
                $disposal->update($d);
                $this->svc()->completeDisposal($disposal->fresh());
                break;
            case 'cancel':
                abort_unless(auth()->user()->hasPermission('inv.disposal.create') || auth()->user()->hasPermission('inv.disposal.approve'), 403);
                abort_unless(in_array($disposal->status, ['PROPOSED', 'APPROVED'], true), 422);
                $disposal->update(['status' => 'CANCELLED']);
                break;
            default:
                abort(404);
        }
        $this->audit("disposal.$action", $disposal, null, ['ref' => $disposal->ref, 'status' => $disposal->fresh()->status]);

        return back()->with('ok', 'Done.');
    }
}
