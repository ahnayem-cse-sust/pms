<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Run against a MySQL test database (set DB_* in .env.testing / phpunit.xml).
 * Seeds the demo users, so APP_ENV must not be "production".
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
        $t = $this->submit($this->u('sales.user@joplc.local'));
        $this->assertMatchesRegularExpression('/^IT-\d{4}-000001$/', $t->ticket_no);
        $this->assertSame('NEW', $t->status->code);

        $this->actingAs($this->u('accounts.user@joplc.local'))->get(route('tickets.show', $t))->assertForbidden();
        $this->actingAs($this->u('officer@joplc.local'))->get(route('tickets.show', $t))->assertOk();
    }

    public function test_full_lifecycle_to_closed(): void
    {
        $requester = $this->u('sales.user@joplc.local');
        $officer = $this->u('officer@joplc.local');
        $member = $this->u('member1@joplc.local');
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
        $requester = $this->u('sales.user@joplc.local');
        $member = $this->u('member1@joplc.local');
        $t = $this->submit($requester);
        $this->actingAs($this->u('officer@joplc.local'))->post(route('tickets.assign', $t), ['assignee_id' => $member->id]);
        $this->actingAs($member)->post(route('tickets.transition', $t), ['to' => 'IN_PROGRESS']);
        $this->actingAs($member)->post(route('tickets.transition', $t), ['to' => 'RESOLVED', 'comment' => 'Done']);

        $this->actingAs($requester)->post(route('tickets.assign', $t), ['assignee_id' => $member->id])->assertForbidden();
        $this->actingAs($requester)->post(route('tickets.transition', $t), ['to' => 'REOPENED', 'comment' => 'Still failing'])->assertSessionHasNoErrors();
        $this->assertSame('REOPENED', $t->fresh()->status->code);
        $this->assertSame(1, $t->fresh()->reopen_count);
    }

    public function test_internal_notes_hidden_from_requester(): void
    {
        $requester = $this->u('sales.user@joplc.local');
        $t = $this->submit($requester);
        $this->actingAs($this->u('officer@joplc.local'))->post(route('tickets.note', $t), ['body' => 'SECRET-ROOT-CAUSE'])->assertSessionHasNoErrors();

        $this->actingAs($requester)->get(route('tickets.show', $t))->assertOk()->assertDontSee('SECRET-ROOT-CAUSE');
        $this->actingAs($this->u('officer@joplc.local'))->get(route('tickets.show', $t))->assertSee('SECRET-ROOT-CAUSE');
    }

    public function test_auto_assign_picks_least_loaded_member(): void
    {
        $officer = $this->u('officer@joplc.local');
        $requester = $this->u('sales.user@joplc.local');
        $busy = $this->u('member1@joplc.local');

        $first = $this->submit($requester);
        $this->actingAs($officer)->post(route('tickets.assign', $first), ['assignee_id' => $busy->id]);

        $second = $this->submit($requester);
        $this->actingAs($officer)->post(route('tickets.assign', $second), ['auto' => 1]);
        $this->assertNotSame($busy->id, $second->fresh()->assigned_to);
    }
}
