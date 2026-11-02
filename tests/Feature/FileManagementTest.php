<?php

namespace Tests\Feature;

use App\Models\DepartmentFile;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** File Management: department files with file number, title, shelf number and section. */
class FileManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    protected function u(string $email): User { return User::where('email', $email)->firstOrFail(); }
    protected function sysadmin(): User { return $this->u('nayem.jocl@gmail.com'); }
    protected function officer(): User { return $this->u('it_admin@joplc.com'); }

    protected function data(array $over = []): array
    {
        return $over + ['file_no' => 'F-001', 'title' => 'Vendor agreements 2026', 'shelf_no' => 'S-12', 'section' => 'Accounts'];
    }

    public function test_it_admin_can_add_edit_and_search_files(): void
    {
        $this->actingAs($this->officer())->post(route('files.store'), $this->data())->assertRedirect(route('files.index'))->assertSessionHas('ok');
        $f = DepartmentFile::firstOrFail();
        $this->assertSame(['F-001', 'Vendor agreements 2026', 'S-12', 'Accounts'], [$f->file_no, $f->title, $f->shelf_no, $f->section]);

        $this->actingAs($this->officer())->put(route('files.update', $f), $this->data(['title' => 'Vendor contracts', 'shelf_no' => 'S-13']))->assertSessionHas('ok');
        $this->assertSame('S-13', $f->fresh()->shelf_no);

        $this->actingAs($this->officer())->get(route('files.index', ['q' => 'contracts']))->assertOk()->assertSee('Vendor contracts')->assertSee('S-13');
        $this->actingAs($this->officer())->get(route('files.index', ['section' => 'HR']))->assertOk()->assertDontSee('Vendor contracts');
    }

    public function test_the_file_list_can_be_downloaded_as_pdf_by_anyone_who_can_view_files(): void
    {
        DepartmentFile::create($this->data());
        $res = $this->actingAs($this->officer())->get(route('files.pdf', ['section' => 'Accounts']))->assertOk();
        $this->assertStringContainsString('application/pdf', $res->headers->get('content-type'));
        $this->assertStringContainsString('Department-Files_', $res->headers->get('content-disposition'));

        $this->actingAs($this->u('sales_user@joplc.com'))->get(route('files.pdf'))->assertRedirect()->assertSessionHas('denied');
        $this->actingAs($this->officer())->get(route('files.index'))->assertOk()->assertSee('Download PDF');
    }

    public function test_all_four_fields_are_required_and_the_file_number_is_unique(): void
    {
        foreach (['file_no', 'title', 'shelf_no', 'section'] as $field) {
            $this->actingAs($this->officer())->post(route('files.store'), $this->data([$field => '']))->assertSessionHasErrors($field);
        }
        DepartmentFile::create($this->data());
        $this->actingAs($this->officer())->post(route('files.store'), $this->data(['title' => 'Other']))->assertSessionHasErrors('file_no');
        $this->assertSame(1, DepartmentFile::count());
    }

    public function test_only_the_system_administrator_can_delete_a_file(): void
    {
        $f = DepartmentFile::create($this->data());

        $this->actingAs($this->officer())->delete(route('files.destroy', $f))->assertRedirect()->assertSessionHas('denied');
        $this->assertNotNull($f->fresh());

        $this->actingAs($this->sysadmin())->delete(route('files.destroy', $f))->assertRedirect(route('files.index'))->assertSessionHas('ok');
        $this->assertNull($f->fresh());
    }

    public function test_other_roles_cannot_open_file_management_and_it_shows_in_the_sidebar_for_those_who_can(): void
    {
        $this->actingAs($this->u('sales_user@joplc.com'))->get(route('files.index'))->assertRedirect()->assertSessionHas('denied');
        $this->actingAs($this->u('it_emp@joplc.com'))->get(route('files.create'))->assertRedirect()->assertSessionHas('denied');

        $this->actingAs($this->officer())->get(route('files.index'))->assertOk()->assertSee('File Management');
        $this->actingAs($this->sysadmin())->get(route('dashboard'))->assertOk()->assertSee(route('files.index'), false);
    }
}
