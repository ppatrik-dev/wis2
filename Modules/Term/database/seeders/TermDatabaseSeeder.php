<?php
/**
 * @file TermDatabaseSeeder.php
 * @author Patrik Procházka (xprochp00@vutbr.cz)
 * @brief Seeder for Term module
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

namespace Modules\Term\database\seeders;

use Illuminate\Database\Seeder;

class TermDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            RoomSeeder::class,
            TermSeeder::class,
        ]);
    }
}
