<?php

namespace App\Services\Inventory;

use App\Models\AuditLog;
use App\Models\Inventory\{Category, Equipment, Movement};
use App\Support\Inv;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Simple inventory rules. Every change runs in a DB transaction and leaves one line in inv_movements, so the stock
 * quantity and the record can never disagree. Nothing here touches the ticket tables.
 */
class InventoryService
{
    protected function fail(string $field, string $msg): never
    {
        throw ValidationException::withMessages([$field => $msg]);
    }

    public function ref(): string
    {
        $n = DB::transaction(function () {
            $row = DB::table('inv_counters')->where('name', 'move')->lockForUpdate()->first();
            if (! $row) { DB::table('inv_counters')->insert(['name' => 'move', 'value' => 1]); return 1; }
            DB::table('inv_counters')->where('name', 'move')->update(['value' => $row->value + 1]);
            return $row->value + 1;
        });

        return 'MV-'.str_pad((string) $n, 6, '0', STR_PAD_LEFT);
    }

    /** Entry (document) number shared by every line saved together: RC-000001 for receives, AL-000001 for allocations. */
    public function entryNo(string $prefix): string
    {
        $name = 'entry:'.$prefix;
        $n = DB::transaction(function () use ($name) {
            DB::table('inv_counters')->insertOrIgnore(['name' => $name, 'value' => 0]);
            $v = (int) DB::table('inv_counters')->where('name', $name)->lockForUpdate()->value('value') + 1;
            DB::table('inv_counters')->where('name', $name)->update(['value' => $v]);

            return $v;
        });

        return $prefix.'-'.str_pad((string) $n, 6, '0', STR_PAD_LEFT);
    }

    /** First two letters (any language) of a name, upper-cased; X when the name has no letter (one letter when it has only one). */
    protected function initials(?string $name): string
    {
        preg_match_all('/\p{L}/u', (string) $name, $m);

        return $m[0] ? mb_strtoupper(implode('', array_slice($m[0], 0, 2))) : 'X';
    }

    /**
     * Equipment code = first 2 letters of the asset type + first 2 letters of the category + a running number
     * (COPR0001, COPR0002 …). The length is not fixed: the number has at least 4 digits and simply grows after 9999.
     * The number runs per prefix, is taken under a row lock, and is skipped if a code is already in use (e.g. an old
     * hand-typed one), so a code can never repeat. Call inside a transaction.
     */
    public function nextEquipmentCode(int $assetTypeId, int $categoryId): string
    {
        $prefix = $this->initials(Category::whereKey($assetTypeId)->value('name')).$this->initials(Category::whereKey($categoryId)->value('name'));
        $name = 'code:'.$prefix;

        $seed = Equipment::where('code', 'like', $prefix.'%')->pluck('code')
            ->filter(fn ($c) => preg_match('/^'.preg_quote($prefix, '/').'(\d+)$/u', $c))->map(fn ($c) => (int) mb_substr($c, mb_strlen($prefix)))->max() ?? 0;
        DB::table('inv_counters')->insertOrIgnore(['name' => $name, 'value' => $seed]);
        $n = (int) DB::table('inv_counters')->where('name', $name)->lockForUpdate()->value('value');

        do {
            $n++;
            $code = $prefix.str_pad((string) $n, 4, '0', STR_PAD_LEFT);
        } while (Equipment::where('code', $code)->exists());

        DB::table('inv_counters')->where('name', $name)->update(['value' => $n]);

        return $code;
    }

    /** Create equipment with a system-generated, unique code. */
    public function createEquipment(array $d): Equipment
    {
        return DB::transaction(fn () => Equipment::create(array_diff_key($d, ['code' => 1]) + ['code' => $this->nextEquipmentCode((int) $d['asset_type_id'], (int) $d['category_id'])]));
    }

    /** Move the stock quantity by $delta (locks the row, refuses to go below zero) and write the record line. */
    protected function move(string $type, Equipment $e, float $delta, array $d): Movement
    {
        return DB::transaction(function () use ($type, $e, $delta, $d) {
            $row = Equipment::whereKey($e->id)->lockForUpdate()->firstOrFail();
            // a previous allocation (item already with someone before this system) is recorded but never moves stock
            $new = ! empty($d['no_stock']) ? round((float) $row->stock_qty, 2) : round((float) $row->stock_qty + $delta, 2);
            if ($new < 0) $this->fail('qty', "Not enough {$row->name} in stock (available: ".Inv::qty($row->stock_qty).').');
            if (empty($d['no_stock'])) $row->update(['stock_qty' => $new]);

            return Movement::create($d + ['ref' => $this->ref(), 'moved_on' => today(), 'type' => $type, 'equipment_id' => $row->id, 'qty' => $delta,
                'balance_after' => $new, 'created_by' => auth()->id()]);
        });
    }

    /** @param array<int,array{equipment_id:int,qty:float}> $lines */
    public function receive(array $head, array $lines): string
    {
        return DB::transaction(function () use ($head, $lines) {
            $entry = $this->entryNo('RC');
            foreach ($lines as $l) {
                $this->move('RECEIVE', Equipment::findOrFail($l['equipment_id']), (float) $l['qty'], ['moved_on' => $head['date'], 'party' => $head['supplier'] ?? null,
                    'reference_no' => $head['reference_no'] ?? null, 'remarks' => $head['remarks'] ?? null, 'entry_no' => $entry]);
            }
            AuditLog::record('inventory.stock_in', Equipment::find($lines[0]['equipment_id']), null, ['entry' => $entry, 'reference' => $head['reference_no'] ?? null, 'lines' => count($lines)]);

            return $entry;
        });
    }

    /**
     * Previous items: equipment that existed before this system. Added to stock with its original (past) date as a
     * "Previous item" record. When the item is already with someone, the same date also gets an allocation, so stock
     * stays unchanged and the holder shows in "who has what" and can return it later through Receives.
     *
     * @param array<int,array{equipment_id:int,qty:float}> $lines
     * @param ?array{type:string,user_id?:?int,department_id?:?int,section_id?:?int} $heldBy null = in store
     */
    /** Entry no. (AL-…) of the allocation made by the last receivePrevious() call, null when the items were put in store. */
    public ?string $lastAllocEntry = null;

    public function receivePrevious(array $head, array $lines, ?array $heldBy): string
    {
        return DB::transaction(function () use ($head, $lines, $heldBy) {
            // Already with someone (a previous allocation): only an allocation entry (AL-…) is made, no receive entry and no stock-in line.
            // Its lines are flagged no_stock, so they are recorded and held by the person but never change the stock.
            $allocEntry = $heldBy ? $this->entryNo('AL') : null;
            $entry = $heldBy ? $allocEntry : $this->entryNo('RC');
            $this->lastAllocEntry = $allocEntry;
            $common = ['moved_on' => $head['date'], 'reference_no' => $head['reference_no'] ?? null, 'entry_no' => $entry];
            foreach ($lines as $l) {
                $e = Equipment::with('category')->findOrFail($l['equipment_id']);
                $qty = (float) $l['qty'];
                if ($heldBy && $e->is_serialized && fmod($qty, 1.0) != 0.0) $this->fail('qty', "{$e->name} is serialisable, so the quantity must be a whole number.");
                if (! $heldBy) $this->move('OPENING', $e, $qty, $common + ['party' => $head['supplier'] ?? null, 'remarks' => $head['remarks'] ?? null]);
                if ($heldBy) {
                    $d = ['entry_no' => $allocEntry, 'no_stock' => true] + $this->holder($heldBy) + $common + ['remarks' => trim((string) ($l['purpose'] ?? $head['remarks'] ?? '')) ?: null];
                    if ($e->is_serialized) {
                        for ($i = 0; $i < (int) $qty; $i++) $this->allocateUnit($e, $d, false, $l['device_serial_no'] ?? null);   // each unit gets its own new serial
                    } else {
                        $this->move('ALLOCATE', $e, -$qty, $d);
                    }
                }
            }
            AuditLog::record('inventory.previous_items', Equipment::find($lines[0]['equipment_id']), null, ['entry' => $entry, 'held_by' => $heldBy, 'lines' => count($lines)]);

            return $entry;
        });
    }

    protected function holder(array $to): array
    {
        return ['holder_type' => $to['type'], 'holder_user_id' => $to['type'] === 'EMPLOYEE' ? $to['user_id'] : null, 'holder_department_id' => $to['type'] === 'DEPARTMENT' ? $to['department_id'] : null,
            'holder_section_id' => $to['type'] === 'OFFICE' ? $to['section_id'] : null]
            + ($to['type'] !== 'DEPARTMENT' ? ['location_id' => null] : (array_key_exists('location_id', $to) ? ['location_id' => $to['location_id']] : []));   // The form no longer asks for a location: an old department entry keeps the one it has
    }

    /** Serial number for the next unit of a serialisable item: equipment code + 4-digit running number, no separator (LAPT00010001). */
    protected function nextSerial(Equipment $e): string
    {
        $name = 'sn:'.$e->id;
        DB::table('inv_counters')->insertOrIgnore(['name' => $name, 'value' => 0]);
        $n = (int) DB::table('inv_counters')->where('name', $name)->lockForUpdate()->value('value');
        do {
            $n++;
            $serial = $e->code.str_pad((string) $n, 4, '0', STR_PAD_LEFT);
        } while (Movement::where('equipment_id', $e->id)->where('serial_no', $serial)->exists());
        DB::table('inv_counters')->where('name', $name)->update(['value' => $n]);

        return $serial;
    }

    /**
     * What the next allocations of a serialisable item will be given, for showing on the allocation form:
     * first the units that came back (oldest first), then new serials starting at `next`.
     *
     * @return array{code:string,pool:array<int,string>,next:int}
     */
    public function serialInfo(Equipment $e): array
    {
        $last = Movement::where('equipment_id', $e->id)->whereNotNull('serial_no')->whereIn('type', ['ALLOCATE', 'RETURN'])->selectRaw('MAX(id) as mid')->groupBy('serial_no')->pluck('mid');
        $pool = Movement::whereIn('id', $last)->where('type', 'RETURN')->orderBy('id')->pluck('serial_no')->all();
        $n = (int) DB::table('inv_counters')->where('name', 'sn:'.$e->id)->value('value');

        return ['code' => $e->code, 'pool' => $pool, 'next' => $n + 1];
    }

    /** The oldest unit of this item that was returned and is back in the store (its last record is a RETURN), if any. */
    protected function returnedSerial(int $equipmentId): ?string
    {
        $last = Movement::where('equipment_id', $equipmentId)->whereNotNull('serial_no')->whereIn('type', ['ALLOCATE', 'RETURN'])->selectRaw('MAX(id) as mid')->groupBy('serial_no')->pluck('mid');

        return Movement::whereIn('id', $last)->where('type', 'RETURN')->orderBy('id')->value('serial_no');
    }

    /** Allocate exactly one unit of a serialisable item. A unit that came back is handed out again under its own serial; otherwise a new serial is generated. */
    protected function allocateUnit(Equipment $e, array $d, bool $reuseReturned, ?string $deviceSerial = null): Movement
    {
        return DB::transaction(function () use ($e, $d, $reuseReturned, $deviceSerial) {
            Equipment::whereKey($e->id)->lockForUpdate()->firstOrFail();   // one allocation at a time per item, so serials cannot clash
            $serial = ($reuseReturned ? $this->returnedSerial($e->id) : null) ?? $this->nextSerial($e);

            // optional manufacturer serial number; a unit handed out again keeps the one it had before unless a new one is typed
            $deviceSerial = trim((string) $deviceSerial) ?: Movement::where('equipment_id', $e->id)->where('serial_no', $serial)->whereNotNull('device_serial_no')->latest('id')->value('device_serial_no');

            return $this->move('ALLOCATE', $e, -1.0, $d + ['serial_no' => $serial, 'device_serial_no' => $deviceSerial ?: null]);
        });
    }

    /**
     * Serialisable item → one unit per line, serial generated by the system, quantity is always 1.
     * Other items → the quantity on the line. Each line carries its own purpose.
     *
     * @param array{type:string,user_id?:?int,department_id?:?int,section_id?:?int} $to
     * @param array<int,array{equipment_id:int,qty?:?float,purpose?:?string}> $lines
     */
    public function allocate(array $to, array $head, array $lines): string
    {
        return DB::transaction(function () use ($to, $head, $lines) {
            $entry = $this->entryNo('AL');
            foreach ($lines as $l) {
                $e = Equipment::with('category')->findOrFail($l['equipment_id']);
                $d = $this->holder($to) + ['moved_on' => $head['date'], 'reference_no' => $head['reference_no'] ?? null, 'remarks' => $l['purpose'] ?? null, 'entry_no' => $entry];
                if ($e->is_serialized) $this->allocateUnit($e, $d, true, $l['device_serial_no'] ?? null);
                else $this->move('ALLOCATE', $e, -(float) $l['qty'], $d);
            }
            AuditLog::record('inventory.allocated', Equipment::find($lines[0]['equipment_id']), null, ['entry' => $entry, 'to' => $to, 'lines' => count($lines)]);

            return $entry;
        });
    }

    /**
     * Delete one whole entry (RC-… or AL-…): its stock effect is reversed and its records are removed.
     * Refused (nothing changes) when that would leave the books inconsistent: stock below zero, a serial unit that
     * has later records, or items already returned by the holder.
     *
     * @param array<int,string> $types movement types that belong to this kind of entry
     * @return array{lines:int,first:Movement}
     */
    public function deleteEntry(string $entry, array $types): array
    {
        return DB::transaction(function () use ($entry, $types) {
            $lines = Movement::with('equipment')->where('entry_no', $entry)->whereIn('type', $types)->orderBy('id')->lockForUpdate()->get();
            abort_if($lines->isEmpty(), 404);
            $ids = $lines->pluck('id');

            // a serial unit that was returned / handed out again afterwards: those records must go first
            foreach ($lines->filter(fn ($l) => $l->serial_no) as $l) {
                if (Movement::where('equipment_id', $l->equipment_id)->where('serial_no', $l->serial_no)->where('id', '>', $l->id)->whereNotIn('id', $ids)->exists()) {
                    $this->fail('delete', "{$l->equipment->name} {$l->serial_no} has later records (returned or allocated again). Delete those entries first.");
                }
            }

            // allocated quantities that the holder has already given back
            $groups = $lines->where('type', 'ALLOCATE')->whereNull('serial_no')->groupBy(fn ($l) => implode('|', [$l->equipment_id, $l->holder_type, $l->holder_user_id, $l->holder_department_id, $l->holder_section_id]));
            foreach ($groups as $g) {
                $f = $g->first();
                $held = $this->heldQty($f->equipment_id, $f->holderRef());
                if ($held - abs((float) $g->sum('qty')) < -0.001) {
                    $this->fail('delete', "Part of {$f->equipment->name} in this entry was already returned by {$f->holder_name}. Delete that return first.");
                }
            }

            // stock: take the entry's effect back out, never below zero
            $touched = [];
            foreach ($lines->groupBy('equipment_id') as $equipmentId => $g) {
                $e = Equipment::whereKey($equipmentId)->lockForUpdate()->firstOrFail();
                $new = round((float) $e->stock_qty - (float) $g->reject(fn ($l) => $l->no_stock)->sum('qty'), 2);   // previous allocations never touched the stock
                if ($new < -0.001) {
                    $this->fail('delete', "{$e->name}: deleting {$entry} would make the stock negative (in stock: ".Inv::qty($e->stock_qty).'). Delete the later allocations first.');
                }
                $e->update(['stock_qty' => max($new, 0)]);
                $touched[] = $e->id;
            }

            $first = $lines->first();
            $snapshot = $lines->map(fn ($l) => ['equipment' => $l->equipment->name, 'type' => $l->type, 'qty' => (float) $l->qty, 'serial_no' => $l->serial_no, 'holder' => $l->holder_name])->all();
            Movement::whereIn('id', $ids)->delete();

            // the running balance shown on the later records follows the new history
            $this->rebuildBalances($touched, (int) $ids->min());

            AuditLog::record('inventory.entry_deleted', $first->equipment, ['entry' => $entry, 'date' => $first->moved_on?->toDateString(), 'lines' => $snapshot], null);

            return ['lines' => $lines->count(), 'first' => $first];
        });
    }

    /**
     * Recompute the running balance (balance_after) of every record from $fromId on, for the given equipment, in record order.
     * Returns the first record whose recomputed balance is negative (null when the history is sound).
     *
     * @param iterable<int> $equipmentIds
     */
    protected function rebuildBalances(iterable $equipmentIds, int $fromId): ?Movement
    {
        $bad = null;
        foreach (Equipment::whereIn('id', collect($equipmentIds)->unique())->get() as $e) {
            $rows = Movement::where('equipment_id', $e->id)->orderBy('id')->get(['id', 'ref', 'equipment_id', 'qty', 'balance_after', 'no_stock']);
            $run = round((float) $e->stock_qty - (float) $rows->reject(fn ($m) => $m->no_stock)->sum('qty'), 2);
            foreach ($rows as $m) {
                if (! $m->no_stock) $run = round($run + (float) $m->qty, 2);   // a previous allocation leaves the running balance as it was
                if ($m->id < $fromId) continue;
                if ($run < -0.001 && ! $bad) $bad = $m;
                if (abs((float) $m->balance_after - $run) > 0.001) Movement::whereKey($m->id)->update(['balance_after' => $run]);
            }
        }

        return $bad;
    }

    /** What an entry looks like for the audit log (before / after an edit). */
    protected function entrySnapshot($lines): array
    {
        $f = $lines->first();
        $isAlloc = $lines->contains('type', 'ALLOCATE');

        return [
            'date' => $f->moved_on?->toDateString(), 'reference' => $f->reference_no,
            'supplier' => $isAlloc ? null : $f->party, 'remarks' => $isAlloc ? null : $f->remarks,
            'holder' => $isAlloc ? $lines->firstWhere('type', 'ALLOCATE')->holder_name : null,
            'location' => $isAlloc ? $lines->firstWhere('type', 'ALLOCATE')->location_id : null,
            'lines' => $lines->where('type', '!=', 'PRIOR')->map(fn ($l) => ['record' => $l->ref, 'equipment' => $l->equipment->name, 'qty' => (float) $l->qty,
                'purpose' => $l->type === 'ALLOCATE' ? $l->remarks : null, 'serial_no' => $l->serial_no, 'device_serial_no' => $l->device_serial_no])->values()->all(),
        ];
    }

    /** Quantity can be edited only on lines of ordinary (not serialisable) equipment; a serialisable unit is always one. */
    public function qtyEditable(Movement $m): bool
    {
        return ! $m->serial_no && ! $m->equipment->is_serialized && $m->type !== 'PRIOR';
    }

    /**
     * Edit one whole entry (RC-… / AL-…) in place. The entry number, the record numbers and the Asset IDs stay as they are; stock and the
     * running balances are corrected to match. Equipment cannot be swapped and lines cannot be added or removed here (delete the entry and
     * enter it again for that). Everything is checked first: nothing is saved when the change would break the books, i.e. stock (or a
     * record's running balance) would go below zero, or the holder has already returned what the edit takes away.
     *
     * @param array<int,string> $types movement types that belong to this kind of entry
     * @param array{date:string,reference_no?:?string,remarks?:?string,supplier?:?string} $head remarks / supplier only for receives
     * @param array<int,array{qty?:mixed,purpose?:?string,device_serial_no?:?string}> $lines keyed by record (movement) id
     * @param ?array{type:string,user_id?:?int,department_id?:?int,section_id?:?int,location_id?:?int} $to new holder of an allocation entry (null = unchanged)
     * @return array{first:Movement,changed:bool}
     */
    public function updateEntry(string $entry, array $types, array $head, array $lines = [], ?array $to = null): array
    {
        return DB::transaction(function () use ($entry, $types, $head, $lines, $to) {
            $with = ['equipment', 'holderUser', 'holderDepartment', 'holderSection'];
            $all = Movement::with($with)->where('entry_no', $entry)->whereIn('type', $types)->orderBy('id')->lockForUpdate()->get();
            abort_if($all->isEmpty(), 404);
            $before = $this->entrySnapshot($all);

            $alloc = $all->where('type', 'ALLOCATE');
            $f = $alloc->first();
            $holderChanged = $to && $f && ($f->holder_type !== $to['type'] || (int) $f->holder_user_id !== (int) ($to['type'] === 'EMPLOYEE' ? $to['user_id'] : 0)
                || (int) $f->holder_department_id !== (int) ($to['type'] === 'DEPARTMENT' ? $to['department_id'] : 0)
                || (int) $f->holder_section_id !== (int) ($to['type'] === 'OFFICE' ? $to['section_id'] : 0));
            $holderKey = fn ($m) => implode('|', [$m->equipment_id, $m->serial_no, $m->holder_type, $m->holder_user_id, $m->holder_department_id, $m->holder_section_id]);
            $holderOf = fn ($m) => $m->holderRef();

            // 1. work out what changes, line by line
            $set = [];            // movement id => attributes to save
            $delta = [];          // equipment id => change of the stock quantity
            $drops = [];          // allocated quantity a holder loses (must not exceed what they still hold)
            $adds = [];           // quantity a holder returns on top of before (must not exceed what they still hold)
            $qtyEquip = [];       // equipment whose record quantities change (their running balances are rebuilt)
            foreach ($all as $m) {
                $in = $lines[$m->id] ?? [];
                $upd = [];
                $newQty = (float) $m->qty;
                if ($m->type !== 'PRIOR') {
                    if (array_key_exists('qty', $in) && $in['qty'] !== null && $in['qty'] !== '' && $this->qtyEditable($m)) {
                        $newAbs = round((float) $in['qty'], 2);
                        if ($newAbs <= 0) $this->fail('lines', "Enter a quantity for {$m->equipment->name}.");
                        $newQty = ($m->qty < 0 ? -1 : 1) * $newAbs;
                    }
                    if ($m->type === 'ALLOCATE') {
                        if (array_key_exists('purpose', $in)) $upd['remarks'] = trim((string) $in['purpose']) ?: null;
                        if ($m->serial_no && array_key_exists('device_serial_no', $in)) $upd['device_serial_no'] = trim((string) $in['device_serial_no']) ?: null;
                        if ($to) $upd += $this->holder($to);
                    }
                }
                if (abs($newQty - (float) $m->qty) > 0.001) {
                    $upd['qty'] = $newQty;
                    $qtyEquip[$m->equipment_id] = true;
                    if (! $m->no_stock) $delta[$m->equipment_id] = ($delta[$m->equipment_id] ?? 0) + ($newQty - (float) $m->qty);   // a previous allocation never moves stock
                }
                if ($m->type === 'RETURN' && $newQty > (float) $m->qty + 0.001) $adds[$holderKey($m)] = ['m' => $m, 'qty' => ($adds[$holderKey($m)]['qty'] ?? 0) + ($newQty - (float) $m->qty)];
                if ($m->type === 'ALLOCATE') {
                    $drop = abs((float) $m->qty) - ($holderChanged ? 0.0 : abs($newQty));
                    if ($drop > 0.001) $drops[$holderKey($m)] = ['m' => $m, 'qty' => ($drops[$holderKey($m)]['qty'] ?? 0) + $drop];
                }
                $set[$m->id] = ($set[$m->id] ?? []) + $upd;
            }

            // 2. the holder must still have what the edit takes away from them
            foreach ($drops as $x) {
                $m = $x['m'];
                if ($this->heldQty($m->equipment_id, $holderOf($m), $m->serial_no) - $x['qty'] < -0.001) {
                    $this->fail('lines', "{$m->holder_name} has already returned part of {$m->equipment->name}".($m->serial_no ? " {$m->serial_no}" : '').', so this change is not possible. Delete that return first.');
                }
            }
            foreach ($adds as $x) {
                $m = $x['m'];
                if ($this->heldQty($m->equipment_id, $holderOf($m), $m->serial_no) - $x['qty'] < -0.001) {
                    $this->fail('lines', "{$m->holder_name} only has ".Inv::qty($this->heldQty($m->equipment_id, $holderOf($m), $m->serial_no) + (float) $m->qty)." of {$m->equipment->name} on record.");
                }
            }

            // 3. save the header and the lines
            foreach ($all as $m) {
                $attrs = ['moved_on' => $head['date'], 'reference_no' => trim((string) ($head['reference_no'] ?? '')) ?: null];
                if (! in_array($m->type, ['ALLOCATE', 'PRIOR'], true) && array_key_exists('remarks', $head)) $attrs['remarks'] = trim((string) $head['remarks']) ?: null;
                if (in_array($m->type, ['RECEIVE', 'OPENING'], true) && array_key_exists('supplier', $head)) $attrs['party'] = trim((string) $head['supplier']) ?: null;
                $m->update($attrs + ($set[$m->id] ?? []));
            }

            // 4. stock follows the new quantities; the running balances of the records after them follow too
            foreach ($delta as $equipmentId => $d) {
                if (abs($d) < 0.001) continue;
                $e = Equipment::whereKey($equipmentId)->lockForUpdate()->firstOrFail();
                $new = round((float) $e->stock_qty + $d, 2);
                if ($new < -0.001) $this->fail('lines', "{$e->name}: this change would make the stock negative (in stock: ".Inv::qty($e->stock_qty).').');
                $e->update(['stock_qty' => $new]);
            }
            if ($qtyEquip) {
                $bad = $this->rebuildBalances(array_keys($qtyEquip), (int) $all->whereIn('id', array_keys(array_filter($set, fn ($u) => isset($u['qty']))))->min('id'));
                if ($bad) $this->fail('lines', "This change would make the stock of {$bad->equipment->name} negative at record {$bad->ref}. Edit or delete the later entries first.");
            }

            $fresh = Movement::with($with)->where('entry_no', $entry)->whereIn('type', $types)->orderBy('id')->get();
            $after = $this->entrySnapshot($fresh);
            $changed = $before !== $after;
            if ($changed) AuditLog::record('inventory.entry_edited', $fresh->first()->equipment, ['entry' => $entry] + $before, ['entry' => $entry] + $after);

            return ['first' => $fresh->first(), 'changed' => $changed];
        });
    }

    /** What a holder still has of an equipment item (or of one serial): allocated minus returned. */
    public function heldQty(int $equipmentId, array $who, ?string $serial = null): float
    {
        $q = Movement::where('equipment_id', $equipmentId)->whereIn('type', ['ALLOCATE', 'RETURN'])->where('holder_type', $who['type'])
            ->when($who['type'] === 'EMPLOYEE', fn ($x) => $x->where('holder_user_id', $who['user_id']),
                fn ($x) => $who['type'] === 'OFFICE' ? $x->where('holder_section_id', $who['section_id']) : $x->where('holder_department_id', $who['department_id']))
            ->when($serial, fn ($x) => $x->where('serial_no', $serial), fn ($x) => $x->whereNull('serial_no'));

        return round(-(float) $q->sum('qty'), 2);   // ALLOCATE lines are negative, RETURN lines positive
    }

    public function returnEquipment(Equipment $e, array $from, float $qty, ?string $remarks, array $extra = [], ?string $serial = null): void
    {
        DB::transaction(function () use ($e, $from, $qty, $remarks, $extra, $serial) {
            $held = $this->heldQty($e->id, $from, $serial);
            if ($qty > $held) $this->fail('qty', $serial ? "That holder does not have {$e->name} {$serial}." : 'That holder only has '.Inv::qty($held)." of {$e->name} on record.");
            $this->move('RETURN', $e, $qty, $this->holder($from) + ['remarks' => $remarks, 'serial_no' => $serial] + $extra);
        });
    }

    /**
     * Items coming back from an employee / department / office, entered on the Receive Item screen. Each line is checked against
     * what that holder still has (lines are applied one after another, so the same item twice cannot over-return).
     *
     * @param array{type:string,user_id?:?int,department_id?:?int,section_id?:?int} $from
     * @param array<int,array{equipment_id:int,qty:float}> $lines
     */
    public function receiveReturn(array $from, array $head, array $lines): string
    {
        return DB::transaction(function () use ($from, $head, $lines) {
            $entry = $this->entryNo('RC');
            foreach ($lines as $l) {
                $e = Equipment::with('category')->findOrFail($l['equipment_id']);
                $serial = ($l['serial_no'] ?? '') !== '' ? $l['serial_no'] : null;
                // a serialisable unit is always returned one at a time
                $qty = ($serial || $e->is_serialized) ? 1.0 : (float) ($l['qty'] ?? 0);
                if ($qty <= 0) $this->fail('qty', "Enter a quantity for {$e->name}.");
                $this->returnEquipment($e, $from, $qty, $head['remarks'] ?? null, ['moved_on' => $head['date'], 'reference_no' => $head['reference_no'] ?? null, 'entry_no' => $entry], $serial);
            }
            AuditLog::record('inventory.returned', Equipment::find($lines[0]['equipment_id']), null, ['entry' => $entry, 'from' => $from, 'lines' => count($lines)]);

            return $entry;
        });
    }
}
