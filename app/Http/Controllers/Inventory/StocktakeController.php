<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Stocktake, StocktakeLine};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StocktakeController extends InvController
{
    public function index(Request $r)
    {
        $rows = Stocktake::with(['location', 'category', 'creator'])->withCount('lines')->when($r->status, fn ($q, $v) => $q->where('status', $v))->latest('id')->paginate(25)->withQueryString();

        return view('inventory.stocktakes.index', ['rows' => $rows, 'locations' => $this->locations(), 'categories' => $this->categories()]);
    }

    public function store(Request $r)
    {
        $d = $r->validate(['title' => 'required|string|max:255', 'count_date' => 'required|date', 'location_id' => 'nullable|exists:inv_locations,id', 'category_id' => 'nullable|exists:inv_categories,id', 'notes' => 'nullable|string|max:1000']);
        $s = DB::transaction(function () use ($d) {
            $s = Stocktake::create($d + ['ref' => $this->svc()->ref('stocktake'), 'status' => 'OPEN', 'created_by' => auth()->id()]);
            $this->svc()->buildStocktake($s);
            $this->audit('stocktake.created', $s, null, ['ref' => $s->ref]);
            return $s;
        });
        if (! $s->lines()->exists()) {
            $s->update(['status' => 'CANCELLED']);
            throw ValidationException::withMessages(['title' => 'Nothing matches that scope (no stock balances or assets), so the stocktake was not started.']);
        }

        return redirect()->route('inv.stocktakes.show', $s)->with('ok', "{$s->ref} started with {$s->lines()->count()} lines.");
    }

    public function show(Stocktake $stocktake)
    {
        $stocktake->load(['location', 'category', 'creator', 'approver']);
        $lines = $stocktake->lines()->with(['item.unit', 'asset', 'location'])->orderBy('id')->get();

        return view('inventory.stocktakes.show', ['s' => $stocktake, 'lines' => $lines, 'conditions' => $this->lookup('condition')]);
    }

    public function act(Request $r, Stocktake $stocktake, string $action)
    {
        $u = auth()->user();
        switch ($action) {
            case 'save':
                $this->authorize('inv.stocktake.update');
                abort_unless($stocktake->status === 'OPEN', 422);
                foreach ((array) $r->input('lines', []) as $id => $v) {
                    $l = $stocktake->lines()->whereKey($id)->first();
                    if (! $l) continue;
                    $set = ['remarks' => $v['remarks'] ?? null, 'condition_id' => ($v['condition_id'] ?? null) ?: null];
                    if ($l->asset_id) {
                        $st = $v['physical_status'] ?? '';
                        if (! in_array($st, ['', 'FOUND', 'MISSING', 'MOVED'], true)) continue;
                        $set += ['physical_status' => $st ?: null];
                        $has = (bool) $st;
                    } else {
                        $q = $v['physical_qty'] ?? '';
                        if ($q !== '' && (! is_numeric($q) || $q < 0)) throw ValidationException::withMessages(['lines' => 'Counts must be zero or more.']);
                        $set += ['physical_qty' => $q === '' ? null : $q];
                        $has = $q !== '';
                    }
                    if ($has) $set += ['verified_by' => $u->id, 'verified_at' => now()];
                    $l->update($set);
                }
                break;
            case 'unrecorded':
                $this->authorize('inv.stocktake.update');
                abort_unless($stocktake->status === 'OPEN', 422);
                $d = $r->validate(['unrecorded_desc' => 'required|string|max:255', 'location_id' => 'nullable|exists:inv_locations,id']);
                StocktakeLine::create(['stocktake_id' => $stocktake->id, 'unrecorded_desc' => $d['unrecorded_desc'], 'location_id' => $d['location_id'] ?? null, 'physical_status' => 'FOUND', 'verified_by' => $u->id, 'verified_at' => now()]);
                break;
            case 'review':
                $this->authorize('inv.stocktake.update');
                abort_unless($stocktake->status === 'OPEN', 422);
                $left = $stocktake->lines()->whereNull('unrecorded_desc')->where(fn ($q) => $q->where(fn ($w) => $w->whereNotNull('asset_id')->whereNull('physical_status'))
                    ->orWhere(fn ($w) => $w->whereNull('asset_id')->whereNull('physical_qty')))->count();
                if ($left) throw ValidationException::withMessages(['lines' => "$left line(s) still have no physical result. Record every line before submitting for review."]);
                $stocktake->update(['status' => 'REVIEW']);
                break;
            case 'reopen':
                $this->authorize('inv.stocktake.approve');
                abort_unless($stocktake->status === 'REVIEW', 422);
                $stocktake->update(['status' => 'OPEN']);
                break;
            case 'approve':
                $this->authorize('inv.stocktake.approve');
                $this->svc()->approveStocktake($stocktake);
                break;
            case 'cancel':
                abort_unless($u->hasPermission('inv.stocktake.create') || $u->hasPermission('inv.stocktake.approve'), 403);
                abort_unless(in_array($stocktake->status, ['OPEN', 'REVIEW'], true), 422);
                $stocktake->update(['status' => 'CANCELLED']);
                break;
            default:
                abort(404);
        }
        $this->audit("stocktake.$action", $stocktake, null, ['ref' => $stocktake->ref, 'status' => $stocktake->fresh()->status]);

        return back()->with('ok', 'Done.');
    }
}
