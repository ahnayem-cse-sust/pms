<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings', ['settings' => SystemSetting::orderBy('group')->orderBy('key')->get()]);
    }

    public function update(Request $r)
    {
        $r->validate(['settings' => 'required|array', 'settings.*' => 'nullable|string|max:500']);
        foreach ($r->settings as $key => $value) {
            $s = SystemSetting::where('key', $key)->first();
            if ($s && $s->value !== $value) {
                AuditLog::record('setting.updated', $s, ['value' => $s->value], ['value' => $value]);
                $s->update(['value' => $value]);
            }
        }
        return back()->with('ok', 'Settings saved.');
    }
}
