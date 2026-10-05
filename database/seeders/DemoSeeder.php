<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

/** Demo data for local/UAT only. Every demo account uses the password below. */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $pw = 'ChangeMe@12345';
        $role = fn (string $s) => Role::where('slug', $s)->value('id');

        foreach ([['Sales', 'SAL'], ['Accounts', 'ACC'], ['HR', 'HR'], ['Marketing', 'MKT'], ['Administration', 'ADM']] as [$n, $c]) {
            Department::firstOrCreate(['code' => $c], ['name' => $n]);
        }
        foreach (['Officer', 'Executive', 'Manager', 'Assistant'] as $n) {
            Designation::firstOrCreate(['name' => $n]);
        }
        $loc = Location::firstOrCreate(['name' => 'Head Office']);
        $it = Department::where('code', 'IT')->first();
        $desig = Designation::first()->id;

        $mk = function (string $email, string $name, string $empId, string $roleSlug, ?int $dept, bool $head = false) use ($pw, $role, $loc, $desig) {
            $u = User::updateOrCreate(['email' => $email], [
                'name' => $name, 'password' => $pw, 'employee_id' => $empId,
                'department_id' => $dept,
                'designation_id' => $desig, 'location_id' => $loc->id,
                'is_department_head' => $head, 'is_active' => true,
            ]);
            // $roleSlug may be one slug or an array of slugs (a user can hold several roles)
            $u->roles()->syncWithoutDetaching(array_map($role, (array) $roleSlug));
        };

        $mk('officer@joplc.local', 'IT Admin', 'E1001', 'it_officer', $it->id);
        foreach (range(1, 5) as $i) {
            $mk("member{$i}@joplc.local", "IT Member {$i}", 'E110' . $i, 'it_member', $it->id);
        }
        $acc = Department::where('code', 'ACC')->value('id');
        $sal = Department::where('code', 'SAL')->value('id');
        $mk('accounts.user@joplc.local', 'Md. Rahim', 'E2001', 'dept_user', $acc);
        $mk('accounts.head@joplc.local', 'Accounts Head', 'E2002', 'dept_head', $acc, true);
        $mk('sales.user@joplc.local', 'Sales User', 'E3001', 'dept_user', $sal);
        $mk('mgmt@joplc.local', 'Management', 'E9001', 'management', null);
    }
}
