<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Adjustment, Item, StockTransaction};
use Illuminate\Http\Request;

class AdjustmentController extends InvController
{
    public function index(Request $r)
    {
        $adj = Adjustment::with(['item', 'location', 'preparer', 'approver'])->when($r->status, fn ($q, $v) => $q->where('status', $v))->latest('id')->paginate(15, ['*'], 'ap')->withQueryString();
        $ledger = StockTransaction::with(['item', 'location', 'creator'])
            ->when($r->item_id, fn ($q, $v) => $q->where('item_id', $v))->when($r->location_id, fn ($q, $v) => $q->where('location_id', $v))
            ->latest('id')->paginate(25, ['*'], 'lp')->withQueryString();
        $reversed = StockTransaction::whereIn('reverses_id', $ledger->pluck('id'))->pluck('reverses_id')->all();

        return view('inventory.adjustments.index', ['adj' => $adj, 'ledger' => $ledger, 'reversed' => $reversed, 'items' => $this->items('CONSUMABLE'), 'locations' => $this->locations()]);
    }

    public function store(Request $r)
    {
        $d = $r->validate(['item_id' => 'required|exists:inv_items,id', 'location_id' => 'required|exists:inv_locations,id', 'qty_delta' => 'required|numeric|not_in:0',
            'reason_code' => 'required|in:'.implode(',', array_keys(config('inventory.adjust_reasons'))), 'notes' => 'required|string|max:1000']);
        abort_unless(Item::find($d['item_id'])->type === 'CONSUMABLE', 422, 'Only consumables have stock quantities.');
        $a = Adjustment::create($d + ['ref' => $this->svc()->ref('adjustment'), 'status' => 'PENDING', 'prepared_by' => auth()->id()]);
        $this->audit('adjustment.created', $a, null, ['ref' => $a->ref, 'delta' => $a->qty_delta]);

        return back()->with('ok', "{$a->ref} submitted for approval. Stock changes only when it is approved.");
    }

    public function act(Request $r, Adjustment $adjustment, string $action)
    {
        $this->authorize('inv.adjust.approve');
        if ($action === 'approve') {
            $this->svc()->approveAdjustment($adjustment);
        } elseif ($action === 'reject' && $adjustment->status === 'PENDING') {
            $adjustment->update(['status' => 'REJECTED', 'approved_by' => auth()->id(), 'approved_at' => now(), 'notes' => $adjustment->notes.' [Rejected: '.$r->validate(['reason' => 'required|string|max:500'])['reason'].']']);
        } else {
            abort(404);
        }
        $this->audit("adjustment.$action", $adjustment, null, ['ref' => $adjustment->ref]);

        return back()->with('ok', 'Done.');
    }

    public function reverse(Request $r, StockTransaction $transaction)
    {
        $reason = $r->validate(['reason' => 'required|string|max:500'])['reason'];
        $rev = $this->svc()->reverse($transaction, $reason);

        return back()->with('ok', "{$transaction->ref} reversed by {$rev->ref}.");
    }
}
