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
        $this->assertMatchesRegularExpression('/^IT-\d{4}-000001$/', $t->ticket_no);
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
}
