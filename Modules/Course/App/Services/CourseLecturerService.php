<?php

namespace Modules\Course\App\Services;

use Modules\Course\Models\CourseLecturer;
use Modules\Course\Models\Course;
use Modules\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseLecturerService
{
    /**
     * Get all lecturers for a course
     */
    public function getByCourse(int $courseId): Collection
    {
        $course = Course::findOrFail($courseId);
        return $course->lecturers()->withPivot(['role', 'created_at', 'updated_at'])->get();
    }

    /**
     * Get paginated lecturers for blade
     */
    public function getPaginatedByCourse(int $courseId, int $perPage = 15): LengthAwarePaginator
    {
        return CourseLecturer::with(['lecturer', 'course'])
            ->where('course_id', $courseId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get lecturer by ID
     */
    public function getById(int $id): CourseLecturer
    {
        return CourseLecturer::with(['lecturer', 'course'])->findOrFail($id);
    }

    /**
     * Get lecturer by course ID and lecturer ID
     */
    public function getByCourseAndLecturer(int $courseId, int $lecturerId): CourseLecturer
    {
        $course = Course::findOrFail($courseId);
        $lecturer = $course->lecturers()->where('lecturer_id', $lecturerId)->first();
        
        if (!$lecturer) {
            throw new \Exception('Lecturer not found in this course.');
        }
        
        // Load the lecturer data and return the pivot with lecturer relationship
        $pivot = $lecturer->pivot;
        $pivot->lecturer = $lecturer;
        $pivot->course = $course;
        
        return $pivot;
    }

    /**
     * Add lecturer to course
     */
    public function addLecturer(int $courseId, int $lecturerId, string $role = 'lecturer'): CourseLecturer
    {
        return DB::transaction(function () use ($courseId, $lecturerId, $role) {
            $course = Course::findOrFail($courseId);
            $user = User::findOrFail($lecturerId);
            
            // Check if lecturer is already assigned to this course
            $existing = $course->lecturers()->where('lecturer_id', $lecturerId)->first();

            if ($existing) {
                throw new \Exception('Lecturer is already assigned to this course.');
            }

            // Use the relationship to attach the lecturer with automatic role
            $course->lecturers()->attach($lecturerId, [
                'role' => 'lecturer', // Always lecturer
            ]);

            // Return the pivot model
            return $course->lecturers()->where('lecturer_id', $lecturerId)->first()->pivot;
        });
    }

    /**
     * Update lecturer role
     */
    public function updateRole(int $courseId, int $lecturerId, string $role): CourseLecturer
    {
        return DB::transaction(function () use ($courseId, $lecturerId, $role) {
            $course = Course::findOrFail($courseId);
            $lecturer = $course->lecturers()->where('lecturer_id', $lecturerId)->first();
            
            if (!$lecturer) {
                throw new \Exception('Lecturer not found in this course.');
            }
            
            // Update pivot data
            $course->lecturers()->updateExistingPivot($lecturerId, ['role' => $role]);
            
            // Return updated pivot
            return $course->lecturers()->where('lecturer_id', $lecturerId)->first()->pivot;
        });
    }

    /**
     * Remove lecturer from course
     */
    public function removeLecturer(int $courseId, int $lecturerId): bool
    {
        return DB::transaction(function () use ($courseId, $lecturerId) {
            return CourseLecturer::where('course_id', $courseId)
                ->where('lecturer_id', $lecturerId)
                ->delete() > 0;
        });
    }

    /**
     * Remove lecturer by ID
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $courseLecturer = CourseLecturer::findOrFail($id);
            return $courseLecturer->delete();
        });
    }

    /**
     * Get courses by lecturer
     */
    public function getCoursesByLecturer(int $lecturerId): Collection
    {
        return CourseLecturer::with(['course', 'course.guarantor'])
            ->where('lecturer_id', $lecturerId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * See if user is a lecturer for a course
     */
    public function getLecturerRole(int $courseId, int $userId): ?string
    {
        $courseLecturer = CourseLecturer::where('course_id', $courseId)
            ->where('lecturer_id', $userId)
            ->first();

        return $courseLecturer ? $courseLecturer->role : null;
    }
}