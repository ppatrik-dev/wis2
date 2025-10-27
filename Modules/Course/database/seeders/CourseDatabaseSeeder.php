<?php

namespace Modules\Course\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\Course\Models\Course;

class CourseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $courses = [
            [
                'code' => 'IZP',
                'name' => 'Introduction to Programming Systems',
                'academic_year' => '2025/2026',
                'credits' => 7,
                'capacity' => 300,
                'type' => 'mandatory',
                'guarantor_id' => 2,
                'auto_enroll_confirm' => false,
                'is_approved' => true,
                'description' => null,
                'approved_at' => $now,
            ],
            [
                'code' => 'IIS',
                'name' => 'Information Systems',
                'academic_year' => '2025/2026',
                'credits' => 4,
                'capacity' => 200,
                'type' => 'mandatory',
                'guarantor_id' => null,
                'auto_enroll_confirm' => false,
                'is_approved' => true,
                'description' => null,
                'approved_at' => $now,
            ],
            [
                'code' => 'PKA',
                'name' => 'Practical Conversation, Presenting and Business Communication in English',
                'academic_year' => '2025/2026',
                'credits' => 3,
                'capacity' => 30,
                'type' => 'optional',
                'guarantor_id' => 2,
                'auto_enroll_confirm' => true,
                'is_approved' => true,
                'description' => null,
                'approved_at' => $now,
            ],
            [
                'code' => 'ISA',
                'name' => 'Network Applications and Network Administration',
                'academic_year' => '2025/2026',
                'credits' => 5,
                'capacity' => 100,
                'type' => 'mandatory',
                'guarantor_id' => 2,
                'auto_enroll_confirm' => false,
                'is_approved' => true,
                'description' => null,
                'approved_at' => $now,
            ],
        ];

        foreach ($courses as $course) {

            $payload = array_merge($course, [
                'created_at' => $now,
                'updated_at' => $now,
                'auto_enroll_confirm' => $course['auto_enroll_confirm'] ? 1 : 0,
                'is_approved' => $course['is_approved'] ? 1 : 0,
            ]);

            DB::table('courses')->updateOrInsert(
                ['code' => $course['code']],
                $payload
            );
        }
    }
}
