<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Department;
use App\Models\Section;
use App\Models\Inventory\{Equipment, Movement};
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/** Who has what: allocate equipment to people / departments / offices and see current holdings (returns are entered on Receive Item). */
class AllocationController extends InvController
{
    /** Current holdings: allocated minus returned, per holder and equipment. */
    public function holdings(?callable $scope = null)
    {
        $rows = Movement::whereIn('type', ['ALLOCATE', 'RETURN'])->when($scope, fn ($q) => $scope($q))
            ->selectRaw('equipment_id, serial_no, holder_type, holder_user_id, holder_department_id, holder_section_id, -SUM(qty) as held, MIN(CASE WHEN type = \'ALLOCATE\' THEN moved_on END) as since, MAX(device_serial_no) as device_sn')
            ->groupBy('equipment_id', 'serial_no', 'holder_type', 'holder_user_id', 'holder_department_id', 'holder_section_id')->havingRaw('-SUM(qty) > 0')->get();
        $eq = Equipment::with(['assetType', 'category', 'subcategory'])->whereIn('id', $rows->pluck('equipment_id'))->get()->keyBy('id');
        $users = User::with('department')->whereIn('id', $rows->pluck('holder_user_id')->filter())->get()->keyBy('id');
        $depts = Department::whereIn('id', $rows->pluck('holder_department_id')->filter())->get()->keyBy('id');
        $offices = Section::with('department')->whereIn('id', $rows->pluck('holder_section_id')->filter())->get()->keyBy('id');

        return $rows->map(function ($x) use ($eq, $users, $depts, $offices) {
            $x->equipment = $eq[$x->equipment_id];
            $x->holder = match ($x->holder_type) {
                'EMPLOYEE' => $users[$x->holder_user_id]->name ?? '—',
                'OFFICE' => ($offices[$x->holder_section_id]->name ?? '—').' (office)',
                default => ($depts[$x->holder_department_id]->name ?? '—').' (dept)',
            };
            $x->dept = match ($x->holder_type) {
                'EMPLOYEE' => $users[$x->holder_user_id]->department->name ?? '',
                'OFFICE' => $offices[$x->holder_section_id]->department->name ?? '',
                default => '',
            };
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

    /** One holder (employee, department or office) with everything they currently hold; equipment is shown here and returned from here. */
    public function holder(string $holder)
    {
        [$kind, $id] = array_pad(explode('-', $holder, 2), 2, null);
        abort_unless(in_array($kind, ['E', 'D', 'O'], true) && ctype_digit((string) $id), 404);
        $isEmp = $kind === 'E';
        $isOffice = $kind === 'O';
        $who = match ($kind) { 'E' => User::with('department')->findOrFail($id), 'O' => Section::with('department')->findOrFail($id), default => Department::findOrFail($id) };
        $rows = $this->holdings(fn ($q) => match ($kind) {
            'E' => $q->where('holder_type', 'EMPLOYEE')->where('holder_user_id', $id),
            'O' => $q->where('holder_type', 'OFFICE')->where('holder_section_id', $id),
            default => $q->where('holder_type', 'DEPARTMENT')->where('holder_department_id', $id),
        });

        return view('inventory.allocations.holder', ['who' => $who, 'isEmp' => $isEmp, 'isOffice' => $isOffice, 'rows' => $rows, 'holderId' => $holder]);
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
        // All equipment is offered: a previous allocation does not need anything in stock (the page narrows the list to what is in stock for a normal allocation)
        $equipment = $this->equipment();
        $serials = $equipment->filter(fn ($e) => $e->is_serialized)->mapWithKeys(fn ($e) => [$e->id => $this->svc()->serialInfo($e)]);

        return view('inventory.allocations.create', ['equipment' => $equipment, 'serials' => $serials, 'people' => $this->people(), 'departments' => $this->departments(), 'offices' => $this->offices()]);
    }

    /** Active offices (Configuration > Offices) with their department, for the pickers. */
    protected function offices($also = null)
    {
        return Section::with('department:id,name')->where(fn ($q) => $q->where('is_active', true)->when($also, fn ($w, $id) => $w->orWhere('id', $id)))
            ->orderBy('name')->get(['id', 'department_id', 'name']);
    }

    public function store(Request $r)
    {
        $d = $r->validate(['to_type' => 'required|in:EMPLOYEE,DEPARTMENT,OFFICE', 'user_id' => 'required_if:to_type,EMPLOYEE|nullable|exists:users,id',
            'department_id' => 'required_if:to_type,DEPARTMENT|nullable|exists:departments,id', 'section_id' => 'required_if:to_type,OFFICE|nullable|exists:sections,id',
            'date' => 'required|date|before_or_equal:today', 'reference_no' => 'nullable|string|max:255', 'previous' => 'nullable|boolean',
            'lines' => 'required|array|min:1', 'lines.*.equipment_id' => 'required|exists:inv_equipment,id', 'lines.*.qty' => 'nullable|numeric|gt:0', 'lines.*.purpose' => 'nullable|string|max:500', 'lines.*.device_serial_no' => 'nullable|string|max:120']);
        $lines = array_values($d['lines']);
        $this->assertSelectable($lines);

        // Serialisable items need no quantity (always one unit, serial generated); every other item needs one.
        foreach ($lines as $i => $l) {
            $e = Equipment::with('category')->findOrFail($l['equipment_id']);
            if (! $e->is_serialized && empty($l['qty'])) throw ValidationException::withMessages(["lines.$i.qty" => "Enter a quantity for {$e->name}."]);
        }

        // Previous allocation: the item was already with them before this system. It is added to stock with the original date and handed out
        // on the same date, so stock stays unchanged and the holder shows in "Who has what" (and can return it later through Receives).
        if ($r->boolean('previous')) {
            foreach ($lines as $i => $l) {
                if (Equipment::find($l['equipment_id'])->is_serialized) $lines[$i]['qty'] = 1;   // serialisable equipment is one unit per line
            }
            $this->svc()->receivePrevious($d, $lines, ['type' => $d['to_type'], 'user_id' => $d['user_id'] ?? null, 'department_id' => $d['department_id'] ?? null, 'section_id' => $d['section_id'] ?? null]);
            $entry = $this->svc()->lastAllocEntry;

            return redirect()->route('inv.allocations.entries')->with('ok', "Previous allocation recorded as {$entry}.");
        }

        $entry = $this->svc()->allocate(['type' => $d['to_type'], 'user_id' => $d['user_id'] ?? null, 'department_id' => $d['department_id'] ?? null, 'section_id' => $d['section_id'] ?? null], $d, $lines);

        return redirect()->route('inv.allocations.entries')->with('ok', "Allocated and recorded as {$entry}.");
    }

    /**
     * How much of each allocation line has been returned, keyed by movement id. A serialisable unit is returned when a later return of
     * the same asset ID by the same holder exists; other equipment: the holder's returns are applied to their allocations oldest first.
     *
     * @param \Illuminate\Support\Collection $lines ALLOCATE movements
     * @return array<int,float>
     */
    /** Return entries (RC-…) that brought each allocation line back, keyed by movement id; filled by returnedByLine(). */
    protected array $returnEntries = [];

    protected function returnedByLine($lines): array
    {
        $out = [];
        $this->returnEntries = [];
        $same = fn ($q, $m) => $q->where('equipment_id', $m->equipment_id)->where('holder_type', $m->holder_type)
            ->where('holder_user_id', $m->holder_user_id)->where('holder_department_id', $m->holder_department_id)->where('holder_section_id', $m->holder_section_id);
        foreach ($lines->whereNotNull('serial_no') as $m) {
            $r = $same(Movement::where('type', 'RETURN')->where('serial_no', $m->serial_no)->where('id', '>', $m->id), $m)->orderBy('id')->first();
            $out[$m->id] = $r ? abs((float) $m->qty) : 0.0;
            if ($r && $r->entry_no) $this->returnEntries[$m->id] = [$r->entry_no];
        }
        foreach ($lines->whereNull('serial_no')->groupBy(fn ($m) => implode('|', [$m->equipment_id, $m->holder_type, $m->holder_user_id, $m->holder_department_id, $m->holder_section_id])) as $g) {
            $first = $g->first();
            $rets = $same(Movement::where('type', 'RETURN')->whereNull('serial_no'), $first)->orderBy('id')->get()->map(fn ($x) => ['entry' => $x->entry_no, 'left' => (float) $x->qty])->all();
            foreach ($same(Movement::where('type', 'ALLOCATE')->whereNull('serial_no'), $first)->orderBy('id')->get() as $a) {
                $need = abs((float) $a->qty);
                $out[$a->id] = 0.0;
                foreach ($rets as &$x) {
                    if ($need <= 0) break;
                    $take = min($x['left'], $need);
                    if ($take <= 0) continue;
                    $x['left'] = round($x['left'] - $take, 2);
                    $need = round($need - $take, 2);
                    $out[$a->id] = round($out[$a->id] + $take, 2);
                    if ($x['entry']) $this->returnEntries[$a->id][] = $x['entry'];
                }
                unset($x);
                if (isset($this->returnEntries[$a->id])) $this->returnEntries[$a->id] = array_values(array_unique($this->returnEntries[$a->id]));
            }
        }

        return $out;
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
                ->orWhereHas('holderUser', fn ($u) => $u->where('name', 'like', "%$s%"))->orWhereHas('holderDepartment', fn ($d) => $d->where('name', 'like', "%$s%"))->orWhereHas('holderSection', fn ($d) => $d->where('name', 'like', "%$s%"))));
        $with = ['equipment.assetType', 'equipment.category', 'equipment.subcategory', 'user', 'holderUser.department', 'holderDepartment', 'holderSection.department'];

        if ($r->input('format') === 'csv') {
            return $this->csv('allocation_records', ['Entry', 'Date', 'Allocated to', 'Department', 'Code', 'Equipment', 'Asset ID', 'Serial number', 'Quantity', 'Purpose', 'Reference', 'By'],
                (clone $base)->with($with)->latest('moved_on')->latest('id')->get()->map(fn ($m) => [$m->entry_no, $m->moved_on->format('Y-m-d'), $m->holder_name, $m->holderUser?->department?->name ?? $m->holderSection?->department?->name ?? '', $m->equipment->code, $m->equipment->name,
                    $m->serial_no, $m->device_serial_no, \App\Support\Inv::qty(abs($m->qty)), $m->remarks, $m->reference_no, $m->user->name ?? '']));
        }

        $entries = (clone $base)->select('entry_no')->selectRaw('MAX(id) as last_id')->groupBy('entry_no')->orderByDesc('last_id')->paginate(40)->withQueryString();
        $lines = Movement::with($with)->where('type', 'ALLOCATE')->whereIn('entry_no', $entries->pluck('entry_no'))->orderBy('id')->get()->groupBy('entry_no');

        $returned = $this->returnedByLine($lines->collapse());

        return view('inventory.allocations.entries', ['entries' => $entries, 'lines' => $lines, 'returned' => $returned, 'equipment' => $this->equipment()]);
    }

    /** All lines of one allocation entry; 404 when there is none, 403 unless the user may see it (inventory view, or it was handed to them / their department). */
    protected function entryLines(string $entry)
    {
        $lines = Movement::with(['equipment.assetType', 'equipment.category', 'equipment.subcategory', 'user', 'holderUser.department', 'holderDepartment', 'holderSection.department'])
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
            ->when($f->holder_type === 'EMPLOYEE', fn ($q) => $q->where('holder_user_id', $f->holder_user_id),
                fn ($q) => $f->holder_type === 'OFFICE' ? $q->where('holder_section_id', $f->holder_section_id) : $q->where('holder_department_id', $f->holder_department_id))
            ->selectRaw('equipment_id, serial_no, -SUM(qty) as held')->groupBy('equipment_id', 'serial_no')->get()
            ->mapWithKeys(fn ($x) => [$x->equipment_id.'|'.($x->serial_no ?? '') => (float) $x->held]);

        return view('inventory.allocations.show', ['entry' => $entry, 'lines' => $lines, 'first' => $f, 'held' => $held, 'returned' => $this->returnedByLine($lines), 'returnEntries' => $this->returnEntries,
            'isPrevious' => Movement::where('entry_no', $entry)->where('no_stock', true)->exists()]);
    }

    /** PDF handover form of one allocation entry: every equipment handed over in it. */
    public function pdf(string $entry)
    {
        $lines = $this->entryLines($entry);

        return Pdf::loadView('inventory.allocation-pdf', ['entry' => $entry, 'lines' => $lines, 'first' => $lines->first(), 'generatedAt' => now(), 'generatedBy' => auth()->user()->name])
            ->setPaper('a4', 'portrait')->download('Allocation_'.$entry.'.pdf');
    }

    /**
     * Bangla PDF handover form. DomPDF cannot join Bangla letters (conjuncts, vowel signs), so this one is made with mPDF
     * (composer require mpdf/mpdf) and the Kalpurush font in resources/fonts (Noto Sans Bengali breaks mPDF's font reader).
     */
    public function pdfBn(string $entry)
    {
        if (! \App\Support\BanglaPdf::available()) {
            return redirect()->back()->with('error', 'The Bangla PDF needs the mPDF package. Run: composer require mpdf/mpdf');
        }
        $lines = $this->entryLines($entry);
        $html = view('inventory.allocation-pdf-bn', ['entry' => $entry, 'lines' => $lines, 'first' => $lines->first()])->render();
        $pdf = \App\Support\BanglaPdf::render($html, '<div style="text-align:center;font-size:8pt;color:#6a7389">'.e($entry).' · Generated: '.now()->format('d/m/Y H:i').'</div>');

        return response($pdf, 200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'attachment; filename="Allocation_'.$entry.'_bn.pdf"']);
    }

    /** System Administrator only: edit one allocation entry (who has it, date, reference, quantities, purposes, manufacturer serial numbers). */
    public function edit(string $entry)
    {
        $lines = $this->entryLines($entry);
        $first = $lines->first();
        $people = $this->people();
        if ($first->holder_user_id && ! $people->contains('id', $first->holder_user_id)) $people = $people->push($first->holderUser)->sortBy('name')->values();   // a holder who is no longer active stays selectable
        $departments = $this->departments();
        if ($first->holder_department_id && ! $departments->contains('id', $first->holder_department_id)) $departments = $departments->push($first->holderDepartment)->sortBy('name')->values();

        return view('inventory.allocations.edit', ['entry' => $entry, 'lines' => $lines, 'first' => $first, 'returned' => $this->returnedByLine($lines), 'people' => $people, 'departments' => $departments, 'offices' => $this->offices($first->holder_section_id),
            'isPrevious' => Movement::where('entry_no', $entry)->where('no_stock', true)->exists()]);
    }

    public function update(Request $r, string $entry)
    {
        $lines = $this->entryLines($entry);
        $d = $r->validate(['to_type' => 'required|in:EMPLOYEE,DEPARTMENT,OFFICE', 'user_id' => 'required_if:to_type,EMPLOYEE|nullable|exists:users,id',
            'department_id' => 'required_if:to_type,DEPARTMENT|nullable|exists:departments,id', 'section_id' => 'required_if:to_type,OFFICE|nullable|exists:sections,id',
            'date' => 'required|date|before_or_equal:today', 'reference_no' => 'nullable|string|max:255',
            'lines' => 'required|array', 'lines.*.qty' => 'nullable|numeric|gt:0', 'lines.*.purpose' => 'nullable|string|max:500', 'lines.*.device_serial_no' => 'nullable|string|max:120']);

        try {
            $res = $this->svc()->updateEntry($entry, ['ALLOCATE', 'PRIOR'], $d, collect($d['lines'])->only($lines->pluck('id')->all())->all(),
                ['type' => $d['to_type'], 'user_id' => $d['user_id'] ?? null, 'department_id' => $d['department_id'] ?? null, 'section_id' => $d['section_id'] ?? null]);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        }

        return redirect()->route('inv.allocations.show', $entry)->with('ok', $res['changed'] ? "{$entry} was updated and the stock was adjusted." : 'No changes were made.');
    }

    /** System Administrator only: delete a whole allocation entry; its stock effect is reversed (refused when that would break the records). */
    public function destroy(string $entry)
    {
        try {
            $this->svc()->deleteEntry($entry, ['ALLOCATE', 'PRIOR']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', collect($e->errors())->flatten()->first());
        }

        return redirect()->route('inv.allocations.entries')->with('ok', "{$entry} was deleted and the stock was adjusted.");
    }
}
