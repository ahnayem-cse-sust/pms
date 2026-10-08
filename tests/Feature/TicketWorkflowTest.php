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
}
