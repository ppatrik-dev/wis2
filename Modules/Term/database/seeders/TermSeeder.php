<?php
/**
 * @file TermSeeder.php
 * @author Patrik Procházka (xprochp00@vutbr.cz)
 * @brief Seeder for Term table
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

namespace Modules\Term\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Term\Models\Term;
use Modules\Term\Models\Room;

class TermSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $rooms = Room::all();

        $terms = [
            [
                'name' => 'Introduction',
                'course_id' => 1,
                'lecturer_id' => 2,
                'room_id' => $rooms->random()->id,
                'type' => 'lecture',
                'description' => 'Lecture for Introduction to Programming Systems.',
                'registration_required' => true,
                'max_score' => 100,
                'capacity' => 30,
                'start_at' => '2025-12-01 10:00:00',
                'end_at' => '2025-12-01 11:00:00',
            ],
            [
                'name' => 'Project WIS2',
                'course_id' => 2,
                'lecturer_id' => null,
                'room_id' => $rooms->random()->id,
                'type' => 'assignment',
                'description' => 'Project for Information Systems.',
                'registration_required' => true,
                'max_score' => 50,
                'capacity' => 25,
                'start_at' => '2025-12-02 14:00:00',
                'end_at' => '2025-12-02 15:00:00',
            ],
            [
                'name' => 'Homework (dialog)',
                'course_id' => 3,
                'lecturer_id' => 2,
                'room_id' => $rooms->random()->id,
                'type' => 'assignment',
                'description' => 'Assignment for Practical Conversation in English.',
                'registration_required' => false,
                'max_score' => 30,
                'capacity' => 20,
                'start_at' => '2025-12-03 09:00:00',
                'end_at' => '2025-12-03 10:00:00',
            ],
            [
                'name' => 'Network Lab',
                'course_id' => 4,
                'lecturer_id' => 2,
                'room_id' => $rooms->random()->id,
                'type' => 'exercise',
                'description' => 'Practical lab for Network Applications and Administration.',
                'registration_required' => true,
                'max_score' => 100,
                'capacity' => 40,
                'start_at' => '2025-12-04 11:00:00',
                'end_at' => '2025-12-04 12:00:00',
            ],
            [
                'name' => 'Main term',
                'course_id' => 4,
                'lecturer_id' => 2,
                'room_id' => $rooms->random()->id,
                'type' => 'exam',
                'description' => 'Exam for Network Applications and Administration.',
                'registration_required' => true,
                'max_score' => 100,
                'capacity' => 40,
                'start_at' => '2025-12-05 13:00:00',
                'end_at' => '2025-12-05 14:00:00',
            ],
        ];

        foreach ($terms as $term) {
            Term::updateOrCreate(
                ['name' => $term['name']],
                $term
            );
        }
    }
}
