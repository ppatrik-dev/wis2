<?php

namespace Modules\User\database\seeders;
//
//   @file UserDatabaseSeeder.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Seeder to run all database seeders for the User module
//   @version 0.1
//   @date 2025-11-22
//
//   @copyright Copyright (c) 2025
//
use Illuminate\Database\Seeder;

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
