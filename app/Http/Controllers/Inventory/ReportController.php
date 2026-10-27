<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Asset, Assignment, Disposal, Issue, Maintenance, Receipt, StockTransaction, Stocktake, StocktakeLine, Transfer};
use App\Support\Inv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/** BRD section 8 reports. Each report returns title, columns and rows; shown as a table or exported as CSV (Excel opens it). */
class ReportController extends InvController
{
    protected array $reports = [
        'asset_register' => ['Asset Register', ['q', 'category_id', 'location_id', 'status']],
        'current_assignments' => ['Current Asset Assignment', ['q', 'department_id', 'location_id']],
        'employee_assets' => ['Employee / Department Asset List', ['user_id', 'department_id']],
        'stock_balance' => ['Inventory Stock Balance', ['location_id', 'category_id', 'to']],
        'stock_ledger' => ['Stock Ledger', ['item_id', 'location_id', 'from', 'to']],
        'receipt_register' => ['Receipt Register', ['from', 'to', 'status', 'q']],
        'issue_register' => ['Issue Register', ['from', 'to', 'status', 'q']],
        'movement_register' => ['Return and Transfer Register', ['from', 'to', 'status', 'q']],
        'low_stock' => ['Low / Out-of-Stock', ['location_id']],
        'warranty_expiry' => ['Warranty Expiry', ['days']],
        'maintenance' => ['Maintenance / Repair', ['from', 'to', 'status', 'q']],
        'verification' => ['Physical Verification', ['stocktake_id']],
        'disposed' => ['Disposed / Retired Assets', ['from', 'to']],
        'valuation' => ['Inventory Valuation Summary (recorded values only)', ['category_id']],
    ];

    public function show(Request $r, ?string $report = null)
    {
        if (! $report) return view('inventory.reports.index', ['reports' => $this->reports]);
        abort_unless(isset($this->reports[$report]), 404);
        [$cols, $rows, $note] = $this->{'r_'.$report}($r) + [2 => null];

        if ($r->input('format') === 'csv') {
            return response()->streamDownload(function () use ($cols, $rows) {
                $o = fopen('php://output', 'w');
                fwrite($o, "\xEF\xBB\xBF");
                fputcsv($o, $cols);
                foreach ($rows as $row) fputcsv($o, array_map(fn ($v) => is_object($v) ? strip_tags((string) $v) : $v, $row));
                fclose($o);
            }, $report.'_'.now()->format('Ymd_His').'.csv', ['Content-Type' => 'text/csv']);
        }
        $total = count($rows);

        return view('inventory.reports.show', ['key' => $report, 'title' => $this->reports[$report][0], 'filters' => $this->reports[$report][1], 'cols' => $cols, 'rows' => array_slice($rows, 0, 2000),
            'total' => $total, 'note' => $note, 'categories' => $this->categories(), 'locations' => $this->locations(), 'departments' => $this->departments(), 'people' => $this->people(),
            'items' => $this->items('CONSUMABLE'), 'stocktakes' => Stocktake::latest('id')->limit(50)->get(['id', 'ref', 'title']), 'statuses' => $this->statusOptions($report)]);
    }

    protected function statusOptions(string $report): array
    {
        return match ($report) {
            'asset_register' => config('inventory.asset_statuses'),
            'maintenance' => config('inventory.maintenance_statuses'),
            'receipt_register', 'issue_register', 'movement_register' => ['DRAFT' => 'Draft', 'SUBMITTED' => 'Submitted', 'REQUESTED' => 'Requested', 'APPROVED' => 'Approved', 'POSTED' => 'Posted', 'FULFILLED' => 'Fulfilled', 'PARTIAL' => 'Partial', 'REJECTED' => 'Rejected', 'CANCELLED' => 'Cancelled'],
            default => [],
        };
    }

    protected function assetQuery(Request $r)
    {
        return Asset::with(['item.category', 'item.brand', 'location', 'condition', 'supplier', 'custodianUser', 'custodianDepartment'])
            ->when($r->category_id, fn ($q, $c) => $q->whereHas('item', fn ($i) => $i->where('category_id', $c)->orWhere('subcategory_id', $c)))
            ->when($r->location_id, fn ($q, $v) => $q->where('location_id', $v));
    }

    protected function r_asset_register(Request $r): array
    {
        $rows = $this->assetQuery($r)->when($r->status, fn ($q, $v) => $q->where('status', $v))
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('asset_code', 'like', "%$s%")->orWhere('serial_no', 'like', "%$s%")->orWhereHas('item', fn ($i) => $i->where('name', 'like', "%$s%"))))
            ->orderBy('asset_code')->get()->map(fn ($a) => [$a->asset_code, $a->item->name, $a->item->category->name ?? '', $a->serial_no, trim(($a->item->brand->name ?? '').' '.$a->item->model),
                $a->acquisition_date?->format('Y-m-d'), $a->cost, $a->warranty_end?->format('Y-m-d'), $a->condition->name ?? '', Inv::label($a->status), $a->location->name ?? '', $a->custodian_name])->all();

        return [['Asset code', 'Item', 'Category', 'Serial', 'Brand / model', 'Acquired', 'Cost', 'Warranty end', 'Condition', 'Status', 'Location', 'Custodian'], $rows];
    }

    protected function r_current_assignments(Request $r): array
    {
        $rows = Assignment::with(['asset.item', 'user.department', 'department', 'location'])->whereNull('returned_at')
            ->when($r->department_id, fn ($q, $v) => $q->where(fn ($w) => $w->where('custodian_department_id', $v)->orWhereIn('custodian_user_id', \App\Models\User::where('department_id', $v)->select('id'))))
            ->when($r->location_id, fn ($q, $v) => $q->where('location_id', $v))
            ->when($r->q, fn ($q, $s) => $q->whereHas('asset', fn ($a) => $a->where('asset_code', 'like', "%$s%")->orWhere('serial_no', 'like', "%$s%")))
            ->orderBy('assigned_at')->get()->map(fn ($a) => [$a->holder, $a->user?->department?->name ?? $a->department?->name, $a->asset->asset_code, $a->asset->item->name, $a->assigned_at->format('Y-m-d'),
                $a->ack_required ? ($a->acknowledged_at ? 'Acknowledged '.$a->acknowledged_at->format('Y-m-d') : 'Pending') : 'Not required', Inv::label($a->asset->status)])->all();

        return [['Custodian', 'Department', 'Asset code', 'Item', 'Assigned on', 'Acknowledgement', 'Asset status'], $rows];
    }

    protected function r_employee_assets(Request $r): array
    {
        if (! $r->user_id && ! $r->department_id) return [['Custodian', 'Asset code', 'Item', 'Assigned', 'Returned', 'Condition'], [], 'Choose an employee or a department.'];
        $rows = Assignment::with(['asset.item', 'user', 'department', 'location', 'condition'])
            ->when($r->user_id, fn ($q, $v) => $q->where('custodian_user_id', $v))
            ->when($r->department_id, fn ($q, $v) => $q->where(fn ($w) => $w->where('custodian_department_id', $v)->orWhereIn('custodian_user_id', \App\Models\User::where('department_id', $v)->select('id'))))
            ->orderByDesc('assigned_at')->get()->map(fn ($a) => [$a->holder, $a->asset->asset_code, $a->asset->item->name, $a->assigned_at->format('Y-m-d'), $a->returned_at?->format('Y-m-d') ?? 'Current', $a->condition->name ?? ''])->all();

        return [['Custodian', 'Asset code', 'Item', 'Assigned', 'Returned', 'Condition'], $rows];
    }

    protected function r_stock_balance(Request $r): array
    {
        $q = DB::table('inv_stock_transactions as t')->join('inv_items as i', 'i.id', '=', 't.item_id')->join('inv_locations as l', 'l.id', '=', 't.location_id')
            ->when($r->location_id, fn ($x, $v) => $x->where('t.location_id', $v))
            ->when($r->category_id, fn ($x, $c) => $x->where(fn ($w) => $w->where('i.category_id', $c)->orWhere('i.subcategory_id', $c)))
            ->when($r->to, fn ($x, $v) => $x->whereDate('t.posting_date', '<=', $v))
            ->groupBy('i.id', 'i.code', 'i.name', 'i.min_stock', 'i.reorder_level', 'l.id', 'l.name')->orderBy('i.name')
            ->selectRaw("i.code, i.name, l.name as loc,
                SUM(CASE WHEN t.type='OPENING' THEN t.qty_in - t.qty_out ELSE 0 END) as opening,
                SUM(CASE WHEN t.type='RECEIPT' THEN t.qty_in - t.qty_out ELSE 0 END) as receipts,
                SUM(CASE WHEN t.type='ISSUE' THEN t.qty_in - t.qty_out ELSE 0 END) as issues,
                SUM(CASE WHEN t.type IN ('TRANSFER_IN','TRANSFER_OUT') THEN t.qty_in - t.qty_out ELSE 0 END) as transfers,
                SUM(CASE WHEN t.type IN ('ADJUSTMENT','REVERSAL') THEN t.qty_in - t.qty_out ELSE 0 END) as adjustments,
                SUM(t.qty_in - t.qty_out) as closing, i.min_stock, i.reorder_level")->get();
        $rows = $q->map(fn ($x) => [$x->code, $x->name, $x->loc, Inv::qty($x->opening), Inv::qty($x->receipts), Inv::qty($x->issues), Inv::qty($x->transfers), Inv::qty($x->adjustments),
            Inv::qty($x->closing), Inv::qty($x->min_stock), Inv::qty($x->reorder_level)])->all();

        return [['Item code', 'Item', 'Store / location', 'Opening', 'Receipts', 'Issues (neg.)', 'Transfers (net)', 'Adjustments (net)', 'Closing', 'Minimum', 'Reorder level'], $rows,
            'Closing = opening + receipts + issues + transfers + adjustments, summed from posted ledger lines.'];
    }

    protected function r_stock_ledger(Request $r): array
    {
        $rows = StockTransaction::with(['item', 'location', 'creator'])->when($r->item_id, fn ($q, $v) => $q->where('item_id', $v))->when($r->location_id, fn ($q, $v) => $q->where('location_id', $v))
            ->when($r->from, fn ($q, $v) => $q->whereDate('posting_date', '>=', $v))->when($r->to, fn ($q, $v) => $q->whereDate('posting_date', '<=', $v))
            ->orderBy('id')->get()->map(fn ($t) => [$t->ref, $t->posting_date->format('Y-m-d'), $t->type, $t->item->name, $t->location->name, Inv::qty($t->qty_in), Inv::qty($t->qty_out),
                Inv::qty($t->balance_after), $t->creator->name ?? '', $t->source_ref, $t->reason])->all();

        return [['Reference', 'Date', 'Type', 'Item', 'Location', 'In', 'Out', 'Balance after', 'User', 'Source', 'Reason'], $rows];
    }

    protected function r_receipt_register(Request $r): array
    {
        $rows = Receipt::with(['supplier', 'location', 'receiver', 'approver', 'lines.item'])->when($r->status, fn ($q, $v) => $q->where('status', $v))
            ->when($r->from, fn ($q, $v) => $q->whereDate('receipt_date', '>=', $v))->when($r->to, fn ($q, $v) => $q->whereDate('receipt_date', '<=', $v))
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('ref', 'like', "%$s%")->orWhere('procurement_ref', 'like', "%$s%")->orWhere('invoice_no', 'like', "%$s%")))
            ->orderBy('receipt_date')->get()->flatMap(fn ($x) => $x->lines->map(fn ($l) => [$x->ref, $x->receipt_date->format('Y-m-d'), $x->supplier->name ?? '', $x->procurement_ref, $x->invoice_no,
                $l->item->name, Inv::qty($l->qty_received), Inv::qty($l->qty_rejected), $x->location->name, $x->receiver->name ?? '', Inv::label($x->status)]))->all();

        return [['Receipt', 'Date', 'Supplier', 'Procurement ref', 'Invoice / challan', 'Item', 'Received', 'Rejected', 'Location', 'Received by', 'Status'], $rows];
    }

    protected function r_issue_register(Request $r): array
    {
        $rows = Issue::with(['recipient', 'department', 'approver', 'lines.item', 'lines.asset'])->when($r->status, fn ($q, $v) => $q->where('status', $v))
            ->when($r->from, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))->when($r->to, fn ($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('ref', 'like', "%$s%")->orWhere('ticket_no', 'like', "%$s%")))
            ->orderBy('id')->get()->flatMap(fn ($i) => $i->lines->map(fn ($l) => [$i->ref, $i->created_at->format('Y-m-d'), $i->recipient->name ?? '', $i->department->name ?? '', $l->item->name,
                $l->asset->asset_code ?? '', Inv::qty($l->qty_requested), Inv::qty($l->qty_issued), $i->purpose, $i->approver->name ?? '', Inv::label($i->status)]))->all();

        return [['Issue', 'Date', 'Recipient', 'Department', 'Item', 'Asset', 'Requested', 'Issued', 'Purpose', 'Approver', 'Status'], $rows];
    }

    protected function r_movement_register(Request $r): array
    {
        $rows = Transfer::with(['asset.item', 'item', 'condition', 'fromUser', 'toUser', 'fromDepartment', 'toDepartment', 'fromLocation', 'toLocation'])->when($r->status, fn ($q, $v) => $q->where('status', $v))
            ->when($r->from, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))->when($r->to, fn ($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->when($r->q, fn ($q, $s) => $q->where('ref', 'like', "%$s%"))
            ->orderBy('id')->get()->map(fn ($t) => [$t->ref, $t->kind, $t->asset?->asset_code ?? ($t->item?->name.' × '.Inv::qty($t->qty)), $t->party('from'), $t->party('to'),
                $t->created_at->format('Y-m-d'), $t->posted_at?->format('Y-m-d'), $t->condition->name ?? '', Inv::label($t->status)])->all();

        return [['Reference', 'Kind', 'Asset / item', 'From', 'To', 'Requested', 'Posted', 'Condition', 'Status'], $rows];
    }

    protected function r_low_stock(Request $r): array
    {
        $rows = DB::table('inv_stock_balances as b')->join('inv_items as i', 'i.id', '=', 'b.item_id')->join('inv_locations as l', 'l.id', '=', 'b.location_id')
            ->where('i.is_active', 1)->when($r->location_id, fn ($x, $v) => $x->where('b.location_id', $v))
            ->where(fn ($w) => $w->where('b.qty', '<=', 0)->orWhereColumn('b.qty', '<', 'i.min_stock'))
            ->orderBy('i.name')->get(['i.code', 'i.name', 'l.name as loc', 'b.qty', 'i.min_stock', 'i.reorder_level'])
            ->map(fn ($x) => [$x->code, $x->name, $x->loc, Inv::qty($x->qty), Inv::qty($x->min_stock), Inv::qty($x->reorder_level), (float) $x->qty <= 0 ? 'OUT OF STOCK' : 'Below minimum'])->all();

        return [['Item code', 'Item', 'Store / location', 'Balance', 'Minimum', 'Reorder level', 'Alert'], $rows];
    }

    protected function r_warranty_expiry(Request $r): array
    {
        $days = (int) ($r->days ?: \App\Models\SystemSetting::get('inventory.warranty_alert_days', 60));
        $rows = Asset::with(['item', 'supplier', 'custodianUser', 'custodianDepartment', 'location'])->where('status', '!=', 'DISPOSED')->whereNotNull('warranty_end')
            ->where('warranty_end', '<=', today()->addDays($days))->orderBy('warranty_end')->get()
            ->map(fn ($a) => [$a->asset_code, $a->item->name, $a->serial_no, $a->supplier->name ?? '', $a->warranty_end->format('Y-m-d'), $a->warranty_end->isPast() ? 'EXPIRED' : 'Expires in '.(int) today()->diffInDays($a->warranty_end).' days', $a->custodian_name])->all();

        return [['Asset code', 'Item', 'Serial', 'Supplier', 'Warranty end', 'Warranty', 'Custodian'], $rows, "Expired warranties and those ending within $days days."];
    }

    protected function r_maintenance(Request $r): array
    {
        $rows = Maintenance::with('asset.item')->when($r->status, fn ($q, $v) => $q->where('status', $v))->when($r->from, fn ($q, $v) => $q->whereDate('reported_date', '>=', $v))->when($r->to, fn ($q, $v) => $q->whereDate('reported_date', '<=', $v))
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('ref', 'like', "%$s%")->orWhere('vendor', 'like', "%$s%")->orWhereHas('asset', fn ($a) => $a->where('asset_code', 'like', "%$s%"))))
            ->orderBy('id')->get()->map(fn ($m) => [$m->ref, $m->asset->asset_code, $m->asset->item->name, $m->fault, $m->reported_date->format('Y-m-d'), Inv::label($m->status), $m->vendor, $m->warranty_claim ? 'Yes' : 'No',
                $m->cost, (int) $m->reported_date->diffInDays($m->completed_date ?? today()), $m->outcome])->all();

        return [['Reference', 'Asset', 'Item', 'Fault', 'Reported', 'Status', 'Vendor', 'Warranty claim', 'Cost', 'Downtime (days)', 'Outcome'], $rows];
    }

    protected function r_verification(Request $r): array
    {
        $rows = StocktakeLine::with(['stocktake', 'item', 'asset', 'location'])->when($r->stocktake_id, fn ($q, $v) => $q->where('stocktake_id', $v))->get()
            ->filter(fn ($l) => $l->discrepancy !== null && $l->discrepancy != 0.0)
            ->map(fn ($l) => [$l->stocktake->ref, $l->asset?->asset_code ?? $l->item?->name ?? $l->unrecorded_desc, $l->unrecorded_desc ? 'Unrecorded asset' : ($l->asset_id ? 'Asset '.$l->physical_status : 'Quantity'),
                $l->asset_id ? Inv::label($l->system_status) : Inv::qty($l->system_qty), $l->asset_id ? Inv::label($l->physical_status) : Inv::qty($l->physical_qty), $l->location->name ?? '', $l->remarks, Inv::label($l->stocktake->status)])->values()->all();

        return [['Stocktake', 'Asset / item', 'Finding', 'System', 'Physical', 'Location', 'Remarks', 'Stocktake status'], $rows, 'Discrepancies only.'];
    }

    protected function r_disposed(Request $r): array
    {
        $rows = Disposal::with('asset.item')->where('status', 'COMPLETED')->when($r->from, fn ($q, $v) => $q->whereDate('disposal_date', '>=', $v))->when($r->to, fn ($q, $v) => $q->whereDate('disposal_date', '<=', $v))
            ->orderBy('disposal_date')->get()->map(fn ($d) => [$d->ref, $d->asset->asset_code, $d->asset->item->name, $d->asset->serial_no, config('inventory.disposal_reasons.'.$d->reason), $d->method,
                $d->disposal_date?->format('Y-m-d'), $d->recipient, $d->proceeds, $d->approver->name ?? ''])->all();

        return [['Reference', 'Asset', 'Item', 'Serial', 'Reason', 'Method', 'Date', 'Receiving party', 'Proceeds', 'Approved by'], $rows];
    }

    protected function r_valuation(Request $r): array
    {
        $q = DB::table('inv_assets as a')->join('inv_items as i', 'i.id', '=', 'a.item_id')->join('inv_categories as c', 'c.id', '=', 'i.category_id')->where('a.status', '!=', 'DISPOSED')
            ->when($r->category_id, fn ($x, $v) => $x->where('i.category_id', $v))->groupBy('c.id', 'c.name')->orderBy('c.name')
            ->selectRaw('c.name, COUNT(*) as n, SUM(CASE WHEN a.cost IS NULL THEN 1 ELSE 0 END) as nocost, COALESCE(SUM(a.cost),0) as total')->get();
        $rows = $q->map(fn ($x) => [$x->name, $x->n, $x->nocost, number_format((float) $x->total, 2)])->all();
        $rows[] = ['TOTAL', $q->sum('n'), $q->sum('nocost'), number_format((float) $q->sum('total'), 2)];

        return [['Category', 'Assets', 'Without cost', 'Recorded acquisition cost'], $rows, 'Recorded acquisition costs only. This is management information, not an accounting or finance-approved valuation. Consumable stock carries no cost in this release.'];
    }
}
