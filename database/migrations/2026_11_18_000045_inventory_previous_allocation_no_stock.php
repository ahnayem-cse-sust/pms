<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * A previous allocation (item already with someone before this system) no longer creates a hidden stock-in line (type PRIOR).
 * Its ALLOCATE lines carry no_stock = 1 instead and never move stock.
 * Existing data is converted: the ALLOCATE lines that a PRIOR line balanced are flagged, the PRIOR lines are deleted and the
 * running balances are recomputed. Stock quantities do not change (PRIOR + ALLOCATE always netted to zero).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('inv_movements', 'no_stock')) {
            Schema::table('inv_movements', fn (Blueprint $t) => $t->boolean('no_stock')->default(false));
        }

        $prior = DB::table('inv_movements')->where('type', 'PRIOR')->get(['id', 'entry_no', 'equipment_id']);
        if ($prior->isEmpty()) return;

        DB::transaction(function () use ($prior) {
            foreach ($prior->groupBy(fn ($p) => $p->entry_no.'|'.$p->equipment_id) as $g) {
                $f = $g->first();
                DB::table('inv_movements')->where('type', 'ALLOCATE')->where('entry_no', $f->entry_no)->where('equipment_id', $f->equipment_id)->update(['no_stock' => true]);
            }
            DB::table('inv_movements')->whereIn('id', $prior->pluck('id'))->delete();

            foreach ($prior->pluck('equipment_id')->unique() as $equipmentId) {
                $rows = DB::table('inv_movements')->where('equipment_id', $equipmentId)->orderBy('id')->get(['id', 'qty', 'no_stock', 'balance_after']);
                $run = round((float) DB::table('inv_equipment')->where('id', $equipmentId)->value('stock_qty') - (float) $rows->reject(fn ($m) => $m->no_stock)->sum('qty'), 2);
                foreach ($rows as $m) {
                    if (! $m->no_stock) $run = round($run + (float) $m->qty, 2);
                    if (abs((float) $m->balance_after - $run) > 0.001) DB::table('inv_movements')->where('id', $m->id)->update(['balance_after' => $run]);
                }
            }
        });
    }

    public function down(): void
    {
        // The removed PRIOR lines are not restored; the no_stock column is harmless and stays.
    }
};
