<?php

namespace App\Http\Controllers\Inventory;

use App\Models\AuditLog;
use Illuminate\Http\Request;

/** Transaction audit report: the shared audit log, limited to inventory events. */
class AuditController extends InvController
{
    public function index(Request $r)
    {
        $rows = AuditLog::with('user')->where('event', 'like', 'inventory.%')
            ->when($r->event, fn ($q, $v) => $q->where('event', 'like', 'inventory.'.$v.'%'))
            ->when($r->user_id, fn ($q, $v) => $q->where('user_id', $v))
            ->when($r->from, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))->when($r->to, fn ($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->latest('id')->paginate(40)->withQueryString();

        if ($r->input('format') === 'csv') {
            return response()->streamDownload(function () use ($r) {
                $o = fopen('php://output', 'w');
                fwrite($o, "\xEF\xBB\xBF");
                fputcsv($o, ['When', 'User', 'Event', 'Record', 'Old', 'New', 'IP']);
                AuditLog::with('user')->where('event', 'like', 'inventory.%')->orderBy('id')->chunk(500, function ($c) use ($o) {
                    foreach ($c as $l) fputcsv($o, [$l->created_at, $l->user->name ?? '', $l->event, $l->auditable_type.'#'.$l->auditable_id, json_encode($l->old_values), json_encode($l->new_values), $l->ip_address]);
                });
                fclose($o);
            }, 'inventory_audit_'.now()->format('Ymd').'.csv', ['Content-Type' => 'text/csv']);
        }

        return view('inventory.audit', ['rows' => $rows, 'people' => $this->people()]);
    }
}
