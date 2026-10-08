<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Master data (departments, designations, location) plus the accounts below – nothing else.
 * Safe to re-run: accounts are matched by email and their password and roles are reset.
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['Information Technology', 'IT'], ['Accounts', 'ACC'], ['Sales', 'SAL'],
            ['HR', 'HR'], ['Marketing', 'MKT'], ['Administration', 'ADM'],
        ] as [$name, $code]) {
            Department::firstOrCreate(['code' => $code], ['name' => $name]);
        }
        foreach (['Officer', 'Executive', 'Manager', 'Assistant'] as $name) {
            Designation::firstOrCreate(['name' => $name]);
        }
        $location = Location::firstOrCreate(['name' => 'Head Office']);

        // name, email, password, role slug, department code, department head?
        $accounts = [
            ['Accounts User',        'acct_user@joplc.com',     '123456',   'dept_user',  'ACC', false],
            ['Sales User',           'sales_user@joplc.com',    '123456',   'dept_user',  'SAL', false],
            ['Accounts Head',        'acct_head@joplc.com',     '123456',   'dept_head',  'ACC', true],
            ['IT Admin',             'it_admin@joplc.com',      '123456',   'it_officer', 'IT',  false],
            ['IT Employee',          'it_emp@joplc.com',        '123456',   'it_member',  'IT',  false],
            ['Management User',      'sharif99452@gmail.com',   '123456',   'management', null,  false],
            ['System Administrator', 'nayem.jocl@gmail.com',    '12345678', 'admin',      'IT',  false],
        ];

        foreach ($accounts as [$name, $email, $password, $roleSlug, $deptCode, $head]) {
            $user = User::updateOrCreate(['email' => $email], [
                'name' => $name,
                'password' => $password,
                'department_id' => $deptCode ? Department::where('code', $deptCode)->value('id') : null,
                'location_id' => $location->id,
                'is_department_head' => $head,
                'is_active' => true,
                'failed_logins' => 0,
                'locked_until' => null,
            ]);
            $user->roles()->sync([Role::where('slug', $roleSlug)->value('id')]);
        }
    }
}
