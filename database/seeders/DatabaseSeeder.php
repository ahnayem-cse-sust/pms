<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([ItsmLookupSeeder::class, RoleSeeder::class]);

        $it = Department::firstOrCreate(['code' => 'IT'], ['name' => 'Information Technology']);

        // First administrator. Change the password immediately after first login.
        $admin = User::updateOrCreate(['email' => 'admin@joplc.local'], [
            'name' => 'System Administrator',
            'password' => env('ITSM_ADMIN_PASSWORD', 'ChangeMe@12345'),
            'employee_id' => 'E0001',
            'department_id' => $it->id,
            'is_active' => true,
        ]);
        $admin->roles()->syncWithoutDetaching([Role::where('slug', 'admin')->value('id')]);

        if (! app()->isProduction()) {
            $this->call(DemoSeeder::class);
        }
    }
}
