<?php

/**
 * @file CourseStudentService.php
 * @author Nataliia Solomatina (xsolom02), Miroslav Basista (xbasim00)
 * @brief Service for managing course students
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

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
        $course = Course::findOrFail($courseId);
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
        $course = Course::findOrFail($courseId);
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
     * Get current approved enrollment count for a course
     */
    public function getApprovedEnrollmentCount(int $courseId): int {
        return CourseStudent::where('course_id', $courseId)
            ->where('is_approved', true)
            ->count();
    }

    /**
     * Check if course has available capacity
     */
    public function hasAvailableCapacity(int $courseId): bool {
        $course = Course::findOrFail($courseId);

        if (!$course->capacity || $course->capacity <= 0) {
            return true;
        }

        $approvedCount = $this->getApprovedEnrollmentCount($courseId);
        return $approvedCount < $course->capacity;
    }

    /**
     * Add student to course with automatic approval if capacity allows
     */
    public function addStudent(int $courseId, int $studentId, array $data = []): CourseStudent {
        return DB::transaction(function () use ($courseId, $studentId, $data) {
            $course = Course::findOrFail($courseId);

            $existing = $course->students()->where('student_id', $studentId)->first();

            if ($existing) {
                throw new \Exception('Student is already enrolled in this course.');
            }

            // Determine if student should be automatically approved
            $shouldAutoApprove = false;

            if (isset($data['is_approved'])) {
                $shouldAutoApprove = (bool) $data['is_approved'];
            } else {
                if ($course->auto_enroll_confirm && $this->hasAvailableCapacity($courseId)) {
                    $shouldAutoApprove = true;
                }
            }

            $course->students()->attach($studentId, [
                'final_score' => $data['final_score'] ?? null,
                'is_approved' => $shouldAutoApprove,
                'approved_at' => $shouldAutoApprove ? now() : null,
            ]);
            if ($shouldAutoApprove) {
                $student = User::findOrFail($studentId);

                if (!$student->hasRole('student')) {
                    $student->assignRole('student');
                }
            }
            return $course->students()->where('student_id', $studentId)->first()->pivot;
        });
    }

    /**
     * Update student enrollment
     */
    public function update(int $courseId, int $studentId, array $data): CourseStudent {
        return DB::transaction(function () use ($courseId, $studentId, $data) {
            $course = Course::findOrFail($courseId);
            $student = $course->students()->where('student_id', $studentId)->first();

            if (!$student) {
                throw new \Exception('Student not found in this course.');
            }

            $updateData = array_filter($data, function ($v) {
                return !is_null($v);
            });

            if (!empty($updateData)) {
                $course->students()->updateExistingPivot($studentId, $updateData);
            }
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
            $pivots = CourseStudent::whereIn('id', $studentIds)->get();

            foreach ($pivots as $pivot) {
                $student = User::find($pivot->student_id);

                if ($student && !$student->hasRole('student')) {
                    $student->assignRole('student');
                }
            }
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
