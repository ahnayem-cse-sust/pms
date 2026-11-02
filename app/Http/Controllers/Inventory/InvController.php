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
    /**
     * Select options for the three classification levels. A row is offered only when it is active AND every
     * level above it is active: an inactive asset type hides its categories and sub categories, and an inactive
     * category hides its sub categories. $keep lets an edit form still show the values already saved on a record.
     *
     * @param array<int,int|null> $keep category ids that must stay listed even if inactive
     */
    protected function types(array $keep = [])
    {
        return Category::where('level', 1)->where(fn ($q) => $q->where('is_active', true)->orWhereIn('id', array_filter($keep)))
            ->orderBy('name')->get(['id', 'name']);
    }

    protected function categories(array $keep = [])
    {
        return Category::where('level', 2)->where(fn ($q) => $q->where(fn ($a) => $a->where('is_active', true)
                ->whereHas('parent', fn ($p) => $p->where('is_active', true)))->orWhereIn('id', array_filter($keep)))
            ->orderBy('name')->get(['id', 'name', 'parent_id']);
    }

    protected function subcategories(array $keep = [])
    {
        return Category::where('level', 3)->where(fn ($q) => $q->where(fn ($a) => $a->where('is_active', true)
                ->whereHas('parent', fn ($c) => $c->where('is_active', true)->whereHas('parent', fn ($t) => $t->where('is_active', true))))
            ->orWhereIn('id', array_filter($keep)))
            ->orderBy('name')->get(['id', 'name', 'parent_id']);
    }
    protected function equipment() { return Equipment::with('category')->selectable()->orderBy('name')->get(); }

    /** Server-side twin of the equipment picker: refuse lines whose equipment (or its asset type / category / sub category) is inactive. */
    protected function assertSelectable(array $lines): void
    {
        $ids = collect($lines)->pluck('equipment_id')->unique();
        $bad = Equipment::whereIn('id', $ids)->whereNotIn('id', Equipment::selectable()->whereIn('id', $ids)->pluck('id'))->pluck('name');
        if ($bad->isNotEmpty()) {
            throw \Illuminate\Validation\ValidationException::withMessages(['lines' => $bad->implode(', ').' is inactive (the equipment, its asset type, category or sub category), so it cannot be used here.']);
        }
    }
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
