<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('itsm.roles') as $slug => $name) {
            // Only create missing roles: permissions edited on the Roles screen must survive a re-seed.
            Role::firstOrCreate(['slug' => $slug], [
                'name' => $name,
                'permissions' => config("itsm.permissions.$slug", []),
            ]);
        }
    }
}
