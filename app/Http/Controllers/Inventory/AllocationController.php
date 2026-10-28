<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Department;
use App\Models\Inventory\{Equipment, Movement};
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/** Who has what: allocate equipment to people / departments and see current holdings (returns are entered on Receive Item). */
class AllocationController extends InvController
{
    /** Current holdings: allocated minus returned, per holder and equipment. */
    public function holdings(?callable $scope = null)
    {
        $rows = Movement::whereIn('type', ['ALLOCATE', 'RETURN'])->when($scope, fn ($q) => $scope($q))
            ->selectRaw('equipment_id, serial_no, holder_type, holder_user_id, holder_department_id, -SUM(qty) as held, MIN(CASE WHEN type = \'ALLOCATE\' THEN moved_on END) as since, MAX(device_serial_no) as device_sn')
            ->groupBy('equipment_id', 'serial_no', 'holder_type', 'holder_user_id', 'holder_department_id')->havingRaw('-SUM(qty) > 0')->get();
        $eq = Equipment::with(['assetType', 'category', 'subcategory'])->whereIn('id', $rows->pluck('equipment_id'))->get()->keyBy('id');
        $users = User::with('department')->whereIn('id', $rows->pluck('holder_user_id')->filter())->get()->keyBy('id');
        $depts = Department::whereIn('id', $rows->pluck('holder_department_id')->filter())->get()->keyBy('id');

        return $rows->map(function ($x) use ($eq, $users, $depts) {
            $x->equipment = $eq[$x->equipment_id];
            $x->holder = $x->holder_type === 'EMPLOYEE' ? ($users[$x->holder_user_id]->name ?? '—') : (($depts[$x->holder_department_id]->name ?? '—').' (dept)');
            $x->dept = $x->holder_type === 'EMPLOYEE' ? ($users[$x->holder_user_id]->department->name ?? '') : '';
            return $x;
        })->sortBy('holder')->values();
    }

    public function index(Request $r)
    {
        $rows = $this->holdings()
            ->when($r->equipment_id, fn ($c, $v) => $c->filter(fn ($x) => $x->equipment_id == $v))
            ->when($r->user_id, fn ($c, $v) => $c->filter(fn ($x) => $x->holder_type === 'EMPLOYEE' && $x->holder_user_id == $v))
            ->when($r->department_id, fn ($c, $v) => $c->filter(fn ($x) => $x->holder_type === 'DEPARTMENT' && $x->holder_department_id == $v))
            ->when($r->q, fn ($c, $s) => $c->filter(fn ($x) => stripos($x->holder.' '.$x->dept.' '.$x->equipment->name.' '.$x->equipment->code.' '.$x->serial_no.' '.$x->device_sn, $s) !== false))->values();

        if ($r->input('format') === 'csv') {
            return $this->csv('allocations', ['Assigned to', 'Department', 'Equipment', 'Asset ID', 'Serial number', 'Asset type', 'Category', 'Sub category', 'Quantity', 'Since'],
                $rows->map(fn ($x) => [$x->holder, $x->dept, $x->equipment->name, $x->serial_no, $x->device_sn, $x->equipment->assetType->name ?? '', $x->equipment->category->name ?? '', $x->equipment->subcategory->name ?? '', \App\Support\Inv::qty($x->held), $x->since]));
        }

        return view('inventory.allocations.index', ['rows' => $rows, 'equipment' => $this->equipment(), 'people' => $this->people(), 'departments' => $this->departments()]);
    }

    /** One holder (employee or department) with everything they currently hold; equipment is shown here and returned from here. */
    public function holder(string $holder)
    {
        [$kind, $id] = explode('-', $holder);
        $isEmp = $kind === 'E';
        $who = $isEmp ? User::with('department')->findOrFail($id) : Department::findOrFail($id);
        $rows = $this->holdings(fn ($q) => $isEmp ? $q->where('holder_type', 'EMPLOYEE')->where('holder_user_id', $id) : $q->where('holder_type', 'DEPARTMENT')->where('holder_department_id', $id));

        return view('inventory.allocations.holder', ['who' => $who, 'isEmp' => $isEmp, 'rows' => $rows, 'holderId' => $holder]);
    }

    /** "My Items": what is currently allocated to me or my department. */
    public function mine()
    {
        $u = auth()->user();
        abort_unless($u->hasPermission('inv.view') || $u->hasPermission('inv.view.own'), 403);
        $rows = $this->holdings(fn ($q) => $q->where(fn ($w) => $w->where(fn ($x) => $x->where('holder_type', 'EMPLOYEE')->where('holder_user_id', $u->id))
            ->orWhere(fn ($x) => $x->where('holder_type', 'DEPARTMENT')->where('holder_department_id', $u->department_id))));

        return view('inventory.allocations.mine', compact('rows'));
    }

    public function create()
    {
        $equipment = $this->equipment()->where('stock_qty', '>', 0)->values();
        $serials = $equipment->filter(fn ($e) => $e->is_serialized)->mapWithKeys(fn ($e) => [$e->id => $this->svc()->serialInfo($e)]);

        return view('inventory.allocations.create', ['equipment' => $equipment, 'serials' => $serials, 'people' => $this->people(), 'departments' => $this->departments()]);
    }

    public function store(Request $r)
    {
        $d = $r->validate(['to_type' => 'required|in:EMPLOYEE,DEPARTMENT', 'user_id' => 'required_if:to_type,EMPLOYEE|nullable|exists:users,id',
            'department_id' => 'required_if:to_type,DEPARTMENT|nullable|exists:departments,id', 'date' => 'required|date|before_or_equal:today', 'reference_no' => 'nullable|string|max:255',
            'lines' => 'required|array|min:1', 'lines.*.equipment_id' => 'required|exists:inv_equipment,id', 'lines.*.qty' => 'nullable|numeric|gt:0', 'lines.*.purpose' => 'nullable|string|max:500', 'lines.*.device_serial_no' => 'nullable|string|max:120']);
        $lines = array_values($d['lines']);

        // Serialisable items need no quantity (always one unit, serial generated); every other item needs one.
        foreach ($lines as $i => $l) {
            $e = Equipment::with('category')->findOrFail($l['equipment_id']);
            if (! $e->is_serialized && empty($l['qty'])) throw ValidationException::withMessages(["lines.$i.qty" => "Enter a quantity for {$e->name}."]);
        }

        $entry = $this->svc()->allocate(['type' => $d['to_type'], 'user_id' => $d['user_id'] ?? null, 'department_id' => $d['department_id'] ?? null], $d, $lines);

        return redirect()->route('inv.allocations.entries')->with('ok', "Allocated and recorded as {$entry}.");
    }

    /** Allocation records: one row per entry (one save = one entry holding all its equipment). */
    public function entries(Request $r)
    {
        $base = Movement::where('type', 'ALLOCATE')
            ->when($r->to_type, fn ($x, $v) => $x->where('holder_type', $v))
            ->when($r->equipment_id, fn ($x, $v) => $x->where('equipment_id', $v))
            ->when($r->from, fn ($x, $v) => $x->whereDate('moved_on', '>=', $v))->when($r->to, fn ($x, $v) => $x->whereDate('moved_on', '<=', $v))
            ->when($r->q, fn ($x, $s) => $x->where(fn ($w) => $w->where('entry_no', 'like', "%$s%")->orWhere('ref', 'like', "%$s%")->orWhere('reference_no', 'like', "%$s%")->orWhere('remarks', 'like', "%$s%")->orWhere('serial_no', 'like', "%$s%")->orWhere('device_serial_no', 'like', "%$s%")
                ->orWhereHas('equipment', fn ($e) => $e->where('name', 'like', "%$s%")->orWhere('code', 'like', "%$s%"))
                ->orWhereHas('holderUser', fn ($u) => $u->where('name', 'like', "%$s%"))->orWhereHas('holderDepartment', fn ($d) => $d->where('name', 'like', "%$s%"))));
        $with = ['equipment.assetType', 'equipment.category', 'equipment.subcategory', 'user', 'holderUser.department', 'holderDepartment'];

        if ($r->input('format') === 'csv') {
            return $this->csv('allocation_records', ['Entry', 'Date', 'Allocated to', 'Department', 'Code', 'Equipment', 'Asset ID', 'Serial number', 'Quantity', 'Purpose', 'Reference', 'By'],
                (clone $base)->with($with)->latest('moved_on')->latest('id')->get()->map(fn ($m) => [$m->entry_no, $m->moved_on->format('Y-m-d'), $m->holder_name, $m->holderUser?->department?->name ?? '', $m->equipment->code, $m->equipment->name,
                    $m->serial_no, $m->device_serial_no, \App\Support\Inv::qty(abs($m->qty)), $m->remarks, $m->reference_no, $m->user->name ?? '']));
        }

        $entries = (clone $base)->select('entry_no')->selectRaw('MAX(id) as last_id')->groupBy('entry_no')->orderByDesc('last_id')->paginate(40)->withQueryString();
        $lines = Movement::with($with)->where('type', 'ALLOCATE')->whereIn('entry_no', $entries->pluck('entry_no'))->orderBy('id')->get()->groupBy('entry_no');

        return view('inventory.allocations.entries', ['entries' => $entries, 'lines' => $lines, 'equipment' => $this->equipment()]);
    }

    /** All lines of one allocation entry; 404 when there is none, 403 unless the user may see it (inventory view, or it was handed to them / their department). */
    protected function entryLines(string $entry)
    {
        $lines = Movement::with(['equipment.assetType', 'equipment.category', 'equipment.subcategory', 'user', 'holderUser.department', 'holderDepartment'])
            ->where('entry_no', $entry)->where('type', 'ALLOCATE')->orderBy('id')->get();
        abort_if($lines->isEmpty(), 404);
        $f = $lines->first();
        $u = auth()->user();
        abort_unless($u->hasPermission('inv.view') || $f->holder_user_id === $u->id || ($f->holder_type === 'DEPARTMENT' && $f->holder_department_id === $u->department_id), 403);

        return $lines;
    }

    /** View one allocation entry: its header and every equipment handed over in it. */
    public function show(string $entry)
    {
        $lines = $this->entryLines($entry);

        $f = $lines->first();
        // What the holder still has of each equipment / asset in this entry (allocated minus returned, across all entries).
        $held = Movement::whereIn('type', ['ALLOCATE', 'RETURN'])->whereIn('equipment_id', $lines->pluck('equipment_id'))->where('holder_type', $f->holder_type)
            ->when($f->holder_type === 'EMPLOYEE', fn ($q) => $q->where('holder_user_id', $f->holder_user_id), fn ($q) => $q->where('holder_department_id', $f->holder_department_id))
            ->selectRaw('equipment_id, serial_no, -SUM(qty) as held')->groupBy('equipment_id', 'serial_no')->get()
            ->mapWithKeys(fn ($x) => [$x->equipment_id.'|'.($x->serial_no ?? '') => (float) $x->held]);

        return view('inventory.allocations.show', ['entry' => $entry, 'lines' => $lines, 'first' => $f, 'held' => $held]);
    }

    /** PDF handover form of one allocation entry: every equipment handed over in it. */
    public function pdf(string $entry)
    {
        $lines = $this->entryLines($entry);

        return Pdf::loadView('inventory.allocation-pdf', ['entry' => $entry, 'lines' => $lines, 'first' => $lines->first(), 'generatedAt' => now(), 'generatedBy' => auth()->user()->name])
            ->setPaper('a4', 'portrait')->download('Allocation_'.$entry.'.pdf');
    }
}
