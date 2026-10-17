<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Ticket;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Run against a MySQL test database (set DB_* in .env.testing / phpunit.xml).
 * Seeds the accounts from UserSeeder (see README).
 */
class TicketWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    protected function u(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    /** A second IT employee, so auto-assign has someone to choose between. */
    protected function extraMember(): User
    {
        $u = User::create([
            'name' => 'Extra IT Employee', 'email' => 'it_emp2@joplc.com', 'password' => '123456',
            'department_id' => $this->u('it_emp@joplc.com')->department_id, 'is_active' => true,
        ]);
        $u->roles()->sync([Role::where('slug', 'it_member')->value('id')]);
        return $u;
    }

    protected function submit(User $requester): Ticket
    {
        $this->actingAs($requester)->post(route('tickets.store'), [
            'ticket_type_id' => 1, 'category_id' => 1, 'priority_id' => 3,
            'subject' => 'Unable to print Sales Invoice', 'description' => 'Printer offline',
        ])->assertRedirect();
        return Ticket::latest('id')->firstOrFail();
    }

    public function test_ticket_number_and_visibility(): void
    {
        $t = $this->submit($this->u('sales_user@joplc.com'));
        $this->assertSame('RQ-1', $t->ticket_no);
        $this->assertSame('RQ-2', $this->submit($this->u('sales_user@joplc.com'))->ticket_no);   // running counter, no year, no padding
        $this->assertSame('NEW', $t->status->code);

        $this->actingAs($this->u('acct_user@joplc.com'))->get(route('tickets.show', $t))->assertForbidden();
        $this->actingAs($this->u('it_admin@joplc.com'))->get(route('tickets.show', $t))->assertOk();
    }

    public function test_full_lifecycle_to_closed(): void
    {
        $requester = $this->u('sales_user@joplc.com');
        $officer = $this->u('it_admin@joplc.com');
        $member = $this->u('it_emp@joplc.com');
        $t = $this->submit($requester);

        $this->actingAs($officer)->post(route('tickets.assign', $t), ['assignee_id' => $member->id])->assertSessionHasNoErrors();
        $this->assertSame('ASSIGNED', $t->fresh()->status->code);

        $this->actingAs($member)->post(route('tickets.transition', $t), ['to' => 'IN_PROGRESS'])->assertSessionHasNoErrors();
        // resolution text is mandatory
        $this->actingAs($member)->post(route('tickets.transition', $t), ['to' => 'RESOLVED'])->assertSessionHasErrors('comment');
        $this->actingAs($member)->post(route('tickets.transition', $t), ['to' => 'RESOLVED', 'comment' => 'Printer reconnected'])->assertSessionHasNoErrors();
        $this->assertSame('USER_CONFIRMATION', $t->fresh()->status->code);

        $this->actingAs($requester)->post(route('tickets.transition', $t), ['to' => 'CLOSED'])->assertSessionHasNoErrors();
        $this->assertSame('CLOSED', $t->fresh()->status->code);
        $this->assertNotNull($t->fresh()->closed_at);
    }

    public function test_requester_can_reopen_and_cannot_assign(): void
    {
        $requester = $this->u('sales_user@joplc.com');
        $member = $this->u('it_emp@joplc.com');
        $t = $this->submit($requester);
        $this->actingAs($this->u('it_admin@joplc.com'))->post(route('tickets.assign', $t), ['assignee_id' => $member->id]);
        $this->actingAs($member)->post(route('tickets.transition', $t), ['to' => 'IN_PROGRESS']);
        $this->actingAs($member)->post(route('tickets.transition', $t), ['to' => 'RESOLVED', 'comment' => 'Done']);

        $this->actingAs($requester)->post(route('tickets.assign', $t), ['assignee_id' => $member->id])->assertForbidden();
        $this->actingAs($requester)->post(route('tickets.transition', $t), ['to' => 'REOPENED', 'comment' => 'Still failing'])->assertSessionHasNoErrors();
        $this->assertSame('REOPENED', $t->fresh()->status->code);
        $this->assertSame(1, $t->fresh()->reopen_count);
    }

    public function test_internal_notes_hidden_from_requester(): void
    {
        $requester = $this->u('sales_user@joplc.com');
        $t = $this->submit($requester);
        $this->actingAs($this->u('it_admin@joplc.com'))->post(route('tickets.note', $t), ['body' => 'SECRET-ROOT-CAUSE'])->assertSessionHasNoErrors();

        $this->actingAs($requester)->get(route('tickets.show', $t))->assertOk()->assertDontSee('SECRET-ROOT-CAUSE');
        $this->actingAs($this->u('it_admin@joplc.com'))->get(route('tickets.show', $t))->assertSee('SECRET-ROOT-CAUSE');
    }

    public function test_auto_assign_picks_least_loaded_member(): void
    {
        $officer = $this->u('it_admin@joplc.com');
        $requester = $this->u('sales_user@joplc.com');
        $busy = $this->u('it_emp@joplc.com');
        $idle = $this->extraMember();

        $first = $this->submit($requester);
        $this->actingAs($officer)->post(route('tickets.assign', $first), ['assignee_id' => $busy->id]);

        // the IT Admin is also in the pool, so give them a ticket too
        $own = $this->submit($requester);
        $this->actingAs($officer)->post(route('tickets.assign', $own), ['assignee_id' => $officer->id]);

        $second = $this->submit($requester);
        $this->actingAs($officer)->post(route('tickets.assign', $second), ['auto' => 1]);
        $this->assertSame($idle->id, $second->fresh()->assigned_to);
    }

    public function test_it_admin_can_submit_on_behalf_of_another_user(): void
    {
        $officer = $this->u('it_admin@joplc.com');
        $sales = $this->u('sales_user@joplc.com');

        $this->actingAs($officer)->post(route('tickets.store'), [
            'requester_id' => $sales->id, 'ticket_type_id' => 1, 'category_id' => 1, 'priority_id' => 3,
            'subject' => 'Printer down (phone call)', 'description' => 'Reported by phone',
        ])->assertRedirect();

        $t = Ticket::latest('id')->firstOrFail();
        $this->assertSame($sales->id, $t->requester_id);
        $this->assertSame($officer->id, $t->created_by);
        $this->assertSame('Sales', $t->department->name);
        $this->actingAs($sales)->get(route('tickets.show', $t))->assertOk()->assertSee('Filed on behalf');
    }

    public function test_plain_user_cannot_submit_on_behalf(): void
    {
        $this->actingAs($this->u('acct_user@joplc.com'))->post(route('tickets.store'), [
            'requester_id' => $this->u('sales_user@joplc.com')->id, 'ticket_type_id' => 1, 'category_id' => 1,
            'priority_id' => 3, 'subject' => 'x', 'description' => 'y',
        ])->assertForbidden();
    }

    public function test_department_head_limited_to_own_department(): void
    {
        $head = $this->u('acct_head@joplc.com');
        $payload = ['ticket_type_id' => 1, 'category_id' => 1, 'priority_id' => 3, 'subject' => 's', 'description' => 'd'];

        $this->actingAs($head)->post(route('tickets.store'), $payload + ['requester_id' => $this->u('acct_user@joplc.com')->id])->assertRedirect();
        $this->actingAs($head)->post(route('tickets.store'), $payload + ['requester_id' => $this->u('sales_user@joplc.com')->id])->assertForbidden();
    }

    public function test_attendance_entry_is_first_office_login_and_exit_is_last_office_logout(): void
    {
        $emp = $this->u('it_emp@joplc.com');
        $day = today();
        $log = fn (string $time, string $ip, string $event = 'login', bool $ok = true) => \App\Models\LoginHistory::create([
            'user_id' => $emp->id, 'email_tried' => $emp->email, 'successful' => $ok, 'event' => $event,
            'ip_address' => $ip, 'created_at' => $day->copy()->setTimeFromTimeString($time),
        ]);
        $log('07:45:00', '10.0.0.5');                       // login from outside -> ignored
        $log('09:00:00', '103.16.73.139');                  // ENTRY (first office login)
        $log('13:10:00', '103.4.67.236');                   // later login: not the entry
        $log('13:40:00', '103.16.73.140', 'logout');        // earlier logout: not the exit
        $log('17:30:00', '103.16.73.141', 'logout');        // EXIT (last office logout)
        $log('18:30:00', '103.16.73.141');                  // a later login must NOT become the exit
        $log('20:10:00', '8.8.8.8', 'logout');              // logout from outside -> ignored

        $this->actingAs($this->u('sharif99452@gmail.com'))->get(route('attendance.index'))
            ->assertOk()
            ->assertSee('IT Employee')
            ->assertSee('09:00 AM')
            ->assertSee('05:30 PM')
            ->assertSee('8h 30m')
            ->assertDontSee('06:30 PM')
            ->assertDontSee('08:10 PM')
            ->assertDontSee('07:45 AM')
            ->assertSee('Search attendance')
            ->assertSee('Download PDF')
            ->assertSee('15 per page');
    }

    public function test_manual_logout_is_recorded_and_idle_sessions_are_closed_at_last_activity(): void
    {
        $office = ['REMOTE_ADDR' => '103.16.73.139'];
        $emp = $this->u('it_emp@joplc.com');

        $this->withServerVariables($office)->post(route('login'), ['email' => $emp->email, 'password' => '123456']);
        $this->assertDatabaseHas('login_histories', ['user_id' => $emp->id, 'event' => 'login', 'ip_address' => '103.16.73.139']);

        $this->withServerVariables($office)->post(route('logout'));
        $this->assertDatabaseHas('login_histories', ['user_id' => $emp->id, 'event' => 'logout', 'reason' => 'manual', 'ip_address' => '103.16.73.139']);

        // idle session: the sweep records the logout at the last activity, not at sweep time
        $last = now()->subMinutes(40)->startOfSecond();
        $emp->forceFill(['session_open' => true, 'last_activity_at' => $last, 'last_activity_ip' => '103.4.67.236'])->save();
        $this->artisan('itsm:record-logouts')->assertSuccessful();

        $row = \App\Models\LoginHistory::where('user_id', $emp->id)->where('reason', 'timeout')->firstOrFail();
        $this->assertSame('logout', $row->event);
        $this->assertSame('103.4.67.236', $row->ip_address);
        $this->assertTrue($row->created_at->equalTo($last));
        $this->assertFalse($emp->fresh()->session_open);
    }

    public function test_attendance_is_for_management_only(): void
    {
        $this->actingAs($this->u('it_admin@joplc.com'))->get(route('attendance.index'))->assertForbidden();
        $this->actingAs($this->u('it_emp@joplc.com'))->get(route('attendance.index'))->assertForbidden();
        $this->actingAs($this->u('acct_user@joplc.com'))->get(route('attendance.index'))->assertForbidden();
        $this->actingAs($this->u('sharif99452@gmail.com'))->get(route('attendance.index'))->assertOk();
        $this->actingAs($this->u('nayem.jocl@gmail.com'))->get(route('attendance.index'))->assertOk();
    }

    public function test_it_employee_sees_only_own_attendance_and_not_the_management_page(): void
    {
        $emp = $this->u('it_emp@joplc.com');
        $other = $this->extraMember();
        foreach ([$emp, $other] as $u) {
            \App\Models\LoginHistory::create(['user_id' => $u->id, 'email_tried' => $u->email, 'successful' => true,
                'ip_address' => '103.16.73.139', 'created_at' => today()->setTime(9, 5)]);
        }

        $this->actingAs($emp)->get(route('attendance.mine'))->assertOk()
            ->assertSee('IT Employee')->assertDontSee('Extra IT Employee')->assertDontSee('Download PDF')->assertSee('15 per page');
        $this->actingAs($emp)->get(route('attendance.index'))->assertForbidden();
        $this->actingAs($emp)->get(route('attendance.pdf'))->assertForbidden();
        $this->actingAs($this->u('sharif99452@gmail.com'))->get(route('attendance.mine'))->assertForbidden();
    }

    public function test_attendance_is_paginated_15_per_page(): void
    {
        $emp = $this->u('it_emp@joplc.com');
        $emp->forceFill(['created_at' => today()->subDays(60)])->save();
        $url = route('attendance.index', ['from' => today()->subDays(19)->format('Y-m-d'), 'to' => today()->format('Y-m-d')]);

        $this->actingAs($this->u('sharif99452@gmail.com'))->get($url)->assertOk()->assertSee('page=2')->assertSee('of 20 records');
    }

    public function test_pdf_download_has_no_one_month_limit_but_range_is_capped_at_six_months(): void
    {
        $mgmt = $this->u('sharif99452@gmail.com');

        // 40 days: fine (the old one-month limit is gone)
        $this->actingAs($mgmt)
            ->get(route('attendance.pdf', ['from' => today()->subDays(40)->format('Y-m-d'), 'to' => today()->format('Y-m-d')]))
            ->assertOk()->assertHeader('content-type', 'application/pdf');

        // 7 months: rejected on the page and on the PDF
        $tooLong = ['from' => today()->subMonths(7)->format('Y-m-d'), 'to' => today()->format('Y-m-d')];
        $this->actingAs($mgmt)->from(route('attendance.index'))->get(route('attendance.pdf', $tooLong))
            ->assertRedirect(route('attendance.index'))->assertSessionHasErrors('to');
        $this->actingAs($mgmt)->from(route('attendance.index'))->get(route('attendance.index', $tooLong))
            ->assertSessionHasErrors('to');

        // exactly 6 months is allowed
        $this->actingAs($mgmt)->get(route('attendance.index', ['from' => today()->subMonthsNoOverflow(6)->format('Y-m-d'), 'to' => today()->format('Y-m-d')]))
            ->assertOk();
    }

    public function test_from_date_cannot_be_after_to_date(): void
    {
        $this->actingAs($this->u('sharif99452@gmail.com'))->from(route('attendance.index'))
            ->get(route('attendance.index', ['from' => today()->format('Y-m-d'), 'to' => today()->subDays(3)->format('Y-m-d')]))
            ->assertRedirect(route('attendance.index'))->assertSessionHasErrors('from');
    }

    public function test_user_is_signed_out_after_15_minutes_of_inactivity(): void
    {
        $u = $this->u('acct_user@joplc.com');

        $this->actingAs($u)->withSession(['last_activity_at' => now()->subMinutes(14)->timestamp])
            ->get(route('dashboard'))->assertOk();

        $this->actingAs($u)->withSession(['last_activity_at' => now()->subMinutes(16)->timestamp])
            ->get(route('dashboard'))->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_session_lifetime_outlives_the_inactivity_limit_so_the_login_page_does_not_expire(): void
    {
        $this->assertGreaterThan(config('itsm.inactivity_minutes'), (int) config('session.lifetime'));
        $this->get(route('login'))->assertOk()->assertHeader('Cache-Control');
    }

    public function test_it_admin_can_be_assigned_a_ticket_like_an_it_employee(): void
    {
        $admin = $this->u('it_admin@joplc.com');
        $t = $this->submit($this->u('sales_user@joplc.com'));

        $this->actingAs($admin)->post(route('tickets.assign', $t), ['assignee_id' => $admin->id])->assertSessionHasNoErrors();
        $this->assertSame($admin->id, $t->fresh()->assigned_to);
        $this->assertSame('ASSIGNED', $t->fresh()->status->code);

        // ...and can work on it
        $this->actingAs($admin)->post(route('tickets.transition', $t), ['to' => 'IN_PROGRESS'])->assertSessionHasNoErrors();
        $this->assertSame('IN_PROGRESS', $t->fresh()->status->code);

        // another IT Admin can assign to this one too, and the dashboard lists them in the team workload
        $this->actingAs($admin)->get(route('dashboard'))->assertOk()->assertSee('IT Admin');
        $this->assertTrue(\App\Models\User::active()->assignable()->whereKey($admin->id)->exists());
    }

    public function test_it_staff_my_requests_and_my_tasks_menus(): void
    {
        $emp = $this->u('it_emp@joplc.com');
        $officer = $this->u('it_admin@joplc.com');
        $sales = $this->u('sales_user@joplc.com');
        $payload = fn (string $subject, array $extra = []) => $extra + [
            'ticket_type_id' => 1, 'category_id' => 1, 'priority_id' => 3, 'subject' => $subject, 'description' => 'd',
        ];

        // A: filed by the IT employee for himself
        $this->actingAs($emp)->post(route('tickets.store'), $payload('REQ-OWN'));
        // B: filed for the IT employee by someone else
        $this->actingAs($officer)->post(route('tickets.store'), $payload('REQ-BEHALF', ['requester_id' => $emp->id]));
        // C: filed by the IT employee for another person -> not "his" request
        $this->actingAs($emp)->post(route('tickets.store'), $payload('REQ-FOR-OTHERS', ['requester_id' => $sales->id]));
        // D: someone else's request, assigned to the IT employee
        $this->actingAs($sales)->post(route('tickets.store'), $payload('REQ-ASSIGNED'));
        $this->actingAs($officer)->post(route('tickets.assign', Ticket::where('subject', 'REQ-ASSIGNED')->firstOrFail()), ['assignee_id' => $emp->id]);

        $this->actingAs($emp)->get(route('tickets.mine'))->assertOk()
            ->assertSee('REQ-OWN')->assertSee('REQ-BEHALF')
            ->assertDontSee('REQ-FOR-OTHERS')->assertDontSee('REQ-ASSIGNED');

        $this->actingAs($emp)->get(route('tasks.index'))->assertOk()
            ->assertSee('REQ-ASSIGNED')
            ->assertDontSee('REQ-OWN')->assertDontSee('REQ-BEHALF')->assertDontSee('REQ-FOR-OTHERS');

        // the IT Admin keeps a full list, plus their own two
        $this->actingAs($officer)->get(route('tickets.index'))->assertOk()
            ->assertSee('REQ-OWN')->assertSee('REQ-FOR-OTHERS')->assertSee('REQ-ASSIGNED');
        $this->actingAs($officer)->get(route('tickets.mine'))->assertOk()->assertDontSee('REQ-OWN');
        $this->actingAs($officer)->get(route('tasks.index'))->assertOk()->assertDontSee('REQ-ASSIGNED');

        // other roles do not have these two menus
        $this->actingAs($sales)->get(route('tickets.mine'))->assertForbidden();
        $this->actingAs($sales)->get(route('tasks.index'))->assertForbidden();
    }

    public function test_timeout_logout_is_stored_at_the_real_last_activity_time_not_utc(): void
    {
        $emp = $this->u('it_emp@joplc.com');
        $emp->forceFill(['session_open' => true])->save();
        $last = now()->subMinutes(20)->startOfSecond();

        // The stale session is noticed on the next request (middleware path)
        $this->actingAs($emp)
            ->withSession(['last_activity_at' => $last->timestamp, 'last_activity_ip' => '103.16.73.139'])
            ->get(route('dashboard'))->assertRedirect(route('login'));

        $raw = \Illuminate\Support\Facades\DB::table('login_histories')
            ->where('user_id', $emp->id)->where('event', 'logout')->value('created_at');
        $this->assertSame($last->format('Y-m-d H:i:s'), $raw);   // GMT+6 wall-clock, not 6 hours earlier

        // The browser's idle timer path (POST /logout with idle=1)
        $emp->forceFill(['session_open' => true])->save();
        $this->actingAs($emp)
            ->withSession(['last_activity_at' => $last->timestamp, 'last_activity_ip' => '103.16.73.139'])
            ->post(route('logout'), ['idle' => 1]);
        $rows = \Illuminate\Support\Facades\DB::table('login_histories')
            ->where('user_id', $emp->id)->where('event', 'logout')->pluck('created_at');
        $this->assertCount(2, $rows);
        $this->assertSame([$last->format('Y-m-d H:i:s')], $rows->unique()->values()->all());
    }

    // ---------------------------------------------------------------- team assignment (one primary + supporters)

    private function teamTicket(): array
    {
        $admin = $this->u('it_admin@joplc.com');
        $primary = $this->u('it_emp@joplc.com');
        $support = $this->extraMember();
        $t = $this->submit($this->u('sales_user@joplc.com'));
        $this->actingAs($admin)->post(route('tickets.team', $t), [
            'primary_id' => $primary->id, 'support_ids' => [$support->id, $admin->id], 'instructions' => 'Fix network and printer',
        ])->assertSessionHasNoErrors();
        return [$t, $admin, $primary, $support];
    }

    public function test_it_admin_assigns_one_primary_and_several_supporting_employees(): void
    {
        [$t, $admin, $primary, $support] = $this->teamTicket();

        $rows = \App\Models\TicketAssignment::where('ticket_id', $t->id)->get();
        $this->assertCount(3, $rows);
        $this->assertSame(1, $rows->where('role', 'PRIMARY')->count());
        $this->assertSame($primary->id, $rows->firstWhere('role', 'PRIMARY')->employee_id);
        $this->assertSame($primary->id, $t->fresh()->assigned_to);          // shortcut to the primary
        $this->assertSame('ASSIGNED', $t->fresh()->status->code);
        $this->assertEqualsCanonicalizing([$support->id, $admin->id], $rows->where('role', 'SUPPORT')->pluck('employee_id')->all());

        // who assigned them, and when, is recorded
        $this->assertSame($admin->id, $rows->first()->assigned_by);
        $this->assertNotNull($rows->first()->assigned_at);

        // a primary who is also ticked as support is not duplicated
        $this->actingAs($admin)->post(route('tickets.team', $t), ['primary_id' => $primary->id, 'support_ids' => [$primary->id, $support->id]]);
        $this->assertSame(2, \App\Models\TicketAssignment::where('ticket_id', $t->id)->count());
    }

    public function test_the_database_refuses_a_second_primary(): void
    {
        [$t, $admin, $primary, $support] = $this->teamTicket();

        $this->expectException(\Illuminate\Database\QueryException::class);
        \App\Models\TicketAssignment::create([
            'ticket_id' => $t->id, 'employee_id' => $this->u('sales_user@joplc.com')->id, 'role' => 'PRIMARY',
            'assigned_by' => $admin->id, 'assigned_at' => now(),
        ]);
    }

    public function test_only_it_staff_can_be_on_a_team(): void
    {
        $admin = $this->u('it_admin@joplc.com');
        $t = $this->submit($this->u('sales_user@joplc.com'));

        $this->actingAs($admin)->post(route('tickets.team', $t), [
            'primary_id' => $this->u('it_emp@joplc.com')->id, 'support_ids' => [$this->u('acct_user@joplc.com')->id],
        ])->assertSessionHasErrors('support_ids');
        $this->assertSame(0, \App\Models\TicketAssignment::where('ticket_id', $t->id)->count());   // nothing half-saved

        $this->actingAs($this->u('it_emp@joplc.com'))->post(route('tickets.team', $t), ['primary_id' => $admin->id])->assertForbidden();
    }

    public function test_supporting_employee_records_own_progress_but_only_the_primary_resolves(): void
    {
        [$t, $admin, $primary, $support] = $this->teamTicket();

        // supporter: sees the request, lists it under My Tasks, can update their own work...
        $this->actingAs($support)->get(route('tickets.show', $t))->assertOk()->assertSee('My work update');
        $this->actingAs($support)->get(route('tasks.index'))->assertOk()->assertSee($t->ticket_no);
        $this->actingAs($support)->post(route('tickets.work', $t), ['work_status' => 'IN_PROGRESS', 'note' => 'Checked the printer driver'])
            ->assertSessionHasNoErrors();
        $row = \App\Models\TicketAssignment::where('ticket_id', $t->id)->where('employee_id', $support->id)->first();
        $this->assertSame('IN_PROGRESS', $row->work_status);
        $this->assertSame('Checked the printer driver', $row->remarks);
        $this->assertDatabaseHas('ticket_work_updates', ['ticket_id' => $t->id, 'user_id' => $support->id, 'note' => 'Checked the printer driver']);
        $this->assertTrue($primary->fresh()->notifications()->where('data', 'like', '%updated their work%')->exists());

        // ...but cannot move or resolve the request
        $this->actingAs($support)->post(route('tickets.transition', $t), ['to' => 'IN_PROGRESS'])->assertSessionHasErrors('status');
        $this->actingAs($support)->post(route('tickets.transition', $t), ['to' => 'RESOLVED', 'comment' => 'done'])->assertSessionHasErrors('status');

        // the primary coordinates and submits the final resolution; everybody's part becomes Done
        $this->actingAs($primary)->post(route('tickets.transition', $t), ['to' => 'IN_PROGRESS'])->assertSessionHasNoErrors();
        $this->actingAs($primary)->post(route('tickets.transition', $t), ['to' => 'RESOLVED', 'comment' => 'Network and printer fixed'])->assertSessionHasNoErrors();
        $this->assertSame('USER_CONFIRMATION', $t->fresh()->status->code);
        $this->assertSame(['DONE'], \App\Models\TicketAssignment::where('ticket_id', $t->id)->pluck('work_status')->unique()->values()->all());

        // someone not on the team cannot post work updates
        $outsider = $this->u('it_emp@joplc.com'); // primary is on the team, so use a fresh member instead
        $other = \App\Models\User::create(['name' => 'Outsider', 'email' => 'it_emp3@joplc.com', 'password' => '123456',
            'department_id' => $outsider->department_id, 'is_active' => true]);
        $other->roles()->sync([\App\Models\Role::where('slug', 'it_member')->value('id')]);
        $this->actingAs($other)->get(route('tickets.show', $t))->assertForbidden();
    }

    public function test_changing_the_primary_keeps_the_supporting_team_and_logs_it(): void
    {
        [$t, $admin, $primary, $support] = $this->teamTicket();

        // IT Admin hands the primary role to the (current) supporter
        $this->actingAs($admin)->post(route('tickets.team', $t), [
            'primary_id' => $support->id, 'support_ids' => [$primary->id, $admin->id],
        ])->assertSessionHasNoErrors();

        $rows = \App\Models\TicketAssignment::where('ticket_id', $t->id)->get();
        $this->assertSame(1, $rows->where('role', 'PRIMARY')->count());
        $this->assertSame($support->id, $rows->firstWhere('role', 'PRIMARY')->employee_id);
        $this->assertSame($support->id, $t->fresh()->assigned_to);
        $this->assertDatabaseHas('ticket_history', ['ticket_id' => $t->id, 'action' => 'reassigned', 'new_value' => $support->name]);
        $this->assertDatabaseHas('ticket_history', ['ticket_id' => $t->id, 'action' => 'team_role_changed']);

        // the quick "assign" (drag-and-drop) changes only the primary and keeps the supporters
        $this->actingAs($admin)->post(route('tickets.assign', $t), ['assignee_id' => $primary->id])->assertSessionHasNoErrors();
        $rows = \App\Models\TicketAssignment::where('ticket_id', $t->id)->get();
        $this->assertSame($primary->id, $rows->firstWhere('role', 'PRIMARY')->employee_id);
        $this->assertContains($admin->id, $rows->where('role', 'SUPPORT')->pluck('employee_id')->all());

        // removing someone from the team
        $this->actingAs($admin)->post(route('tickets.team', $t), ['primary_id' => $primary->id, 'support_ids' => []]);
        $this->assertSame(1, \App\Models\TicketAssignment::where('ticket_id', $t->id)->count());
        $this->assertDatabaseHas('ticket_history', ['ticket_id' => $t->id, 'action' => 'team_removed']);
    }

    public function test_primary_employee_and_it_admin_can_escalate_with_a_comment(): void
    {
        [$t, $admin, $primary, $support] = $this->teamTicket();
        $this->actingAs($primary)->post(route('tickets.transition', $t), ['to' => 'IN_PROGRESS']);

        // the Escalate button is offered to the primary, but not to a supporting employee
        $this->actingAs($primary)->get(route('tickets.show', $t))->assertOk()->assertSee('Escalate');
        $this->actingAs($support)->get(route('tickets.show', $t))->assertOk()->assertDontSee('Escalate');
        $this->actingAs($support)->post(route('tickets.transition', $t), ['to' => 'ESCALATED', 'comment' => 'x'])->assertSessionHasErrors('status');

        // a reason is required
        $this->actingAs($primary)->post(route('tickets.transition', $t), ['to' => 'ESCALATED'])->assertSessionHasErrors('comment');
        $this->actingAs($primary)->post(route('tickets.transition', $t), ['to' => 'ESCALATED', 'comment' => 'Needs the vendor'])->assertSessionHasNoErrors();
        $this->assertSame('ESCALATED', $t->fresh()->status->code);
        $this->assertTrue($admin->fresh()->notifications()->where('data', 'like', '%ESCALATED%')->orWhere('data', 'like', '%Escalated%')->exists());
    }

    public function test_it_admin_can_escalate_a_brand_new_request(): void
    {
        $t = $this->submit($this->u('sales_user@joplc.com'));
        $admin = $this->u('it_admin@joplc.com');

        $this->actingAs($admin)->post(route('tickets.transition', $t), ['to' => 'ESCALATED', 'comment' => 'Critical for payroll run'])->assertSessionHasNoErrors();
        $this->assertSame('ESCALATED', $t->fresh()->status->code);
        // the requester cannot escalate their own request
        $other = $this->submit($this->u('sales_user@joplc.com'));
        $this->actingAs($this->u('sales_user@joplc.com'))->post(route('tickets.transition', $other), ['to' => 'ESCALATED', 'comment' => 'x'])->assertSessionHasErrors('status');
    }
}
