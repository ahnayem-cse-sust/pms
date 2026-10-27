<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Asset, Issue, StockBalance};
use App\Models\Ticket;
use App\Services\Inventory\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssueController extends InvController
{
    /** Those who only request see only their own requests; approvers and issuers see all. */
    protected function scope($q)
    {
        $u = auth()->user();
        if ($u->hasPermission('inv.issue.approve') || $u->hasPermission('inv.issue.fulfill')) return $q;

        return $q->where(fn ($w) => $w->where('requested_by', $u->id)->orWhere('created_by', $u->id)->orWhere('recipient_user_id', $u->id));
    }

    public function index(Request $r)
    {
        $rows = $this->scope(Issue::with(['requester', 'recipient', 'department'])
            ->when($r->status, fn ($q, $v) => $q->where('status', $v))
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('ref', 'like', "%$s%")->orWhere('ticket_no', 'like', "%$s%")->orWhere('purpose', 'like', "%$s%")))
            ->when($r->from, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))->when($r->to, fn ($q, $v) => $q->whereDate('created_at', '<=', $v)))
            ->latest('id')->paginate(25)->withQueryString();

        return view('inventory.issues.index', compact('rows'));
    }

    public function create()
    {
        return view('inventory.issues.create', ['items' => $this->items(), 'people' => $this->people(), 'departments' => $this->departments(), 'stores' => $this->stores()]);
    }

    public function store(Request $r)
    {
        $d = $r->validate([
            'requested_by' => 'nullable|exists:users,id', 'recipient_user_id' => 'nullable|required_without:department_id|exists:users,id',
            'department_id' => 'nullable|required_without:recipient_user_id|exists:departments,id', 'location_id' => 'nullable|exists:inv_locations,id',
            'purpose' => 'required|string|max:1000', 'required_date' => 'nullable|date', 'ticket_no' => 'nullable|string|max:30',
            'lines' => 'required|array|min:1', 'lines.*.item_id' => 'required|exists:inv_items,id', 'lines.*.qty_requested' => 'required|numeric|gt:0', 'lines.*.remarks' => 'nullable|string|max:255',
        ]);
        if (! empty($d['ticket_no']) && ! Ticket::visibleTo(auth()->user())->where('ticket_no', trim($d['ticket_no']))->exists()) {
            return back()->withInput()->withErrors(['ticket_no' => 'No request with that number was found (or you cannot see it).']);
        }
        $issue = DB::transaction(function () use ($d) {
            $i = Issue::create(collect($d)->except('lines')->all() + ['ref' => $this->svc()->ref('issue'), 'requested_by' => $d['requested_by'] ?? auth()->id(), 'created_by' => auth()->id(), 'status' => 'SUBMITTED']);
            foreach ($d['lines'] as $l) $i->lines()->create($l);
            $this->audit('issue.created', $i, null, ['ref' => $i->ref]);
            return $i;
        });

        return redirect()->route('inv.issues.show', $issue)->with('ok', "Request {$issue->ref} submitted. Creating a request does not change stock.");
    }

    public function show(Issue $issue)
    {
        abort_unless($this->scope(Issue::whereKey($issue->id))->exists(), 403);
        $issue->load(['lines.item.unit', 'lines.asset', 'requester', 'recipient', 'department', 'location', 'approver']);
        $assets = Asset::where('status', 'AVAILABLE')->whereIn('item_id', $issue->lines->pluck('item_id'))->orderBy('asset_code')->limit(500)->get(['id', 'asset_code', 'serial_no', 'item_id', 'location_id'])->groupBy('item_id');
        $stock = StockBalance::with('location')->whereIn('item_id', $issue->lines->pluck('item_id'))->where('qty', '>', 0)->get()->groupBy('item_id');

        return view('inventory.issues.show', ['i' => $issue, 'assets' => $assets, 'stock' => $stock, 'stores' => $this->stores(),
            'needApproval' => InventoryService::on('inventory.approval_issue')]);
    }

    public function act(Request $r, Issue $issue, string $action)
    {
        $u = auth()->user();
        switch ($action) {
            case 'approve':
                $this->authorize('inv.issue.approve');
                abort_unless($issue->status === 'SUBMITTED', 422);
                $this->svc()->separation($issue->created_by);
                $issue->update(['status' => 'APPROVED', 'approved_by' => $u->id, 'approved_at' => now()]);
                break;
            case 'reject':
                $this->authorize('inv.issue.approve');
                abort_unless($issue->status === 'SUBMITTED', 422);
                $issue->update(['status' => 'REJECTED', 'reason' => $r->validate(['reason' => 'required|string|max:500'])['reason']]);
                break;
            case 'fulfil':
                $this->authorize('inv.issue.fulfill');
                $in = $r->validate(['location_id' => 'nullable|exists:inv_locations,id', 'pick' => 'required|array']);
                if (! empty($in['location_id'])) $issue->update(['location_id' => $in['location_id']]);
                $this->svc()->fulfilIssue($issue->fresh(), collect($in['pick'])->map(fn ($p) => $p)->all());
                break;
            case 'cancel':
                abort_unless(in_array($issue->status, ['SUBMITTED', 'APPROVED'], true) && $issue->lines()->sum('qty_issued') == 0, 422, 'Only an unfulfilled request can be cancelled.');
                abort_unless($issue->created_by === $u->id || $u->hasPermission('inv.issue.approve') || $u->hasPermission('inv.issue.fulfill'), 403);
                $issue->update(['status' => 'CANCELLED', 'reason' => $r->input('reason')]);
                break;
            case 'close':
                $this->authorize('inv.issue.fulfill');
                abort_unless($issue->status === 'PARTIAL', 422);
                $issue->update(['status' => 'CLOSED', 'reason' => $r->validate(['reason' => 'required|string|max:500'])['reason']]);
                break;
            default:
                abort(404);
        }
        $this->audit("issue.$action", $issue, null, ['ref' => $issue->ref, 'status' => $issue->fresh()->status]);

        return back()->with('ok', 'Done.');
    }
}
