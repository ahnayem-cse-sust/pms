<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/** Users: details page, edit from the details page, and delete (System Administrator only). Same test database as the other tests. */
class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    protected function officer(): User { return User::where('email', 'it_admin@joplc.com')->firstOrFail(); }
    protected function person(): User { return User::where('email', 'acct_user@joplc.com')->firstOrFail(); }
    protected function sysadmin(): User { return User::where('email', 'nayem.jocl@gmail.com')->firstOrFail(); }

    protected function throwaway(): User
    {
        return User::create(['name' => 'Temp Person', 'email' => 'temp.person@joplc.com', 'password' => 'Temp-pass-1', 'is_active' => true]);
    }

    public function test_the_list_has_no_role_or_last_login_column_and_links_to_the_details_page(): void
    {
        $person = $this->person();
        $res = $this->actingAs($this->officer())->get(route('admin.users.index'))->assertOk();
        $res->assertDontSee('<th>Role</th>', false)->assertDontSee('<th>Last login</th>', false);
        $res->assertSee(route('admin.users.show', $person), false);
        $res->assertDontSee(route('admin.users.edit', $person), false);   // Edit lives on the details page
    }

    public function test_the_details_page_shows_the_user_with_an_edit_button(): void
    {
        $person = $this->person();
        $res = $this->actingAs($this->officer())->get(route('admin.users.show', $person))->assertOk();
        $res->assertSee($person->name)->assertSee($person->email)->assertSee('Last login')->assertSee('Roles');
        $res->assertSee(route('admin.users.edit', $person), false);
    }

    public function test_a_user_without_view_permission_cannot_open_the_details_page(): void
    {
        $this->actingAs($this->person())->get(route('admin.users.show', $this->officer()))->assertRedirect()->assertSessionHas('denied');
    }

    public function test_it_admin_cannot_open_the_details_of_a_system_administrator(): void
    {
        $this->actingAs($this->officer())->get(route('admin.users.show', $this->sysadmin()))->assertRedirect()->assertSessionHas('denied');
    }

    public function test_saving_an_edit_returns_to_the_details_page(): void
    {
        $person = $this->person();
        $this->actingAs($this->officer())->put(route('admin.users.update', $person), [
            'name' => 'Renamed Person', 'email' => $person->email, 'role_ids' => $person->roles->pluck('id')->all(), 'is_active' => 1,
        ])->assertRedirect(route('admin.users.show', $person))->assertSessionHas('ok');
        $this->assertSame('Renamed Person', $person->fresh()->name);
    }

    public function test_only_the_system_administrator_sees_and_can_use_delete(): void
    {
        $temp = $this->throwaway();
        $this->actingAs($this->officer())->get(route('admin.users.show', $temp))->assertOk()->assertDontSee('value="DELETE"', false);
        $this->actingAs($this->officer())->delete(route('admin.users.destroy', $temp))->assertRedirect()->assertSessionHas('denied');
        $this->assertNotNull($temp->fresh());

        $this->actingAs($this->sysadmin())->get(route('admin.users.show', $temp))->assertOk()->assertSee('value="DELETE"', false);
    }

    public function test_the_system_administrator_can_delete_a_user_with_no_records(): void
    {
        $temp = $this->throwaway();
        $this->actingAs($this->sysadmin())->delete(route('admin.users.destroy', $temp))->assertRedirect(route('admin.users.index'))->assertSessionHas('ok');
        $this->assertNull(User::find($temp->id));
        $this->assertTrue(AuditLog::where('event', 'user.deleted')->where('auditable_id', $temp->id)->exists());
    }

    public function test_nobody_can_delete_their_own_account(): void
    {
        $admin = $this->sysadmin();
        $this->actingAs($admin)->delete(route('admin.users.destroy', $admin))->assertRedirect()->assertSessionHas('error');
        $this->assertNotNull($admin->fresh());
        $this->actingAs($admin)->get(route('admin.users.show', $admin))->assertOk()->assertDontSee('value="DELETE"', false);
    }

    public function test_a_user_who_already_has_records_cannot_be_deleted(): void
    {
        $temp = $this->throwaway();
        DB::table('inv_movements')->insert(['ref' => 'T-1', 'moved_on' => today()->toDateString(), 'type' => 'ALLOCATE', 'equipment_id' => 1, 'qty' => -1,
            'holder_type' => 'EMPLOYEE', 'holder_user_id' => $temp->id, 'created_at' => now()]);
        $this->actingAs($this->sysadmin())->delete(route('admin.users.destroy', $temp))->assertRedirect()->assertSessionHas('error');
        $this->assertNotNull($temp->fresh());
        $this->actingAs($this->sysadmin())->get(route('admin.users.show', $temp))->assertOk()->assertSee('disable the account instead');
    }

    public function test_the_details_page_lists_the_users_permissions(): void
    {
        $person = $this->person();
        $res = $this->actingAs($this->officer())->get(route('admin.users.show', $person))->assertOk();
        $res->assertSee('Permissions')->assertSee('View own requests')->assertSee('Allowed')->assertSee('Denied');   // inherited ones too, not only individual changes
        $res->assertDontSee(route('admin.users.permissions', $person), false);   // the IT admin cannot edit permissions
    }

    public function test_the_user_edit_form_no_longer_holds_the_permissions(): void
    {
        $this->actingAs($this->sysadmin())->get(route('admin.users.edit', $this->person()))->assertOk()->assertDontSee('Individual permissions');
    }

    public function test_the_system_administrator_edits_permissions_on_their_own_screen(): void
    {
        $person = $this->person();
        $this->actingAs($this->sysadmin())->get(route('admin.users.show', $person))->assertOk()->assertSee(route('admin.users.permissions', $person), false);
        $this->actingAs($this->sysadmin())->get(route('admin.users.permissions', $person))->assertOk()->assertSee('Individual permissions')->assertSee('btn-inh-allow', false)->assertSee('btn-inh-deny', false)->assertSee('Inherit · Allowed')->assertSee('Inherit · Denied');

        $this->actingAs($this->sysadmin())->put(route('admin.users.permissions.update', $person), ['perm' => ['report.view' => 'allow', 'ticket.create' => 'deny']])
            ->assertRedirect(route('admin.users.show', $person))->assertSessionHas('ok');
        $person = $person->fresh();
        $this->assertContains('report.view', $person->extra_permissions);
        $this->assertContains('ticket.create', $person->denied_permissions);
        $this->assertTrue(AuditLog::where('event', 'user.permissions_updated')->where('auditable_id', $person->id)->exists());
        $this->actingAs($this->sysadmin())->get(route('admin.users.show', $person))->assertOk()->assertSee('Denied')->assertSee('allowed for this user only');
    }

    public function test_saving_the_user_form_leaves_permissions_alone(): void
    {
        $person = $this->person();
        $person->forceFill(['extra_permissions' => ['report.view']])->save();
        $this->actingAs($this->sysadmin())->put(route('admin.users.update', $person), ['name' => $person->name, 'email' => $person->email, 'role_ids' => $person->roles->pluck('id')->all(), 'is_active' => 1])->assertSessionHas('ok');
        $this->assertSame(['report.view'], $person->fresh()->extra_permissions);
    }

    public function test_only_users_who_can_update_roles_may_open_the_permissions_screen(): void
    {
        $this->actingAs($this->officer())->get(route('admin.users.permissions', $this->person()))->assertRedirect()->assertSessionHas('denied');
        $this->actingAs($this->officer())->put(route('admin.users.permissions.update', $this->person()), ['perm' => ['report.view' => 'allow']])->assertRedirect()->assertSessionHas('denied');
        $this->assertEmpty($this->person()->extra_permissions);
    }

    public function test_nobody_edits_their_own_permissions(): void
    {
        $admin = $this->sysadmin();
        $this->actingAs($admin)->get(route('admin.users.permissions', $admin))->assertRedirect()->assertSessionHas('denied');
    }
}
