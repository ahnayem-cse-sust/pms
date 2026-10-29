<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Category, Equipment};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Asset types (level 1) → categories (level 2) → sub categories (level 3), all in one table. */
class SetupController extends InvController
{
    protected array $levels = ['types' => 1, 'categories' => 2, 'subcategories' => 3];

    protected function level(string $kind): int { abort_unless(isset($this->levels[$kind]), 404); return $this->levels[$kind]; }

    /** Equipment column that points at each level. */
    protected array $equipmentColumn = [1 => 'asset_type_id', 2 => 'category_id', 3 => 'subcategory_id'];

    public function index(Request $r, string $kind = 'types')
    {
        $level = $this->level($kind);
        $typeId = $r->integer('type_id') ?: null;
        $categoryId = $r->integer('category_id') ?: null;

        $rows = Category::with('parent.parent')->where('level', $level)
            ->when($level === 2 && $typeId, fn ($q) => $q->where('parent_id', $typeId))
            ->when($level === 3 && $categoryId, fn ($q) => $q->where('parent_id', $categoryId))
            ->when($level === 3 && $typeId && ! $categoryId, fn ($q) => $q->whereHas('parent', fn ($p) => $p->where('parent_id', $typeId)))
            ->orderBy('name')->get()
            ->sortBy(fn ($c) => ($c->parent?->parent?->name ?? '').'|'.($c->parent->name ?? '').'|'.$c->name)->values();
        $parents = $level === 1 ? collect() : Category::with('parent')->where('level', $level - 1)->where('is_active', true)->orderBy('name')->get();

        // how much each row is used (equipment) or holds (children): a row can be deleted only when both are zero
        $items = Equipment::selectRaw($this->equipmentColumn[$level].' as cid, COUNT(*) as n')->whereIn($this->equipmentColumn[$level], $rows->pluck('id'))->groupBy($this->equipmentColumn[$level])->pluck('n', 'cid');
        $kids = Category::selectRaw('parent_id, COUNT(*) as n')->whereIn('parent_id', $rows->pluck('id'))->groupBy('parent_id')->pluck('n', 'parent_id');
        $counts = Category::selectRaw('level, COUNT(*) as n')->groupBy('level')->pluck('n', 'level');

        return view('inventory.setup', ['kind' => $kind, 'level' => $level, 'rows' => $rows, 'parents' => $parents, 'items' => $items, 'kids' => $kids, 'counts' => $counts,
            'filterTypes' => Category::where('level', 1)->orderBy('name')->get(['id', 'name']),
            'filterCategories' => Category::with('parent')->where('level', 2)->orderBy('name')->get(),
            'typeId' => $typeId, 'categoryId' => $categoryId,
            'edit' => $r->edit ? Category::where('level', $level)->find($r->edit) : null]);
    }

    protected function rules(int $level, Request $r, ?int $id = null): array
    {
        $parent = $level > 1 ? $r->parent_id : null;

        return ['name' => ['required', 'string', 'max:255', Rule::unique('inv_categories', 'name')->ignore($id)->where('level', $level)->where(fn ($q) => $parent ? $q->where('parent_id', $parent) : $q->whereNull('parent_id'))],
            'parent_id' => $level > 1 ? ['required', Rule::exists('inv_categories', 'id')->where('level', $level - 1)] : 'nullable'];
    }

    public function store(Request $r, string $kind)
    {
        $level = $this->level($kind);
        $d = $r->validate($this->rules($level, $r));
        $d['is_serialized'] = $level === 2 && $r->boolean('is_serialized');   // the serial mark only exists on categories
        $c = Category::create(['name' => $d['name'], 'parent_id' => $level > 1 ? $d['parent_id'] : null, 'level' => $level, 'is_active' => true, 'is_serialized' => $d['is_serialized']]);
        $this->audit("setup.$kind.created", $c, null, $d);

        return redirect()->route('inv.setup', $kind)->with('ok', 'Added.');
    }

    public function update(Request $r, string $kind, int $id)
    {
        $level = $this->level($kind);
        $c = Category::where('level', $level)->findOrFail($id);
        $d = $r->validate($this->rules($level, $r, $id));
        $d['is_active'] = $r->boolean('is_active');
        $d['is_serialized'] = $level === 2 ? $r->boolean('is_serialized') : false;
        $old = $c->only(['name', 'parent_id', 'is_active', 'is_serialized']);
        $c->update(['name' => $d['name'], 'parent_id' => $level > 1 ? $d['parent_id'] : null, 'is_active' => $d['is_active'], 'is_serialized' => $d['is_serialized']]);
        $this->audit("setup.$kind.updated", $c, $old, $d);

        return redirect()->route('inv.setup', $kind)->with('ok', 'Saved.');
    }

    /** Delete an asset type / category / sub category, only when no equipment uses it and nothing sits under it. */
    public function destroy(string $kind, int $id)
    {
        $level = $this->level($kind);
        $c = Category::where('level', $level)->findOrFail($id);

        $used = Equipment::where($this->equipmentColumn[$level], $c->id)->count();
        if ($used) {
            return redirect()->back()->with('error', "“{$c->name}” is used by {$used} equipment ".\Illuminate\Support\Str::plural('item', $used).' and cannot be deleted. Mark it Inactive instead.');
        }
        $children = $c->children()->count();
        if ($children) {
            $what = $level === 1 ? 'categories' : 'sub categories';
            return redirect()->back()->with('error', "“{$c->name}” still has {$children} {$what}. Delete them first.");
        }

        $old = $c->only(['name', 'parent_id', 'level', 'is_active', 'is_serialized']);
        $c->delete();
        $this->audit("setup.$kind.deleted", $c, $old, null);

        return redirect()->back()->with('ok', 'Deleted.');
    }
}
