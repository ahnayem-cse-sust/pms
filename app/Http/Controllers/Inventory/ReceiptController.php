<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Document, Item, Receipt};
use App\Services\Inventory\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReceiptController extends InvController
{
    public function index(Request $r)
    {
        $rows = Receipt::with(['supplier', 'location', 'preparer'])
            ->when($r->status, fn ($q, $v) => $q->where('status', $v))
            ->when($r->supplier_id, fn ($q, $v) => $q->where('supplier_id', $v))
            ->when($r->from, fn ($q, $v) => $q->whereDate('receipt_date', '>=', $v))->when($r->to, fn ($q, $v) => $q->whereDate('receipt_date', '<=', $v))
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('ref', 'like', "%$s%")->orWhere('procurement_ref', 'like', "%$s%")->orWhere('invoice_no', 'like', "%$s%")))
            ->latest('id')->paginate(25)->withQueryString();

        return view('inventory.receipts.index', ['rows' => $rows, 'suppliers' => $this->lookup('supplier')]);
    }

    public function create()
    {
        return view('inventory.receipts.create', ['suppliers' => $this->lookup('supplier'), 'locations' => $this->stores()->isNotEmpty() ? $this->stores() : $this->locations(),
            'items' => $this->items(), 'people' => $this->people()]);
    }

    public function store(Request $r)
    {
        $d = $r->validate([
            'receipt_date' => 'required|date', 'supplier_id' => 'nullable|exists:inv_lookups,id', 'procurement_ref' => 'nullable|string|max:255', 'invoice_no' => 'nullable|string|max:255',
            'location_id' => 'required|exists:inv_locations,id', 'received_by' => 'nullable|exists:users,id', 'remarks' => 'nullable|string|max:2000',
            'lines' => 'required|array|min:1', 'lines.*.item_id' => 'required|exists:inv_items,id', 'lines.*.qty_received' => 'required|numeric|min:0',
            'lines.*.qty_rejected' => 'nullable|numeric|min:0', 'lines.*.unit_cost' => 'nullable|numeric|min:0', 'lines.*.serials' => 'nullable|string|max:20000',
        ]);
        $items = Item::whereIn('id', collect($d['lines'])->pluck('item_id'))->get()->keyBy('id');
        foreach ($d['lines'] as $i => $l) {
            if ($items[$l['item_id']]->type === 'ASSET' && floor($l['qty_received']) != $l['qty_received']) {
                throw ValidationException::withMessages(["lines.$i.qty_received" => 'Serialized assets must be received in whole numbers.']);
            }
        }
        $rc = DB::transaction(function () use ($d, $r) {
            $rc = Receipt::create(collect($d)->except('lines')->all() + ['ref' => $this->svc()->ref('receipt'), 'prepared_by' => auth()->id(),
                'received_by' => $d['received_by'] ?? auth()->id(), 'status' => $r->boolean('submit') ? 'SUBMITTED' : 'DRAFT']);
            foreach ($d['lines'] as $l) {
                $rc->lines()->create(['item_id' => $l['item_id'], 'qty_received' => $l['qty_received'], 'qty_rejected' => $l['qty_rejected'] ?? 0,
                    'unit_cost' => $l['unit_cost'] ?? null, 'serials' => $l['serials'] ?? null]);
            }
            $this->audit('receipt.created', $rc, null, ['ref' => $rc->ref, 'status' => $rc->status]);
            return $rc;
        });

        return redirect()->route('inv.receipts.show', $rc)->with('ok', "Receipt {$rc->ref} saved.");
    }

    public function show(Receipt $receipt)
    {
        $receipt->load(['lines.item', 'supplier', 'location', 'preparer', 'approver', 'receiver']);
        $docs = Document::where('owner_type', 'receipt')->where('owner_id', $receipt->id)->latest('id')->get();

        return view('inventory.receipts.show', ['r' => $receipt, 'docs' => $docs, 'needApproval' => InventoryService::on('inventory.approval_receipt')]);
    }

    public function act(Request $r, Receipt $receipt, string $action)
    {
        $s = $this->svc();
        switch ($action) {
            case 'submit':
                $this->authorize('inv.receipt.create');
                abort_unless($receipt->status === 'DRAFT', 422);
                $receipt->update(['status' => 'SUBMITTED']);
                break;
            case 'approve':
                $this->authorize('inv.receipt.approve');
                abort_unless($receipt->status === 'SUBMITTED', 422);
                $s->separation($receipt->prepared_by);
                $receipt->update(['status' => 'APPROVED', 'approved_by' => auth()->id(), 'approved_at' => now()]);
                break;
            case 'reject':
                $this->authorize('inv.receipt.approve');
                abort_unless(in_array($receipt->status, ['SUBMITTED', 'APPROVED'], true), 422);
                $receipt->update(['status' => 'REJECTED', 'reason' => $r->validate(['reason' => 'required|string|max:500'])['reason']]);
                break;
            case 'post':
                $this->authorize('inv.receipt.post');
                $s->postReceipt($receipt);
                break;
            case 'cancel':
                abort_unless(auth()->user()->hasPermission('inv.receipt.create') || auth()->user()->hasPermission('inv.receipt.approve'), 403);
                abort_unless(in_array($receipt->status, ['DRAFT', 'SUBMITTED', 'APPROVED', 'REJECTED'], true), 422, 'A posted receipt cannot be cancelled; correct it with an adjustment.');
                $receipt->update(['status' => 'CANCELLED', 'reason' => $r->input('reason')]);
                break;
            default:
                abort(404);
        }
        $this->audit("receipt.$action", $receipt, null, ['ref' => $receipt->ref, 'status' => $receipt->fresh()->status]);

        return back()->with('ok', 'Done.');
    }
}
