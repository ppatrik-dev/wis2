<?php

namespace Modules\User\database\seeders;

use Illuminate\database\Seeder;

class UserDatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
        ]);
    }
}
