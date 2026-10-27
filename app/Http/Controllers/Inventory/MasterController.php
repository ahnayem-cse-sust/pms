<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Asset, Category, Item, Location, Lookup, StockBalance};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/** Items, categories, locations and the small reference lists (brands, units, conditions, suppliers) on one screen. */
class MasterController extends InvController
{
    protected function types(): array
    {
        return ['items' => 'Items', 'categories' => 'Categories', 'locations' => 'Locations & stores'] + config('inventory.lookup_types');
    }

    protected function model(string $type): string
    {
        return match ($type) { 'items' => Item::class, 'categories' => Category::class, 'locations' => Location::class, default => Lookup::class };
    }

    /** field => [label, kind, options|null]; kinds: text, number, select, checkbox, textarea */
    protected function fields(string $type): array
    {
        $opt = fn ($c, $f = 'name') => $c->mapWithKeys(fn ($x) => [$x->id => $x->{$f}])->all();
        return match (true) {
            $type === 'items' => [
                'code' => ['Item code', 'text'], 'name' => ['Name', 'text'], 'type' => ['Inventory type', 'select', config('inventory.item_types')],
                'category_id' => ['Category', 'select', $opt($this->categories())],
                'subcategory_id' => ['Sub-category', 'select', $opt(Category::active()->whereNotNull('parent_id')->orderBy('name')->get()), true],
                'unit_id' => ['Unit', 'select', $opt($this->lookup('unit')), true], 'brand_id' => ['Brand', 'select', $opt($this->lookup('brand')), true],
                'model' => ['Model', 'text', null, true], 'min_stock' => ['Minimum stock', 'number', null, true], 'reorder_level' => ['Reorder level', 'number', null, true],
                'description' => ['Description', 'textarea', null, true], 'specs' => ['Specifications', 'textarea', null, true],
            ],
            $type === 'categories' => ['name' => ['Name', 'text'], 'parent_id' => ['Parent category (blank = top level)', 'select', $opt($this->categories()), true]],
            $type === 'locations' => [
                'code' => ['Code', 'text'], 'name' => ['Name', 'text'],
                'parent_id' => ['Parent (site / building / floor / room)', 'select', Location::active()->orderBy('name')->get()->mapWithKeys(fn ($l) => [$l->id => $l->path])->all(), true],
                'is_store' => ['This is a store', 'checkbox', null, true], 'description' => ['Description', 'text', null, true],
            ],
            default => ['name' => ['Name', 'text']],
        };
    }

    public function index(Request $r, string $type = 'items')
    {
        abort_unless(isset($this->types()[$type]), 404);
        $model = $this->model($type);
        $rows = $model::query()
            ->when($type === 'items', fn ($q) => $q->with(['category', 'subcategory', 'unit', 'brand']))
            ->when(in_array($type, array_keys(config('inventory.lookup_types'))), fn ($q) => $q->where('type', $type))
            ->when($type === 'categories', fn ($q) => $q->with('parent'))
            ->when($type === 'locations', fn ($q) => $q->with('parent'))
            ->when($r->q, fn ($q, $s) => $q->where('name', 'like', "%$s%"))
            ->orderBy('name')->paginate(25)->withQueryString();
        $edit = $r->edit ? $model::find($r->edit) : null;

        return view('inventory.master', ['type' => $type, 'types' => $this->types(), 'fields' => $this->fields($type), 'rows' => $rows, 'edit' => $edit]);
    }

    protected function rules(string $type, Request $r, ?int $id = null): array
    {
        $uniq = fn (string $table, string $col) => Rule::unique($table, $col)->ignore($id);
        return match (true) {
            $type === 'items' => [
                'code' => ['required', 'string', 'max:40', $uniq('inv_items', 'code')], 'name' => 'required|string|max:255',
                'type' => 'required|in:ASSET,CONSUMABLE', 'category_id' => 'required|exists:inv_categories,id',
                'subcategory_id' => 'nullable|exists:inv_categories,id', 'unit_id' => 'nullable|exists:inv_lookups,id', 'brand_id' => 'nullable|exists:inv_lookups,id',
                'model' => 'nullable|string|max:255', 'min_stock' => 'nullable|numeric|min:0', 'reorder_level' => 'nullable|numeric|min:0',
                'description' => 'nullable|string|max:2000', 'specs' => 'nullable|string|max:4000',
            ],
            $type === 'categories' => ['name' => ['required', 'string', 'max:255', Rule::unique('inv_categories', 'name')->ignore($id)
                ->where(fn ($q) => $r->parent_id ? $q->where('parent_id', $r->parent_id) : $q->whereNull('parent_id'))], 'parent_id' => 'nullable|exists:inv_categories,id'],
            $type === 'locations' => ['code' => ['required', 'string', 'max:30', $uniq('inv_locations', 'code')], 'name' => 'required|string|max:255',
                'parent_id' => 'nullable|exists:inv_locations,id', 'description' => 'nullable|string|max:255'],
            default => ['name' => ['required', 'string', 'max:255', Rule::unique('inv_lookups', 'name')->ignore($id)->where('type', $type)]],
        };
    }

    protected function check(string $type, array $d, ?int $id = null): void
    {
        if ($type === 'items') {
            if (! empty($d['subcategory_id']) && Category::whereKey($d['subcategory_id'])->value('parent_id') != $d['category_id']) {
                throw ValidationException::withMessages(['subcategory_id' => 'The sub-category does not belong to the chosen category.']);
            }
            if ($id && ($old = Item::find($id)) && $old->type !== $d['type'] && (Asset::where('item_id', $id)->exists() || StockBalance::where('item_id', $id)->exists())) {
                throw ValidationException::withMessages(['type' => 'The inventory type cannot change once the item has assets or stock movements.']);
            }
        }
        if ($id && in_array($type, ['categories', 'locations']) && isset($d['parent_id']) && (int) $d['parent_id'] === $id) {
            throw ValidationException::withMessages(['parent_id' => 'A record cannot be its own parent.']);
        }
    }

    public function store(Request $r, string $type)
    {
        abort_unless(isset($this->types()[$type]), 404);
        $d = $r->validate($this->rules($type, $r));
        $this->check($type, $d);
        $d['is_active'] = true;
        if ($type === 'locations') $d['is_store'] = $r->boolean('is_store');
        if ($type === 'items') $d += ['created_by' => auth()->id(), 'min_stock' => $d['min_stock'] ?? 0, 'reorder_level' => $d['reorder_level'] ?? 0];
        if (isset($this->types()[$type]) && ! in_array($type, ['items', 'categories', 'locations'])) $d['type'] = $type;
        $row = $this->model($type)::create($d);
        $this->audit("master.$type.created", $row, null, $d);

        return redirect()->route('inv.master', $type)->with('ok', 'Added.');
    }

    public function update(Request $r, string $type, int $id)
    {
        abort_unless(isset($this->types()[$type]), 404);
        $row = $this->model($type)::findOrFail($id);
        $d = $r->validate($this->rules($type, $r, $id));
        $this->check($type, $d, $id);
        $d['is_active'] = $r->boolean('is_active');
        if ($type === 'locations') $d['is_store'] = $r->boolean('is_store');
        if ($type === 'items') $d += ['min_stock' => $d['min_stock'] ?? 0, 'reorder_level' => $d['reorder_level'] ?? 0];
        $old = $row->only(array_keys($d));
        $row->update($d);
        $this->audit("master.$type.updated", $row, $old, $d);   // history of master-data changes (Transaction audit report)

        return redirect()->route('inv.master', $type)->with('ok', 'Saved.');
    }
}
