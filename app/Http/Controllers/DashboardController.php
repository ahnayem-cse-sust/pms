<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $u = auth()->user();

        if ($u->hasPermission('dashboard.officer')) {
            return $this->officer();
        }
        if ($u->hasPermission('dashboard.member')) {
            return $this->member($u);
        }
        $tickets = Ticket::visibleTo($u)->with(['status', 'category', 'assignee', 'type'])->latest()->paginate(15);
        return view('dashboard.department', compact('tickets'));
    }

    protected function officer()
    {
        $byStatus = Ticket::join('ticket_statuses as s', 's.id', '=', 'tickets.status_id')
            ->whereNull('tickets.deleted_at')
            ->select('s.code', DB::raw('count(*) as c'))->groupBy('s.code')->pluck('c', 'code');

        $stats = [
            'Total' => $byStatus->sum(),
            'New' => $byStatus['NEW'] ?? 0,
            'Assigned' => $byStatus['ASSIGNED'] ?? 0,
            'In Progress' => $byStatus['IN_PROGRESS'] ?? 0,
            'Waiting' => ($byStatus['WAITING_USER'] ?? 0) + ($byStatus['ON_HOLD'] ?? 0),
            'Resolved' => ($byStatus['RESOLVED'] ?? 0) + ($byStatus['USER_CONFIRMATION'] ?? 0),
            'Closed' => $byStatus['CLOSED'] ?? 0,
        ];

        // Team workload per IT member
        $rows = Ticket::join('ticket_statuses as s', 's.id', '=', 'tickets.status_id')
            ->whereNull('tickets.deleted_at')->whereNotNull('assigned_to')
            ->select('assigned_to', 's.code', 's.is_open', DB::raw('count(*) as c'))
            ->groupBy('assigned_to', 's.code', 's.is_open')->get()->groupBy('assigned_to');

        // Open requests where each employee is a supporting (not primary) team member
        $supportCounts = DB::table('ticket_assignments as a')
            ->join('tickets as t', 't.id', '=', 'a.ticket_id')
            ->join('ticket_statuses as s', 's.id', '=', 't.status_id')
            ->whereNull('t.deleted_at')->where('s.is_open', 1)->where('a.role', 'SUPPORT')
            ->select('a.employee_id', DB::raw('count(*) as c'))->groupBy('a.employee_id')->pluck('c', 'employee_id');

        // Resolved / confirmed / closed requests where each employee was a supporting team member
        $supportDone = DB::table('ticket_assignments as a')
            ->join('tickets as t', 't.id', '=', 'a.ticket_id')
            ->join('ticket_statuses as s', 's.id', '=', 't.status_id')
            ->whereNull('t.deleted_at')->where('a.role', 'SUPPORT')
            ->whereIn('s.code', ['RESOLVED', 'USER_CONFIRMATION', 'CLOSED'])
            ->select('a.employee_id', DB::raw('count(*) as c'))->groupBy('a.employee_id')->pluck('c', 'employee_id');

        $team = User::active()->assignable()->orderBy('name')->get()->map(function ($m) use ($rows, $supportCounts, $supportDone) {
            $r = $rows->get($m->id, collect());
            $n = fn (array $codes) => $r->whereIn('code', $codes)->sum('c');
            return (object) [
                'user' => $m,
                'assigned' => $n(['ASSIGNED', 'REOPENED', 'ESCALATED']),
                'in_progress' => $n(['IN_PROGRESS']),
                'pending' => $n(['WAITING_USER', 'ON_HOLD']),
                'resolved' => $n(['RESOLVED', 'USER_CONFIRMATION', 'CLOSED']),
                'open' => $r->where('is_open', 1)->sum('c') + ($supportCounts[$m->id] ?? 0),
                'supporting' => $supportCounts[$m->id] ?? 0,
                'support_resolved' => $supportDone[$m->id] ?? 0,
            ];
        });

        $byDept = Ticket::join('departments as d', 'd.id', '=', 'tickets.department_id')
            ->whereNull('tickets.deleted_at')->select('d.name', DB::raw('count(*) as c'))->groupBy('d.name')->pluck('c', 'name');
        $byCat = Ticket::join('ticket_categories as c', 'c.id', '=', 'tickets.category_id')
            ->whereNull('tickets.deleted_at')->select('c.name', DB::raw('count(*) as c'))->groupBy('c.name')->pluck('c', 'name');

        // Last 6 months trend (portable across MySQL/SQLite: group in PHP)
        $trend = Ticket::where('created_at', '>=', now()->startOfMonth()->subMonths(5))->pluck('created_at')
            ->groupBy(fn ($d) => $d->format('Y-m'))->map->count();
        $months = collect(range(5, 0))->map(fn ($i) => now()->startOfMonth()->subMonths($i)->format('Y-m'));
        $trend = $months->mapWithKeys(fn ($m) => [$m => $trend[$m] ?? 0]);

        return view('dashboard.officer', compact('stats', 'team', 'byDept', 'byCat', 'trend'));
    }

    /** Assignment board (own menu item): unassigned column + one column per IT employee, primary and supporting work. */
    public function board()
    {
        // Column order = the saved board position (drag a column header to change it), then name for anyone not placed yet
        $memberList = User::active()->assignable()->orderByRaw('board_position is null')->orderBy('board_position')->orderBy('name')->get();
        $openTickets = Ticket::open()->with(['department', 'team.employee', 'assignee', 'status'])->orderBy('created_at')->limit(400)->get();
        $card = fn ($t) => [
            'id' => $t->id, 'no' => $t->ticket_no, 'subject' => $t->subject,
            'dept' => $t->department->name,
            'due' => $t->due_date?->format('d M'),
            'url' => route('tickets.show', $t),
            'support' => $t->team->where('role', 'SUPPORT')->map(fn ($m) => $m->employee->name)->values()->all(),
            'role' => 'primary',
            'primary' => $t->assignee?->name,
        ];
        $backlog = fn ($t) => $t->status->code === 'BACKLOG';   // Backlog requests have a column of their own
        $columns = [[
            'id' => null, 'key' => 'backlog', 'name' => 'Backlog',
            'tickets' => $openTickets->filter($backlog)->map($card)->values()->all(),
        ], [
            'id' => null, 'key' => 'unassigned', 'name' => 'Unassigned',
            'tickets' => $openTickets->filter(fn ($t) => $t->assigned_to === null && ! $backlog($t))->map($card)->values()->all(),
        ]];
        foreach ($memberList as $m) {
            $primary = $openTickets->where('assigned_to', $m->id)->reject($backlog)->map($card)->values()->all();
            // Requests where this employee is a supporting (not primary) team member
            $support = $openTickets->filter(fn ($t) => ! $backlog($t) && (int) $t->assigned_to !== (int) $m->id
                    && $t->team->contains(fn ($x) => (int) $x->employee_id === (int) $m->id && $x->role === 'SUPPORT'))
                ->map(fn ($t) => array_merge($card($t), ['role' => 'support']))->values()->all();
            $columns[] = [
                'id' => $m->id, 'name' => $m->name,
                'avatar' => $m->avatar_path ? route('avatar.show', $m).'?v='.optional($m->updated_at)->timestamp : null,
                'tickets' => array_merge($primary, $support),
            ];
        }
        $board = [
            'columns' => $columns,
            'canAssign' => auth()->user()->can('ticket.assign'),
            'orderUrl' => route('board.order'),
        ];

        return view('dashboard.board', compact('board'));
    }

    /** Save the order of the employee columns (drag and drop on the board). */
    public function boardOrder(Request $r)
    {
        abort_unless($r->user()->can('ticket.assign'), 403);
        $ids = $r->validate(['ids' => 'required|array|min:1', 'ids.*' => 'integer'])['ids'];
        foreach (array_values($ids) as $i => $id) {
            User::whereKey($id)->update(['board_position' => $i + 1]);
        }

        return response()->json(['ok' => true]);
    }

    protected function member(User $u)
    {
        $mine = Ticket::involving($u)->with(['status', 'department', 'category', 'assignee', 'team', 'type']);
        $counts = Ticket::involving($u)
            ->join('ticket_statuses as s', 's.id', '=', 'tickets.status_id')
            ->select('s.code', DB::raw('count(*) as c'))->groupBy('s.code')->pluck('c', 'code');

        $stats = [
            'New / Assigned' => ($counts['ASSIGNED'] ?? 0) + ($counts['REOPENED'] ?? 0) + ($counts['ESCALATED'] ?? 0),
            'In Progress' => $counts['IN_PROGRESS'] ?? 0,
            'Waiting' => ($counts['WAITING_USER'] ?? 0) + ($counts['ON_HOLD'] ?? 0),
            // Open requests where this employee is a supporting (not primary) team member
            'Supporting' => Ticket::open()
                ->where(fn ($w) => $w->whereNull('tickets.assigned_to')->orWhere('tickets.assigned_to', '!=', $u->id))
                ->whereHas('assignees', fn ($t) => $t->where('employee_id', $u->id)->where('role', 'SUPPORT'))
                ->count(),
            'Overdue' => Ticket::involving($u)->open()->whereNotNull('due_date')->whereDate('due_date', '<', today())->count(),
            'Resolved' => ($counts['RESOLVED'] ?? 0) + ($counts['USER_CONFIRMATION'] ?? 0) + ($counts['CLOSED'] ?? 0),
            // Resolved / confirmed / closed requests where this employee was a supporting team member
            'Support resolved' => Ticket::whereHas('status', fn ($x) => $x->whereIn('code', ['RESOLVED', 'USER_CONFIRMATION', 'CLOSED']))
                ->whereHas('assignees', fn ($t) => $t->where('employee_id', $u->id)->where('role', 'SUPPORT'))
                ->count(),
        ];

        $open = (clone $mine)->open()
            ->orderByRaw('tickets.due_date is null')->orderBy('tickets.due_date')->orderBy('tickets.created_at')->select('tickets.*')->paginate(15)->withQueryString();

        return view('dashboard.member', compact('stats', 'open'));
    }
}
