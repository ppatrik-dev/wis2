<?php

namespace Modules\Course\App\Services;

use Modules\Course\Models\CourseStudent;
use Modules\Course\Models\Course;
use Modules\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseStudentService {
    /**
     * Get all students for a specific course
     */
    public function getByCourse(int $courseId): Collection {
        $course = Course::withTrashed()->findOrFail($courseId);
        return $course->students()->withPivot(['final_score', 'is_approved', 'approved_at', 'created_at', 'updated_at'])->get();
    }

    /**
     * Get paginated students for a course
     */
    public function getPaginatedByCourse(int $courseId, int $perPage = 15): LengthAwarePaginator {
        return CourseStudent::with(['student', 'course'])
            ->where('course_id', $courseId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get student by ID
     */
    public function getById(int $courseId, int $studentId): CourseStudent {
        $course = Course::withTrashed()->findOrFail($courseId);
        $student = $course->students()->where('student_id', $studentId)->first();

        if (!$student) {
            throw new \Exception('Student not found in this course.');
        }

        $pivot = $student->pivot;
        $pivot->student = $student;
        $pivot->course = $course;

        return $pivot;
    }

    /**
     * Add student to course
     */
    public function addStudent(int $courseId, int $studentId, array $data = []): CourseStudent {
        return DB::transaction(function () use ($courseId, $studentId, $data) {
            $course = Course::withTrashed()->findOrFail($courseId);

            $existing = $course->students()->where('student_id', $studentId)->first();

            if ($existing) {
                throw new \Exception('Student is already enrolled in this course.');
            }

            $course->students()->attach($studentId, [
                'final_score' => $data['final_score'] ?? null,
                'is_approved' => $data['is_approved'] ?? false,
            ]);

            // Return the pivot model
            return $course->students()->where('student_id', $studentId)->first()->pivot;
        });
    }

    /**
     * Update student enrollment
     */
    public function update(int $courseId, int $studentId, array $data): CourseStudent {
        return DB::transaction(function () use ($courseId, $studentId, $data) {
            $course = Course::withTrashed()->findOrFail($courseId);
            $student = $course->students()->where('student_id', $studentId)->first();

            if (!$student) {
                throw new \Exception('Student not found in this course.');
            }

            // Filter out null values so we don't try to write NULL into non-nullable columns
            $updateData = array_filter($data, function ($v) {
                return !is_null($v);
            });

            if (!empty($updateData)) {
                // Update pivot data
                $course->students()->updateExistingPivot($studentId, $updateData);
            }

            // Return updated pivot
            return $course->students()->where('student_id', $studentId)->first()->pivot;
        });
    }

    /**
     * Remove student from course
     */
    public function removeStudent(int $courseId, int $studentId): bool {
        return DB::transaction(function () use ($courseId, $studentId) {
            return CourseStudent::where('course_id', $courseId)
                ->where('student_id', $studentId)
                ->delete() > 0;
        });
    }

    /**
     * Remove student by ID
     */
    /*
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $courseStudent = CourseStudent::findOrFail($id);
            return $courseStudent->delete();
        });
    }
    */
    /**
     * Get courses by student
     */
    public function getCoursesByStudent(int $studentId): Collection {
        return CourseStudent::with(['course', 'course.guarantor'])
            ->where('student_id', $studentId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get approved students for a course
     */
    public function getApprovedByCourse(int $courseId): Collection {
        return CourseStudent::with(['student'])
            ->where('course_id', $courseId)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get pending students for a course
     */
    public function getPendingByCourse(int $courseId): Collection {
        return CourseStudent::with(['student'])
            ->where('course_id', $courseId)
            ->where('is_approved', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Approve student enrollment
     */
    public function approve(int $id): CourseStudent {
        return DB::transaction(function () use ($id) {
            $courseStudent = CourseStudent::findOrFail($id);
            $courseStudent->update([
                'is_approved' => true,
                'approved_at' => now(),
            ]);
            return $courseStudent->fresh(['student', 'course']);
        });
    }

    /**
     * Reject student enrollment
     */
    public function reject(int $id): CourseStudent {
        return DB::transaction(function () use ($id) {
            $courseStudent = CourseStudent::findOrFail($id);
            $courseStudent->update([
                'is_approved' => false,
                'approved_at' => null,
            ]);
            return $courseStudent->fresh(['student', 'course']);
        });
    }

    /**
     * Update student final score
     */
    /*
    public function updateScore(int $id, float $score): CourseStudent
    {
        return DB::transaction(function () use ($id, $score) {
            $courseStudent = CourseStudent::findOrFail($id);
            $courseStudent->update(['final_score' => $score]);
            return $courseStudent->fresh(['student', 'course']);
        });
    }
        */

    /**
     * Update student final score by course and student id (when pivot id isn't available)
     */
    public function updateScoreByCourseAndStudent(int $courseId, int $studentId, float $score): CourseStudent {
        return DB::transaction(function () use ($courseId, $studentId, $score) {
            $courseStudent = CourseStudent::where('course_id', $courseId)
                ->where('student_id', $studentId)
                ->first();

            if (!$courseStudent) {
                throw new \Exception('Enrollment not found for the given course and student.');
            }

            $courseStudent->update(['final_score' => $score]);

            return $courseStudent->fresh(['student', 'course']);
        });
    }

    /**
     * Check if student is enrolled in course
     */
    public function isEnrolled(int $courseId, int $studentId): bool {
        return CourseStudent::where('course_id', $courseId)
            ->where('student_id', $studentId)
            ->exists();
    }

    /**
     * Get student enrollment status
     */
    public function getEnrollmentStatus(int $courseId, int $studentId): ?CourseStudent {
        return CourseStudent::where('course_id', $courseId)
            ->where('student_id', $studentId)
            ->first();
    }

    /**
     * Get students with scores
     */
    public function getStudentsWithScores(int $courseId): Collection {
        return CourseStudent::with(['student'])
            ->where('course_id', $courseId)
            ->whereNotNull('final_score')
            ->orderBy('final_score', 'desc')
            ->get();
    }

    /**
     * Bulk approve students
     */
    public function bulkApprove(array $studentIds): int {
        return DB::transaction(function () use ($studentIds) {
            return CourseStudent::whereIn('id', $studentIds)
                ->update([
                    'is_approved' => true,
                    'approved_at' => now(),
                ]);
        });
    }

    /**
     * Bulk reject students
     */
    public function bulkReject(array $studentIds): int {
        return DB::transaction(function () use ($studentIds) {
            return CourseStudent::whereIn('id', $studentIds)
                ->update([
                    'is_approved' => false,
                    'approved_at' => null,
                ]);
        });
    }
}
