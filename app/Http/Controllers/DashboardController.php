<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
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
        $tickets = Ticket::visibleTo($u)->with(['status', 'priority', 'category', 'assignee'])->latest()->paginate(15);
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
            'SLA Breached' => Ticket::where('sla_status', 'breached')->count(),
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

        $team = User::active()->assignable()->orderBy('name')->get()->map(function ($m) use ($rows, $supportCounts) {
            $r = $rows->get($m->id, collect());
            $n = fn (array $codes) => $r->whereIn('code', $codes)->sum('c');
            return (object) [
                'user' => $m,
                'assigned' => $n(['ASSIGNED', 'REOPENED', 'ESCALATED']),
                'in_progress' => $n(['IN_PROGRESS']),
                'pending' => $n(['WAITING_USER', 'ON_HOLD']),
                'resolved' => $n(['RESOLVED', 'USER_CONFIRMATION', 'CLOSED']),
                'open' => $r->where('is_open', 1)->sum('c'),
                'supporting' => $supportCounts[$m->id] ?? 0,
            ];
        });

        // Kanban-style assignment board: unassigned column + one column per IT member
        $memberList = User::active()->assignable()->orderBy('name')->get();
        $openTickets = Ticket::open()->with(['priority', 'department', 'team'])->orderBy('created_at')->limit(400)->get()
            ->sortBy(fn ($t) => $t->priority->level)->values();
        $card = fn ($t) => [
            'id' => $t->id, 'no' => $t->ticket_no, 'subject' => $t->subject,
            'dept' => $t->department->name, 'priority' => $t->priority->name,
            'due' => $t->due_date?->format('d M'), 'sla' => $t->sla_status,
            'url' => route('tickets.show', $t),
            'support' => $t->team->where('role', 'SUPPORT')->map(fn ($m) => $m->employee->name)->values()->all(),
        ];
        $columns = [[
            'id' => null, 'name' => 'Unassigned',
            'tickets' => $openTickets->whereNull('assigned_to')->map($card)->values()->all(),
        ]];
        foreach ($memberList as $m) {
            $columns[] = [
                'id' => $m->id, 'name' => $m->name,
                'tickets' => $openTickets->where('assigned_to', $m->id)->map($card)->values()->all(),
            ];
        }
        $board = [
            'columns' => $columns,
            'canAssign' => auth()->user()->can('ticket.assign'),
            'assignUrl' => route('tickets.assign', ['ticket' => '__ID__']),
        ];

        $byDept = Ticket::join('departments as d', 'd.id', '=', 'tickets.department_id')
            ->whereNull('tickets.deleted_at')->select('d.name', DB::raw('count(*) as c'))->groupBy('d.name')->pluck('c', 'name');
        $byCat = Ticket::join('ticket_categories as c', 'c.id', '=', 'tickets.category_id')
            ->whereNull('tickets.deleted_at')->select('c.name', DB::raw('count(*) as c'))->groupBy('c.name')->pluck('c', 'name');
        $byPrio = Ticket::join('ticket_priorities as p', 'p.id', '=', 'tickets.priority_id')
            ->whereNull('tickets.deleted_at')->select('p.name', DB::raw('count(*) as c'))->groupBy('p.name')->pluck('c', 'name');

        // Last 6 months trend (portable across MySQL/SQLite: group in PHP)
        $trend = Ticket::where('created_at', '>=', now()->startOfMonth()->subMonths(5))->pluck('created_at')
            ->groupBy(fn ($d) => $d->format('Y-m'))->map->count();
        $months = collect(range(5, 0))->map(fn ($i) => now()->startOfMonth()->subMonths($i)->format('Y-m'));
        $trend = $months->mapWithKeys(fn ($m) => [$m => $trend[$m] ?? 0]);

        return view('dashboard.officer', compact('stats', 'team', 'board', 'byDept', 'byCat', 'byPrio', 'trend'));
    }

    protected function member(User $u)
    {
        $mine = Ticket::involving($u)->with(['status', 'priority', 'department', 'category', 'assignee', 'team']);
        $counts = Ticket::involving($u)
            ->join('ticket_statuses as s', 's.id', '=', 'tickets.status_id')
            ->select('s.code', DB::raw('count(*) as c'))->groupBy('s.code')->pluck('c', 'code');

        $stats = [
            'New / Assigned' => ($counts['ASSIGNED'] ?? 0) + ($counts['REOPENED'] ?? 0) + ($counts['ESCALATED'] ?? 0),
            'In Progress' => $counts['IN_PROGRESS'] ?? 0,
            'Waiting' => ($counts['WAITING_USER'] ?? 0) + ($counts['ON_HOLD'] ?? 0),
            'Overdue' => Ticket::involving($u)->open()->whereNotNull('due_date')->whereDate('due_date', '<', today())->count(),
            'Resolved' => ($counts['RESOLVED'] ?? 0) + ($counts['USER_CONFIRMATION'] ?? 0) + ($counts['CLOSED'] ?? 0),
        ];

        $open = (clone $mine)->open()
            ->join('ticket_priorities as p', 'p.id', '=', 'tickets.priority_id')
            ->orderBy('p.level')->orderBy('tickets.due_date')->select('tickets.*')->get();

        return view('dashboard.member', compact('stats', 'open'));
    }
}
