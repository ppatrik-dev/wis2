<?php
/**
 * @file RoomSeeder.php
 * @author Patrik Procházka (xprochp00@vutbr.cz)
 * @brief Seeder for Rooms table
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

namespace Modules\Term\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Term\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'Room A',
                'location' => 'Building 1',
                'capacity' => 30
            ],
            [
                'name' => 'Room B',
                'location' => 'Building 2',
                'capacity' => 50
            ],
            [
                'name' => 'Room C',
                'location' => 'Main Campus',
                'capacity' => 100
            ],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(
                ['name' => $room['name']],
                $room
            );
        }
    }
}
