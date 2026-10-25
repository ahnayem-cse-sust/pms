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
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'service_types' => ['model' => TicketType::class, 'label' => 'Service Types', 'unique' => ['name', 'code'], 'fields' => [
                'name' => ['text', 'required|string|max:100'], 'code' => ['text', 'required|string|max:10'],
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

    /** Validation rules for a list's fields; fields marked 'unique' must not repeat (ignoring the row being edited). */
    protected function rules(array $def, ?int $ignore = null): array
    {
        $table = (new $def['model'])->getTable();

        return collect($def['fields'])->map(function ($f, $name) use ($def, $table, $ignore) {
            $rule = explode('|', $f[1]);
            if (in_array($name, $def['unique'] ?? [], true)) {
                $rule[] = Rule::unique($table, $name)->ignore($ignore);
            }

            return $rule;
        })->all();
    }

    protected function def(string $type, bool $write = false): array
    {
        $d = $this->defs()[$type] ?? abort(404);
        abort_if(($d['admin'] ?? false) && ! auth()->user()->can($write ? 'settings.update' : 'settings.view'), 403);
        return $d;
    }

    public function index(string $type)
    {
        $def = $this->def($type);
        $rows = $def['model']::query()->when($def['with'] ?? null, fn ($q, $w) => $q->with($w))->orderBy('id')->paginate(25)->withQueryString();
        $selects = ['categories' => TicketCategory::orderBy('name')->pluck('name', 'id')];
        $tabs = collect($this->defs())->filter(fn ($d) => ! ($d['admin'] ?? false) || auth()->user()->can('settings.view'))->map->label;
        $u = auth()->user();
        $writable = ! ($def['admin'] ?? false) || $u->can('settings.update');
        $canAdd = $u->can('lookup.create') && $writable;
        $canEdit = $u->can('lookup.update') && $writable;
        return view('admin.lookups', compact('type', 'def', 'rows', 'selects', 'tabs', 'canAdd', 'canEdit'));
    }

    public function store(Request $r, string $type)
    {
        $def = $this->def($type, true);
        $d = $r->validate($this->rules($def));
        $row = $def['model']::create($d);
        AuditLog::record("lookup.$type.created", $row, null, $d);
        return back()->with('ok', 'Added.');
    }

    public function update(Request $r, string $type, int $id)
    {
        $def = $this->def($type, true);
        $row = $def['model']::findOrFail($id);
        $d = $r->validate($this->rules($def, $id));
        $d['is_active'] = $r->boolean('is_active');
        $old = $row->only(array_keys($d));
        $row->update($d);
        AuditLog::record("lookup.$type.updated", $row, $old, $d);
        return back()->with('ok', 'Saved.');
    }
}
