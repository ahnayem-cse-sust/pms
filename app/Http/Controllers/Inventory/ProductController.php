<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Asset, Product};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/** Products and their stock levels on one screen. */
class ProductController extends InvController
{
    public function index(Request $r)
    {
        $rows = Product::with('category')->withSum('stock as on_hand_sum', 'qty')
            ->withCount(['assets as in_stock_count' => fn ($q) => $q->where('status', 'AVAILABLE'), 'assets as allocated_count' => fn ($q) => $q->where('status', 'ALLOCATED')])
            ->with('stock.location')
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('name', 'like', "%$s%")->orWhere('code', 'like', "%$s%")->orWhere('brand', 'like', "%$s%")->orWhere('model', 'like', "%$s%")))
            ->when($r->category_id, fn ($q, $v) => $q->where('category_id', $v))
            ->when($r->type, fn ($q, $v) => $q->where('type', $v))
            ->when(! $r->boolean('inactive'), fn ($q) => $q->where('is_active', true))->orderBy('name')->get();
        if ($r->boolean('low')) $rows = $rows->filter(fn ($p) => $p->type === 'CONSUMABLE' && (float) $p->min_stock > 0 && (float) $p->on_hand_sum <= (float) $p->min_stock)->values();

        $on = fn ($p) => $p->type === 'ASSET' ? (float) $p->in_stock_count : (float) $p->on_hand_sum;
        if ($r->input('format') === 'csv') {
            return $this->csv('stock', ['Code', 'Product', 'Category', 'Type', 'Brand', 'Model', 'In stock', 'Allocated units', 'Minimum', 'Unit'],
                $rows->map(fn ($p) => [$p->code, $p->name, $p->category->name ?? '', $p->type, $p->brand, $p->model, $on($p), $p->type === 'ASSET' ? $p->allocated_count : '', $p->min_stock, $p->unit]));
        }

        return view('inventory.products.index', ['rows' => $rows, 'categories' => $this->categories(), 'locations' => $this->locations()]);
    }

    protected function rules(?Product $p = null): array
    {
        return ['code' => ['required', 'string', 'max:40', Rule::unique('inv_products', 'code')->ignore($p?->id)], 'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:inv_categories,id', 'type' => 'required|in:ASSET,CONSUMABLE', 'brand' => 'nullable|string|max:255', 'model' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:30', 'min_stock' => 'nullable|numeric|min:0', 'notes' => 'nullable|string|max:2000'];
    }

    public function create() { return view('inventory.products.form', ['product' => new Product(['type' => 'CONSUMABLE', 'is_active' => true]), 'categories' => $this->categories()]); }
    public function edit(Product $product) { return view('inventory.products.form', ['product' => $product, 'categories' => $this->categories()]); }

    public function store(Request $r)
    {
        $d = $r->validate($this->rules());
        $p = Product::create($d + ['min_stock' => $d['min_stock'] ?? 0, 'is_active' => true]);
        $this->audit('product.created', $p, null, ['code' => $p->code]);

        return redirect()->route('inv.products.index')->with('ok', "{$p->name} added.");
    }

    public function update(Request $r, Product $product)
    {
        $d = $r->validate($this->rules($product));
        if ($d['type'] !== $product->type && ($product->assets()->exists() || $product->stock()->exists())) {
            throw ValidationException::withMessages(['type' => 'The type cannot change once the product has stock or units.']);
        }
        $d['is_active'] = $r->boolean('is_active');
        $old = $product->only(array_keys($d));
        $product->update($d + ['min_stock' => $d['min_stock'] ?? 0]);
        $this->audit('product.updated', $product, $old, $d);

        return redirect()->route('inv.products.index')->with('ok', 'Saved.');
    }

    /** Direct stock correction for a consumable, with a reason; recorded in the movement log. */
    public function adjust(Request $r, Product $product)
    {
        $d = $r->validate(['location_id' => 'required|exists:inv_locations,id', 'qty' => 'required|numeric|not_in:0', 'reason' => 'required|string|max:500']);
        $this->svc()->adjust($product, (int) $d['location_id'], (float) $d['qty'], $d['reason']);

        return back()->with('ok', 'Stock corrected and recorded.');
    }
}
