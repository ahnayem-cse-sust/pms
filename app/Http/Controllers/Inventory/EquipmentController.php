<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Category, Equipment, Movement};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/** Equipment list with stock levels; add / edit equipment. Stock itself only changes through Receives and Allocations. */
class EquipmentController extends InvController
{
    protected array $with = ['assetType', 'category', 'subcategory'];

    public function index(Request $r)
    {
        // one tab at a time; In stock is the default (links from the dashboard that search by code or ask for low / out stock open the Active list,
        // so equipment without stock is still found). In stock / Low / Out of stock look at the active list only.
        $default = ($r->boolean('low') || filled($r->q)) ? 'active' : 'instock';
        $tab = in_array($r->tab, ['all', 'active', 'inactive', 'instock', 'low', 'out'], true) ? $r->tab : $default;
        $lowSql = fn ($q) => $q->where('stock_qty', '>', 0)->where('min_stock', '>', 0)->whereColumn('stock_qty', '<=', 'min_stock');

        $query = Equipment::with($this->with)
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('name', 'like', "%$s%")->orWhere('code', 'like', "%$s%")->orWhere('brand', 'like', "%$s%")->orWhere('model', 'like', "%$s%")))
            ->when($r->asset_type_id, fn ($q, $v) => $q->where('asset_type_id', $v))->when($r->category_id, fn ($q, $v) => $q->where('category_id', $v))
            ->when($r->subcategory_id, fn ($q, $v) => $q->where('subcategory_id', $v))
            ->when($r->boolean('low'), fn ($q) => $q->where('min_stock', '>', 0)->whereColumn('stock_qty', '<=', 'min_stock'))   // dashboard link: low or out
            ->when($tab === 'instock', fn ($q) => $q->where('stock_qty', '>', 0))
            ->when($tab === 'low', $lowSql)
            ->when($tab === 'out', fn ($q) => $q->where('stock_qty', '<=', 0))
            ->when($tab === 'inactive', fn ($q) => $q->notLive())
            ->when(in_array($tab, ['active', 'instock', 'low', 'out'], true), fn ($q) => $q->selectable())   // active = active item under active type, category and sub category
            ->orderBy('name');

        if ($r->input('format') === 'csv') {
            $rows = $query->get();

            return $this->csv('equipment_stock', ['Equipment ID', 'Equipment', 'Asset type', 'Category', 'Sub category', 'Serialisable', 'Brand', 'Model', 'In stock', 'Unit'],
                $rows->map(fn ($e) => [$e->code, $e->name, $e->assetType->name ?? '', $e->category->name ?? '', $e->subcategory->name ?? '', $e->is_serialized ? 'Yes' : 'No', $e->brand, $e->model, $e->stock_qty, $e->unit]));
        }

        $live = fn () => Equipment::selectable();
        $tabs = ['all' => Equipment::count(), 'active' => $live()->count(), 'inactive' => Equipment::notLive()->count(),
            'instock' => $live()->where('stock_qty', '>', 0)->count(), 'low' => $lowSql($live())->count(), 'out' => $live()->where('stock_qty', '<=', 0)->count()];

        return view('inventory.equipment.index', ['rows' => $query->paginate(15)->withQueryString(), 'tabs' => $tabs, 'tab' => $tab,
            'types' => $this->types(), 'cats' => $this->categories(), 'subs' => $this->subcategories()]);
    }

    public function show(Request $request, Equipment $equipment)
    {
        $equipment->load($this->with);
        // Both histories list whole entries (AL-… / RC-…): one row per entry showing every item in it, not just this equipment's line.
        // Allocations and returns go out to / come back from people; receives (and previous-item openings) bring stock in.
        // Old "Correction" rows (no entry number) follow the direction of the quantity and stand alone.
        $with = ['equipment', 'user', 'holderUser.department', 'holderDepartment', 'holderSection.department'];
        $key = 'COALESCE(entry_no, ref)';
        $history = function (array $types, \Closure $scope, string $page, string $tab) use ($equipment, $with, $key) {
            $entries = Movement::where('equipment_id', $equipment->id)->where($scope)
                ->selectRaw("$key as ekey, MAX(id) as last_id")->groupByRaw($key)->orderByDesc('last_id')
                ->paginate(15, ['*'], $page)->withQueryString()->appends(['tab' => $tab]);
            $keys = $entries->pluck('ekey')->all();
            $lines = Movement::with($with)->whereIn('type', $types)
                ->where(fn ($q) => $q->whereIn('entry_no', $keys)->orWhere(fn ($w) => $w->whereNull('entry_no')->whereIn('ref', $keys)))
                ->orderBy('id')->get()->groupBy(fn ($m) => $m->entry_no ?? $m->ref);

            return [$entries, $lines];
        };
        [$allocations, $allocLines] = $history(['ALLOCATE', 'RETURN', 'ADJUST'], fn ($q) => $q->whereIn('type', ['ALLOCATE', 'RETURN'])->orWhere(fn ($w) => $w->where('type', 'ADJUST')->where('qty', '<', 0)), 'alloc_page', 'allocation');
        [$receives, $recvLines] = $history(['RECEIVE', 'OPENING', 'ADJUST'], fn ($q) => $q->whereIn('type', ['RECEIVE', 'OPENING'])->orWhere(fn ($w) => $w->where('type', 'ADJUST')->where('qty', '>=', 0)), 'recv_page', 'receive');

        return view('inventory.equipment.show', ['e' => $equipment, 'allocations' => $allocations, 'allocLines' => $allocLines, 'receives' => $receives, 'recvLines' => $recvLines, 'tab' => $request->input('tab') === 'receive' ? 'receive' : 'allocation']);
    }

    protected function rules(?Equipment $e = null): array
    {
        return ['name' => 'required|string|max:255',   // the code is generated by the system and never typed or changed
            'asset_type_id' => ['required', Rule::exists('inv_categories', 'id')->where('level', 1)],
            'category_id' => ['required', Rule::exists('inv_categories', 'id')->where('level', 2)],
            'subcategory_id' => ['nullable', Rule::exists('inv_categories', 'id')->where('level', 3)],
            'brand' => 'nullable|string|max:255', 'model' => 'nullable|string|max:255', 'unit' => 'nullable|string|max:30', 'notes' => 'nullable|string|max:2000'];
    }

    /** Category must sit under the asset type, sub category under the category. */
    protected function checkTree(array $d, ?Equipment $current = null): void
    {
        $this->checkActive($d, $current);
        if (! empty($d['category_id']) && Category::whereKey($d['category_id'])->value('parent_id') != $d['asset_type_id']) {
            throw ValidationException::withMessages(['category_id' => 'That category does not belong to the chosen asset type.']);
        }
        if (! empty($d['subcategory_id'])) {
            if (empty($d['category_id'])) throw ValidationException::withMessages(['subcategory_id' => 'Choose a category before a sub category.']);
            if (Category::whereKey($d['subcategory_id'])->value('parent_id') != $d['category_id']) {
                throw ValidationException::withMessages(['subcategory_id' => 'That sub category does not belong to the chosen category.']);
            }
        }
    }

    /**
     * A newly chosen asset type / category / sub category must be active, and so must everything above it.
     * Values the record already holds are left alone, so an old record can still be saved after its type goes inactive.
     */
    protected function checkActive(array $d, ?Equipment $current): void
    {
        foreach (['asset_type_id' => 'asset type', 'category_id' => 'category', 'subcategory_id' => 'sub category'] as $field => $label) {
            $id = $d[$field] ?? null;
            if (! $id || ($current && $current->{$field} == $id)) continue;
            $c = Category::with('parent.parent')->find($id);
            for ($n = $c; $n; $n = $n->parent) {
                if (! $n->is_active) throw ValidationException::withMessages([$field => "That $label is inactive, so it cannot be chosen."]);
            }
        }
    }

    protected function form(Equipment $e)
    {
        // an existing record keeps showing what it already has, even if that has since been made inactive
        $keep = $e->exists ? [$e->asset_type_id, $e->category_id, $e->subcategory_id] : [];

        return view('inventory.equipment.form', ['equipment' => $e, 'types' => $this->types($keep), 'cats' => $this->categories($keep), 'subs' => $this->subcategories($keep)]);
    }
    public function create() { return $this->form(new Equipment(['is_active' => true])); }
    public function edit(Equipment $equipment) { return $this->form($equipment); }

    public function store(Request $r)
    {
        $d = $r->validate($this->rules());
        $this->checkTree($d);
        $e = $this->svc()->createEquipment($d + ['is_active' => true]);
        $this->audit('equipment.created', $e, null, ['code' => $e->code]);

        return redirect()->route('inv.equipment.index')->with('ok', "{$e->name} added with code {$e->code}. Receive item to add quantity.");
    }

    public function update(Request $r, Equipment $equipment)
    {
        $d = $r->validate($this->rules($equipment));
        $this->checkTree($d, $equipment);
        $d['is_active'] = $r->boolean('is_active');
        $old = $equipment->only(array_keys($d));
        $equipment->update($d);
        $this->audit('equipment.updated', $equipment, $old, $d);

        return redirect()->route('inv.equipment.show', $equipment)->with('ok', 'Saved.');
    }
}
