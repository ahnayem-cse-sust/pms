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
            $new = round((float) $row->stock_qty + $delta, 2);
            if ($new < 0) $this->fail('qty', "Not enough {$row->name} in stock (available: ".Inv::qty($row->stock_qty).').');
            $row->update(['stock_qty' => $new]);

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
     * @param ?array{type:string,user_id?:?int,department_id?:?int} $heldBy null = in store
     */
    public function receivePrevious(array $head, array $lines, ?array $heldBy): string
    {
        return DB::transaction(function () use ($head, $lines, $heldBy) {
            $entry = $this->entryNo('RC');
            $allocEntry = $heldBy ? $this->entryNo('AL') : null;   // the hand-out of previous items is an allocation entry of its own
            $common = ['moved_on' => $head['date'], 'reference_no' => $head['reference_no'] ?? null, 'entry_no' => $entry];
            foreach ($lines as $l) {
                $e = Equipment::with('category')->findOrFail($l['equipment_id']);
                $qty = (float) $l['qty'];
                if ($heldBy && $e->is_serialized && fmod($qty, 1.0) != 0.0) $this->fail('qty', "{$e->name} is serialisable, so the quantity must be a whole number.");
                $this->move('OPENING', $e, $qty, $common + ['party' => $head['supplier'] ?? null, 'remarks' => $head['remarks'] ?? null]);
                if ($heldBy) {
                    $d = ['entry_no' => $allocEntry] + $this->holder($heldBy) + $common + ['remarks' => trim('Previous item already in use. '.($head['remarks'] ?? ''))];
                    if ($e->is_serialized) {
                        for ($i = 0; $i < (int) $qty; $i++) $this->allocateUnit($e, $d, false);   // each unit gets its own new serial
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
        return ['holder_type' => $to['type'], 'holder_user_id' => $to['type'] === 'EMPLOYEE' ? $to['user_id'] : null, 'holder_department_id' => $to['type'] === 'DEPARTMENT' ? $to['department_id'] : null];
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
     * @param array{type:string,user_id?:?int,department_id?:?int} $to
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

    /** What a holder still has of an equipment item (or of one serial): allocated minus returned. */
    public function heldQty(int $equipmentId, array $who, ?string $serial = null): float
    {
        $q = Movement::where('equipment_id', $equipmentId)->whereIn('type', ['ALLOCATE', 'RETURN'])->where('holder_type', $who['type'])
            ->when($who['type'] === 'EMPLOYEE', fn ($x) => $x->where('holder_user_id', $who['user_id']), fn ($x) => $x->where('holder_department_id', $who['department_id']))
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
     * Items coming back from an employee / department, entered on the Receive Item screen. Each line is checked against
     * what that holder still has (lines are applied one after another, so the same item twice cannot over-return).
     *
     * @param array{type:string,user_id?:?int,department_id?:?int} $from
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
