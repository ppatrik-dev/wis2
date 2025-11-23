<?php
/**
 * @file CourseStudentDatabaseSeeder.php
 * @author Nataliia Solomatina (xsolom02)
 * @brief Seeder for Course Students pivot table
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

namespace Modules\Course\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Course\Models\Course;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CourseStudentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentEmails = [
            'defaultstudent@gmail.com',
            'anna.kovacova@student.example',
            'marek.novak@student.example',
            'lucia.horvathova@student.example',
            'peter.svec@student.example',
            'zuzana.mikova@student.example',
            'tomas.varga@student.example',
            'petra.kralova@student.example',
        ];

        $students = User::whereIn('email', $studentEmails)->get();

        if ($students->isEmpty()) {
            Log::warning('CourseStudentDatabaseSeeder: no matching students found for emails.', ['emails' => $studentEmails]);
            return;
        }

        $courses = [
            'IZP' => 'all',
            'IIS' => 'all',
            'PKA' => 'some',
        ];

        foreach ($courses as $code => $mode) {
            $course = Course::where('code', $code)->first();
            if (!$course) {
                Log::warning("CourseStudentDatabaseSeeder: course not found", ['code' => $code]);
                continue;
            }

            if ($mode === 'all') {
                $toEnroll = $students;
            } else {
                $pkaEmails = [
                    'zuzana.mikova@student.example',
                    'petra.kralova@student.example',
                ];
                $toEnroll = $students->filter(fn($s) => in_array($s->email, $pkaEmails, true))->values();
            }

            foreach ($toEnroll as $student) {
                $exists = $course->students()->where('student_id', $student->id)->exists();
                $pivotData = [
                    'final_score' => null,
                    'is_approved' => 1, // automatically approved
                    'approved_at' => Carbon::now(),
                ];

                if ($exists) {
                    $course->students()->updateExistingPivot($student->id, $pivotData);
                } else {
                    $course->students()->attach($student->id, $pivotData);
                }
            }

            Log::info('CourseStudentDatabaseSeeder: enrolled students', ['course' => $code, 'count' => count($toEnroll)]);
        }
    }
}
