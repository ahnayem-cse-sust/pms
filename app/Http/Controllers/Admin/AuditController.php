<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\LoginHistory;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function logs(Request $r)
    {
        $logs = AuditLog::with('user')
            ->when($r->event, fn ($q, $v) => $q->where('event', 'like', "%$v%"))
            ->when($r->user_id, fn ($q, $v) => $q->where('user_id', $v))
            ->latest('id')->paginate(40)->withQueryString();
        return view('admin.audit', compact('logs'));
    }

    public function logins()
    {
        $logins = LoginHistory::latest('id')->paginate(40);
        return view('admin.logins', compact('logins'));
    }
}
