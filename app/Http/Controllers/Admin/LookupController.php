<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Location;
use App\Models\TicketCategory;
use App\Models\TicketPriority;
use App\Models\TicketSubcategory;
use Illuminate\Http\Request;

/** One generic CRUD screen for all small configurable lists. */
class LookupController extends Controller
{
    protected function defs(): array
    {
        return [
            'departments' => ['model' => Department::class, 'label' => 'Departments', 'fields' => [
                'name' => ['text', 'required|string|max:150'], 'code' => ['text', 'required|string|max:20'],
            ]],
            'designations' => ['model' => Designation::class, 'label' => 'Designations', 'fields' => [
                'name' => ['text', 'required|string|max:150'],
            ]],
            'locations' => ['model' => Location::class, 'label' => 'Locations', 'fields' => [
                'name' => ['text', 'required|string|max:150'],
            ]],
            'categories' => ['model' => TicketCategory::class, 'label' => 'Request Categories', 'fields' => [
                'name' => ['text', 'required|string|max:150'], 'sort_order' => ['number', 'nullable|integer|min:0'],
            ]],
            'subcategories' => ['model' => TicketSubcategory::class, 'label' => 'Sub-categories', 'with' => 'category', 'fields' => [
                'category_id' => ['select:categories', 'required|exists:ticket_categories,id'],
                'name' => ['text', 'required|string|max:150'],
            ]],
            'priorities' => ['model' => TicketPriority::class, 'label' => 'Priorities & SLA (minutes)', 'admin' => true, 'fields' => [
                'name' => ['text', 'required|string|max:50'], 'level' => ['number', 'required|integer|min:1|max:20'],
                'color' => ['text', 'nullable|string|max:20'],
                'response_minutes' => ['number', 'nullable|integer|min:1'],
                'resolution_minutes' => ['number', 'nullable|integer|min:1'],
            ]],
        ];
    }

    protected function def(string $type): array
    {
        $d = $this->defs()[$type] ?? abort(404);
        abort_if(($d['admin'] ?? false) && ! auth()->user()->can('settings.manage'), 403);
        return $d;
    }

    public function index(string $type)
    {
        $def = $this->def($type);
        $rows = $def['model']::query()->when($def['with'] ?? null, fn ($q, $w) => $q->with($w))->orderBy('id')->get();
        $selects = ['categories' => TicketCategory::orderBy('name')->pluck('name', 'id')];
        $tabs = collect($this->defs())->filter(fn ($d) => ! ($d['admin'] ?? false) || auth()->user()->can('settings.manage'))->map->label;
        return view('admin.lookups', compact('type', 'def', 'rows', 'selects', 'tabs'));
    }

    public function store(Request $r, string $type)
    {
        $def = $this->def($type);
        $d = $r->validate(collect($def['fields'])->map(fn ($f) => $f[1])->all());
        $row = $def['model']::create($d);
        AuditLog::record("lookup.$type.created", $row, null, $d);
        return back()->with('ok', 'Added.');
    }

    public function update(Request $r, string $type, int $id)
    {
        $def = $this->def($type);
        $row = $def['model']::findOrFail($id);
        $d = $r->validate(collect($def['fields'])->map(fn ($f) => $f[1])->all());
        $d['is_active'] = $r->boolean('is_active');
        $old = $row->only(array_keys($d));
        $row->update($d);
        AuditLog::record("lookup.$type.updated", $row, $old, $d);
        return back()->with('ok', 'Saved.');
    }
}
