<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Inventory\{Category, Equipment};
use App\Models\User;
use App\Services\Inventory\InventoryService;

abstract class InvController extends Controller
{
    protected function svc(): InventoryService { return app(InventoryService::class); }
    protected function types() { return Category::where('level', 1)->where('is_active', true)->orderBy('name')->get(['id', 'name']); }
    protected function categories() { return Category::where('level', 2)->where('is_active', true)->orderBy('name')->get(['id', 'name', 'parent_id']); }
    protected function subcategories() { return Category::where('level', 3)->where('is_active', true)->orderBy('name')->get(['id', 'name', 'parent_id']); }
    protected function equipment() { return Equipment::with('category')->where('is_active', true)->orderBy('name')->get(); }
    protected function people() { return User::active()->orderBy('name')->get(['id', 'name', 'employee_id', 'department_id']); }
    protected function departments() { return Department::where('is_active', true)->orderBy('name')->get(); }

    protected function audit(string $event, $model, ?array $old = null, ?array $new = null): void
    {
        AuditLog::record('inventory.'.$event, $model, $old, $new);
    }

    /** CSV download (opens in Excel). */
    protected function csv(string $name, array $head, iterable $rows)
    {
        return response()->streamDownload(function () use ($head, $rows) {
            $o = fopen('php://output', 'w');
            fwrite($o, "\xEF\xBB\xBF");
            fputcsv($o, $head);
            foreach ($rows as $r) fputcsv($o, $r);
            fclose($o);
        }, $name.'_'.now()->format('Ymd_His').'.csv', ['Content-Type' => 'text/csv']);
    }
}
