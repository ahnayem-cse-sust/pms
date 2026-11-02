<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * File Management: tracks physical department files (file number, title, shelf number, section).
 * Also hands the new file.* permissions and sidebar menu to the existing roles (the database copy of a role is authoritative).
 */
return new class extends Migration
{
    private array $grants = [
        'admin' => ['file.view', 'file.create', 'file.update', 'file.delete', 'menu.files'],
        'it_officer' => ['file.view', 'file.create', 'file.update', 'menu.files'],
    ];

    public function up(): void
    {
        Schema::create('department_files', function (Blueprint $t) {
            $t->id();
            $t->string('file_no', 50)->unique();
            $t->string('title', 255);
            $t->string('shelf_no', 50);
            $t->string('section', 150)->index();
            $t->timestamps();
        });

        foreach ($this->grants as $slug => $add) {
            foreach (DB::table('roles')->where('slug', $slug)->get() as $role) {
                $perms = array_values(array_unique(array_merge(json_decode($role->permissions, true) ?: [], $add)));
                DB::table('roles')->where('id', $role->id)->update(['permissions' => json_encode($perms), 'updated_at' => now()]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('department_files');

        $all = ['file.view', 'file.create', 'file.update', 'file.delete', 'menu.files'];
        foreach (DB::table('roles')->get() as $role) {
            $perms = array_values(array_diff(json_decode($role->permissions, true) ?: [], $all));
            DB::table('roles')->where('id', $role->id)->update(['permissions' => json_encode($perms)]);
        }
    }
};
