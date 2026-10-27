<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Asset, Document, Maintenance};
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MaintenanceController extends InvController
{
    public function index(Request $r)
    {
        $rows = Maintenance::with(['asset.item'])->when($r->status, fn ($q, $v) => $q->where('status', $v))
            ->when($r->boolean('open'), fn ($q) => $q->whereNotIn('status', config('inventory.maintenance_final')))
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('ref', 'like', "%$s%")->orWhere('ticket_no', 'like', "%$s%")->orWhere('vendor', 'like', "%$s%")
                ->orWhereHas('asset', fn ($a) => $a->where('asset_code', 'like', "%$s%")->orWhere('serial_no', 'like', "%$s%"))))
            ->latest('id')->paginate(25)->withQueryString();
        $assets = auth()->user()->hasPermission('inv.maint.create')
            ? Asset::with('item')->whereIn('status', ['AVAILABLE', 'ASSIGNED', 'DAMAGED', 'UNAVAILABLE'])->orderBy('asset_code')->limit(1000)->get() : collect();

        return view('inventory.maintenance.index', ['rows' => $rows, 'assets' => $assets, 'pre' => $r->asset]);
    }

    protected function ticketCheck(?string $no): ?string
    {
        $no = $no ? trim($no) : null;
        if ($no && ! Ticket::visibleTo(auth()->user())->where('ticket_no', $no)->exists()) {
            throw ValidationException::withMessages(['ticket_no' => 'No request with that number was found (or you cannot see it).']);
        }

        return $no;
    }

    public function store(Request $r)
    {
        $d = $r->validate(['asset_id' => 'required|exists:inv_assets,id', 'fault' => 'required|string|max:2000', 'reported_date' => 'required|date', 'ticket_no' => 'nullable|string|max:30',
            'vendor' => 'nullable|string|max:255', 'warranty_claim' => 'sometimes|boolean']);
        $d['ticket_no'] = $this->ticketCheck($d['ticket_no'] ?? null);
        $d['warranty_claim'] = $r->boolean('warranty_claim');
        $m = $this->svc()->startMaintenance(Asset::findOrFail($d['asset_id']), $d);
        $this->audit('maintenance.created', $m, null, ['ref' => $m->ref]);

        return redirect()->route('inv.maintenance.show', $m)->with('ok', "{$m->ref} logged; the asset is now marked Under Maintenance.");
    }

    public function show(Maintenance $maintenance)
    {
        $maintenance->load(['asset.item', 'creator']);
        $docs = Document::where('owner_type', 'maintenance')->where('owner_id', $maintenance->id)->latest('id')->get();

        return view('inventory.maintenance.show', ['m' => $maintenance, 'docs' => $docs]);
    }

    public function update(Request $r, Maintenance $maintenance)
    {
        abort_unless($maintenance->is_open, 422, 'This record is completed.');
        $statuses = implode(',', array_keys(config('inventory.maintenance_statuses')));
        $d = $r->validate(['status' => "required|in:$statuses", 'vendor' => 'nullable|string|max:255', 'cost' => 'nullable|numeric|min:0', 'warranty_claim' => 'sometimes|boolean',
            'action_taken' => 'nullable|string|max:2000', 'parts_replaced' => 'nullable|string|max:2000', 'outcome' => 'nullable|string|max:2000',
            'after' => 'nullable|in:RESTORE,DAMAGED,UNAVAILABLE', 'ticket_no' => 'nullable|string|max:30']);
        $d['ticket_no'] = $this->ticketCheck($d['ticket_no'] ?? null);
        $d['warranty_claim'] = $r->boolean('warranty_claim');
        $final = in_array($d['status'], config('inventory.maintenance_final'), true);
        if ($final && (empty($d['outcome']) || empty($d['after']))) {
            throw ValidationException::withMessages(['outcome' => 'Enter the outcome and the asset status after repair to complete this record.']);
        }
        $old = $maintenance->only(['status', 'vendor', 'cost']);
        $maintenance->update(collect($d)->except(['after', 'status'])->all() + ['status' => $final ? $maintenance->status : $d['status']]);
        if ($final) $this->svc()->finishMaintenance($maintenance, $d['after']);
        $this->audit('maintenance.updated', $maintenance, $old, ['status' => $d['status']]);

        return back()->with('ok', 'Saved.');
    }
}
