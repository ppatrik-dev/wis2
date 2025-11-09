<?php

namespace Modules\Term\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Term\Models\Term;
use Modules\Term\Models\Room;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = Room::all();

        $terms = [
            [
                'name' => 'Intro to Programming Systems - Lecture',
                'course_id' => 1,
                'lecturer_id' => 2,
                'room_id' => $rooms->random()->id,
                'type' => 'lecture',
                'description' => 'Lecture for Introduction to Programming Systems.',
                'registration_required' => true,
                'max_score' => 100,
                'capacity' => 30,
                'event_datetime' => '2025-12-01 10:00:00',
            ],
            [
                'name' => 'Information Systems - Exercise',
                'course_id' => 2,
                'lecturer_id' => null,
                'room_id' => $rooms->random()->id,
                'type' => 'exercise',
                'description' => 'Exercise session for Information Systems.',
                'registration_required' => true,
                'max_score' => 50,
                'capacity' => 25,
                'event_datetime' => '2025-12-02 14:00:00',
            ],
            [
                'name' => 'Practical Conversation - Assignment',
                'course_id' => 3,
                'lecturer_id' => 2,
                'room_id' => $rooms->random()->id,
                'type' => 'assignment',
                'description' => 'Assignment for Practical Conversation in English.',
                'registration_required' => false,
                'max_score' => 30,
                'capacity' => 20,
                'event_datetime' => '2025-12-03 09:00:00',
            ],
            [
                'name' => 'Network Applications - Lecture',
                'course_id' => 4,
                'lecturer_id' => 2,
                'room_id' => $rooms->random()->id,
                'type' => 'lecture',
                'description' => 'Lecture for Network Applications and Administration.',
                'registration_required' => true,
                'max_score' => 100,
                'capacity' => 40,
                'event_datetime' => '2025-12-04 11:00:00',
            ],
            [
                'name' => 'Network Applications - Exam',
                'course_id' => 4,
                'lecturer_id' => 2,
                'room_id' => $rooms->random()->id,
                'type' => 'exam',
                'description' => 'Exam for Network Applications and Administration.',
                'registration_required' => true,
                'max_score' => 100,
                'capacity' => 40,
                'event_datetime' => '2025-12-05 13:00:00',
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