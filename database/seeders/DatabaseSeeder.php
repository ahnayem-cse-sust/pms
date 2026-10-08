<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ItsmLookupSeeder::class, // statuses, transitions, priorities, types, categories, settings
            RoleSeeder::class,       // the six roles and their permissions
            UserSeeder::class,       // departments + the seven accounts listed in README.md
        ]);
    }
}
