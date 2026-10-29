<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\Movement;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Receive Item: every item that comes into the store is entered here, either bought from a supplier or
 * returned by an employee / department (checked against what that holder still has). Added to stock immediately.
 */
class ReceiveController extends InvController
{
    protected array $types = ['RECEIVE', 'OPENING', 'RETURN'];

    /** Receives: one row per entry (one save = one entry holding all its items), from a supplier, previous items or a return. */
    public function index(Request $r)
    {
        $base = Movement::whereIn('type', $this->types)
            ->when($r->source, fn ($x, $v) => match ($v) {
                'SUPPLIER' => $x->where('type', 'RECEIVE'),
                'PREVIOUS' => $x->where('type', 'OPENING'),
                'EMPLOYEE', 'DEPARTMENT' => $x->where('type', 'RETURN')->where('holder_type', $v),
                default => $x,
            })
            ->when($r->equipment_id, fn ($x, $v) => $x->where('equipment_id', $v))
            ->when($r->from, fn ($x, $v) => $x->whereDate('moved_on', '>=', $v))->when($r->to, fn ($x, $v) => $x->whereDate('moved_on', '<=', $v))
            ->when($r->q, fn ($x, $s) => $x->where(fn ($w) => $w->where('entry_no', 'like', "%$s%")->orWhere('ref', 'like', "%$s%")->orWhere('reference_no', 'like', "%$s%")->orWhere('party', 'like', "%$s%")->orWhere('serial_no', 'like', "%$s%")
                ->orWhereHas('equipment', fn ($e) => $e->where('name', 'like', "%$s%")->orWhere('code', 'like', "%$s%"))
                ->orWhereHas('holderUser', fn ($u) => $u->where('name', 'like', "%$s%"))->orWhereHas('holderDepartment', fn ($d) => $d->where('name', 'like', "%$s%"))));

        $with = ['equipment.assetType', 'equipment.category', 'equipment.subcategory', 'user', 'holderUser', 'holderDepartment'];
        $from = fn ($m) => match ($m->type) { 'RECEIVE' => $m->party ?: 'Supplier', 'OPENING' => 'Previous item'.($m->party ? ' – '.$m->party : ''), default => 'Return – '.$m->holder_name };

        if ($r->input('format') === 'csv') {
            return $this->csv('receives', ['Entry', 'Date', 'Received from', 'Code', 'Equipment', 'Asset type', 'Category', 'Sub category', 'Asset ID', 'Quantity', 'Reference', 'Remarks', 'By'],
                (clone $base)->with($with)->latest('moved_on')->latest('id')->get()->map(fn ($m) => [$m->entry_no, $m->moved_on->format('Y-m-d'), $from($m), $m->equipment->code, $m->equipment->name, $m->equipment->assetType->name ?? '', $m->equipment->category->name ?? '',
                    $m->equipment->subcategory->name ?? '', $m->serial_no, \App\Support\Inv::qty($m->qty), $m->reference_no, $m->remarks, $m->user->name ?? '']));
        }

        $entries = (clone $base)->select('entry_no')->selectRaw('MAX(id) as last_id')->groupBy('entry_no')->orderByDesc('last_id')->paginate(40)->withQueryString();
        $lines = Movement::with($with)->whereIn('type', $this->types)->whereIn('entry_no', $entries->pluck('entry_no'))->orderBy('id')->get()->groupBy('entry_no');

        return view('inventory.receives', ['entries' => $entries, 'lines' => $lines, 'equipment' => $this->equipment()]);
    }

    /** All lines of one receive entry (404 when there is none). */
    protected function entryLines(string $entry)
    {
        $lines = Movement::with(['equipment.assetType', 'equipment.category', 'equipment.subcategory', 'user', 'holderUser.department', 'holderDepartment'])
            ->where('entry_no', $entry)->whereIn('type', $this->types)->orderBy('id')->get();
        abort_if($lines->isEmpty(), 404);

        return $lines;
    }

    /** View one receive entry: its header and every item received in it. */
    public function show(string $entry)
    {
        $lines = $this->entryLines($entry);

        return view('inventory.receive-show', ['entry' => $entry, 'lines' => $lines, 'first' => $lines->first()]);
    }

    /** PDF receipt of one entry: every item received in it. */
    public function pdf(string $entry)
    {
        $lines = $this->entryLines($entry);

        return Pdf::loadView('inventory.receive-pdf', ['entry' => $entry, 'lines' => $lines, 'first' => $lines->first(), 'generatedAt' => now(), 'generatedBy' => auth()->user()->name])
            ->setPaper('a4', 'portrait')->download('Receive_'.$entry.'.pdf');
    }

    public function create(Request $r)
    {
        $holdings = app(AllocationController::class)->holdings();
        $holders = $holdings->groupBy(fn ($x) => $x->holder_type === 'EMPLOYEE' ? 'E:'.$x->holder_user_id : 'D:'.$x->holder_department_id)
            ->map(fn ($g, $key) => ['key' => $key, 'label' => $g->first()->holder.($g->first()->dept ? ' – '.$g->first()->dept : ''),
                'items' => $g->map(fn ($x) => ['id' => $x->equipment_id, 'serial' => $x->serial_no, 'serialized' => $x->equipment->is_serialized || (bool) $x->serial_no,
                    'label' => $x->equipment->name.' ('.$x->equipment->code.')'.($x->serial_no ? ' – Asset ID '.$x->serial_no : ''), 'held' => (float) $x->held])->sortBy('label')->values()])
            ->sortBy('label')->values();

        return view('inventory.receive', ['equipment' => $this->equipment(), 'people' => $this->people(), 'departments' => $this->departments(), 'holders' => $holders, 'preset' => ['from' => $r->query('from'), 'equipment_id' => $r->query('equipment_id'), 'serial' => $r->query('serial')]]);
    }

    public function store(Request $r)
    {
        $d = $r->validate(['source' => 'required|in:SUPPLIER,EMPLOYEE,DEPARTMENT,PREVIOUS', 'date' => 'required|date|before_or_equal:today',
            'supplier' => 'nullable|string|max:255', 'user_id' => 'required_if:source,EMPLOYEE|nullable|exists:users,id',
            'department_id' => 'required_if:source,DEPARTMENT|nullable|exists:departments,id', 'reference_no' => 'nullable|string|max:255', 'remarks' => 'nullable|string|max:1000',
            'held_type' => 'nullable|in:NONE,EMPLOYEE,DEPARTMENT',
            'held_user_id' => [Rule::requiredIf(fn () => $r->source === 'PREVIOUS' && $r->held_type === 'EMPLOYEE'), 'nullable', 'exists:users,id'],
            'held_department_id' => [Rule::requiredIf(fn () => $r->source === 'PREVIOUS' && $r->held_type === 'DEPARTMENT'), 'nullable', 'exists:departments,id'],
            'lines' => 'required|array|min:1', 'lines.*.equipment_id' => 'required|exists:inv_equipment,id', 'lines.*.serial_no' => 'nullable|string|max:60',
            'lines.*.qty' => [Rule::requiredIf(fn () => in_array($r->source, ['SUPPLIER', 'PREVIOUS'])), 'nullable', 'numeric', 'gt:0']]);   // a returned serialisable unit needs no quantity
        $lines = array_values($d['lines']);

        if ($d['source'] === 'SUPPLIER') {
            $entry = $this->svc()->receive($d, $lines);

            return redirect()->route('inv.receives')->with('ok', "Received and recorded as {$entry}.");
        }

        if ($d['source'] === 'PREVIOUS') {
            $held = $d['held_type'] ?? 'NONE';
            $entry = $this->svc()->receivePrevious($d, $lines, $held === 'NONE' ? null : ['type' => $held, 'user_id' => $d['held_user_id'] ?? null, 'department_id' => $d['held_department_id'] ?? null]);

            return redirect()->route('inv.receives')->with('ok', "Previous items added and recorded as {$entry}.");
        }

        $entry = $this->svc()->receiveReturn(['type' => $d['source'], 'user_id' => $d['user_id'] ?? null, 'department_id' => $d['department_id'] ?? null], $d, $lines);

        return redirect()->route('inv.receives')->with('ok', "Return received and recorded as {$entry}.");
    }

    /** System Administrator only: delete a whole receive entry; its stock effect is reversed (refused when that would break the records). */
    public function destroy(string $entry)
    {
        try {
            $this->svc()->deleteEntry($entry, $this->types);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', collect($e->errors())->flatten()->first());
        }

        return redirect()->route('inv.receives')->with('ok', "{$entry} was deleted and the stock was adjusted.");
    }
}
