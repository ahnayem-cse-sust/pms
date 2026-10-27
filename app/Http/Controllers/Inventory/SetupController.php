<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Asset types (level 1) → categories (level 2) → sub categories (level 3), all in one table. */
class SetupController extends InvController
{
    protected array $levels = ['types' => 1, 'categories' => 2, 'subcategories' => 3];

    protected function level(string $kind): int { abort_unless(isset($this->levels[$kind]), 404); return $this->levels[$kind]; }

    public function index(Request $r, string $kind = 'types')
    {
        $level = $this->level($kind);
        $rows = Category::with('parent.parent')->where('level', $level)->orderBy('name')->get()->sortBy(fn ($c) => ($c->parent?->parent?->name ?? '').'|'.($c->parent->name ?? '').'|'.$c->name)->values();
        $parents = $level === 1 ? collect() : Category::with('parent')->where('level', $level - 1)->where('is_active', true)->orderBy('name')->get();

        return view('inventory.setup', ['kind' => $kind, 'level' => $level, 'rows' => $rows, 'parents' => $parents, 'edit' => $r->edit ? Category::where('level', $level)->find($r->edit) : null]);
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
}
