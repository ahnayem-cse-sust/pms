<?php

namespace App\Services\Inventory;

use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Inventory\{Asset, ImportBatch, Item, Location, Lookup, StockTransaction};
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/** Controlled opening-data import: validate everything first, post only when the file is error free. */
class ImportService
{
    public const COLS = [
        'ASSETS' => ['asset_code', 'item_code', 'serial_no', 'acquisition_date', 'cost', 'supplier', 'warranty_start', 'warranty_end', 'condition', 'location_code', 'employee_id', 'department_code', 'remarks'],
        'OPENING_STOCK' => ['item_code', 'location_code', 'quantity'],
    ];
    public const SAMPLE = [
        'ASSETS' => ['', 'LAP-DELL-5420', 'SN12345', '2024-03-15', '95000', 'Supplier Ltd', '2024-03-15', '2027-03-14', 'Good', 'HO-STORE', '', '', 'Opening register'],
        'OPENING_STOCK' => ['TONER-HP-12A', 'HO-STORE', '25'],
    ];

    public function __construct(protected InventoryService $svc) {}

    /** @return array{0: array<int,string>, 1: array<int, array<string,string>>} header and rows (each row has _line) */
    public function parse(string $path): array
    {
        $h = fopen($path, 'r');
        $head = null;
        $rows = [];
        $line = 0;
        while (($c = fgetcsv($h)) !== false) {
            $line++;
            if ($c === [null] || ! array_filter($c, fn ($x) => trim((string) $x) !== '')) continue;
            if ($head === null) {
                $head = array_map(fn ($x) => strtolower(trim(preg_replace('/^\xEF\xBB\xBF/', '', (string) $x))), $c);
                continue;
            }
            $row = ['_line' => $line];
            foreach ($head as $i => $k) $row[$k] = trim((string) ($c[$i] ?? ''));
            $rows[] = $row;
        }
        fclose($h);

        return [$head ?? [], $rows];
    }

    /** @return array{0: array<int,array>, 1: array<int,array{line:int,message:string}>} normalized rows and errors */
    public function validate(string $kind, string $path): array
    {
        [$head, $rows] = $this->parse($path);
        $errors = [];
        $missing = array_diff(self::COLS[$kind], $head);
        if ($missing) return [[], [['line' => 1, 'message' => 'Missing column(s): '.implode(', ', $missing).'. Use the template.']]];
        if (! $rows) return [[], [['line' => 1, 'message' => 'The file has no data rows.']]];

        $out = [];
        $seenCode = $seenSerial = $seenKey = [];
        $date = function (string $v) {
            if ($v === '') return null;
            try { $d = Carbon::createFromFormat('Y-m-d', $v); } catch (\Throwable) { return false; }
            return ($d && $d->format('Y-m-d') === $v) ? $v : false;
        };
        foreach ($rows as $r) {
            $e = fn (string $m) => $errors[] = ['line' => $r['_line'], 'message' => $m];
            $n = ['_line' => $r['_line']];
            if ($kind === 'ASSETS') {
                $item = Item::where('code', $r['item_code'])->first();
                if (! $item || $item->type !== 'ASSET' || ! $item->is_active) $e("Unknown or inactive serialized item code \"{$r['item_code']}\".");
                $loc = Location::where('code', $r['location_code'])->where('is_active', true)->first();
                if (! $loc) $e("Unknown or inactive location code \"{$r['location_code']}\".");
                if ($r['asset_code'] !== '') {
                    if (isset($seenCode[$r['asset_code']])) $e("Duplicate asset code {$r['asset_code']} in the file (also line {$seenCode[$r['asset_code']]}).");
                    if (Asset::where('asset_code', $r['asset_code'])->exists()) $e("Asset code {$r['asset_code']} already exists.");
                    $seenCode[$r['asset_code']] = $r['_line'];
                }
                if ($r['serial_no'] !== '' && InventoryService::on('inventory.unique_serial')) {
                    if (isset($seenSerial[$r['serial_no']])) $e("Duplicate serial {$r['serial_no']} in the file (also line {$seenSerial[$r['serial_no']]}).");
                    if (Asset::where('serial_no', $r['serial_no'])->exists()) $e("Serial {$r['serial_no']} already exists.");
                    $seenSerial[$r['serial_no']] = $r['_line'];
                }
                if ($r['serial_no'] === '' && InventoryService::on('inventory.serial_required')) $e('Serial number is required.');
                foreach (['acquisition_date', 'warranty_start', 'warranty_end'] as $f) if ($date($r[$f]) === false) $e("$f must be YYYY-MM-DD.");
                if ($r['cost'] !== '' && (! is_numeric($r['cost']) || $r['cost'] < 0)) $e('Cost must be a number.');
                $sup = $r['supplier'] !== '' ? Lookup::ofType('supplier')->where('name', $r['supplier'])->first() : null;
                if ($r['supplier'] !== '' && ! $sup) $e("Unknown supplier \"{$r['supplier']}\" (add it under reference data first).");
                $cond = $r['condition'] !== '' ? Lookup::ofType('condition')->where('name', $r['condition'])->first() : null;
                if ($r['condition'] !== '' && ! $cond) $e("Unknown condition \"{$r['condition']}\".");
                $emp = $r['employee_id'] !== '' ? User::where('employee_id', $r['employee_id'])->first() : null;
                if ($r['employee_id'] !== '' && ! $emp) $e("Unknown employee ID \"{$r['employee_id']}\".");
                $dep = $r['department_code'] !== '' ? Department::where('code', $r['department_code'])->first() : null;
                if ($r['department_code'] !== '' && ! $dep) $e("Unknown department code \"{$r['department_code']}\".");
                if ($emp && $dep) $e('Give either an employee or a department as custodian, not both.');
                $n += ['asset_code' => $r['asset_code'], 'item_id' => $item?->id, 'serial_no' => $r['serial_no'] ?: null, 'acquisition_date' => $date($r['acquisition_date']) ?: null,
                    'cost' => $r['cost'] === '' ? null : $r['cost'], 'supplier_id' => $sup?->id, 'warranty_start' => $date($r['warranty_start']) ?: null, 'warranty_end' => $date($r['warranty_end']) ?: null,
                    'condition_id' => $cond?->id, 'location_id' => $loc?->id, 'user_id' => $emp?->id, 'department_id' => $dep?->id, 'remarks' => $r['remarks'] ?: null];
            } else {
                $item = Item::where('code', $r['item_code'])->first();
                if (! $item || $item->type !== 'CONSUMABLE') $e("Unknown consumable item code \"{$r['item_code']}\".");
                $loc = Location::where('code', $r['location_code'])->where('is_active', true)->first();
                if (! $loc) $e("Unknown or inactive location code \"{$r['location_code']}\".");
                if (! is_numeric($r['quantity']) || $r['quantity'] < 0) $e('Quantity must be zero or more.');
                $key = ($item?->id).'|'.($loc?->id);
                if ($item && $loc) {
                    if (isset($seenKey[$key])) $e("Duplicate item/location (also line {$seenKey[$key]}).");
                    if (StockTransaction::where(['item_id' => $item->id, 'location_id' => $loc->id, 'type' => 'OPENING'])->exists()) $e('An opening balance was already posted for this item and location.');
                    $seenKey[$key] = $r['_line'];
                }
                $n += ['item_id' => $item?->id, 'location_id' => $loc?->id, 'quantity' => $r['quantity']];
            }
            $out[] = $n;
        }

        return [$out, $errors];
    }

    public function post(ImportBatch $b): void
    {
        [$rows, $errors] = $this->validate($b->kind, \Illuminate\Support\Facades\Storage::disk('local')->path($b->stored_path));
        if ($errors) throw ValidationException::withMessages(['file' => 'The file still has '.count($errors).' error(s).']);

        DB::transaction(function () use ($b, $rows) {
            foreach ($rows as $r) {
                if ($b->kind === 'OPENING_STOCK') {
                    $this->svc->postStock('OPENING', Item::findOrFail($r['item_id']), $r['location_id'], (float) $r['quantity'], 0, today()->toDateString(), 'Opening balance '.$b->ref, $b->ref, null, auth()->id());
                    continue;
                }
                $a = Asset::create([
                    'asset_code' => $r['asset_code'] ?: $this->svc->ref('asset'), 'item_id' => $r['item_id'], 'serial_no' => $r['serial_no'], 'acquisition_date' => $r['acquisition_date'],
                    'cost' => $r['cost'], 'supplier_id' => $r['supplier_id'], 'warranty_start' => $r['warranty_start'], 'warranty_end' => $r['warranty_end'], 'condition_id' => $r['condition_id'],
                    'status' => 'AVAILABLE', 'location_id' => $r['location_id'], 'custodian_type' => 'LOCATION', 'remarks' => $r['remarks'], 'import_batch_id' => $b->id, 'created_by' => auth()->id(),
                ]);
                $this->svc->event($a, 'IMPORTED', null, 'AVAILABLE', $b->ref);
                if ($r['user_id'] || $r['department_id']) {
                    $to = $r['user_id'] ? ['type' => 'EMPLOYEE', 'user_id' => $r['user_id'], 'location_id' => $a->location_id] : ['type' => 'DEPARTMENT', 'department_id' => $r['department_id'], 'location_id' => $a->location_id];
                    $asg = $this->svc->setCustody($a, $to, ['source' => 'IMPORT', 'source_ref' => $b->ref, 'remarks' => 'Opening register']);
                    $asg?->update(['ack_required' => false]);   // opening data is verified by sign-off, not by acknowledgement
                    $this->svc->event($a, 'ASSIGNED', 'AVAILABLE', 'ASSIGNED', $b->ref, ['to' => $a->custodian_name]);
                }
            }
            $b->update(['status' => 'POSTED', 'posted_by' => auth()->id(), 'posted_at' => now()]);
            AuditLog::record('inventory.import.posted', $b, null, ['ref' => $b->ref, 'kind' => $b->kind, 'rows' => count($rows), 'source' => $b->source_ref]);
        });
    }
}
