<?php
/**
 * @file CourseService.php
 * @author Nataliia Solomatina (xsolom02)
 * @brief Service for managing courses
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

namespace Modules\Course\App\Services;

use Modules\Course\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseService
{
    /**
     * All courses
     * @return Collection<int, Course>
     */
    public function getAll(): Collection
    {
        return Course::with(['guarantor', 'students', 'lecturers', 'news'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get course by its id
     * @param int $id
     * @return Course
     */
    public function getById(int $id): Course
    {
        return Course::with(['guarantor', 'students', 'lecturers', 'news', 'terms'])
            ->findOrFail($id);
    }

    /**
     * Create a new course
     * @param array $data
     * @return Course
     */
    public function create(array $data): Course
    {
        return DB::transaction(function () use ($data) {
            $data['auto_enroll_confirm'] = isset($data['auto_enroll_confirm']) ? (bool) $data['auto_enroll_confirm'] : false;
            $data['is_approved'] = isset($data['is_approved']) ? (bool) $data['is_approved'] : false;
            if (isset($data['type'])) {
                $data['type'] = strtolower($data['type']);
            }

            return Course::create($data);
        });
    }

    /**
     * Update an existing course
     * @param int $id
     * @param array $data
     * @return Course
     */
    public function update(int $id, array $data): Course
    {
        return DB::transaction(function () use ($id, $data) {
            if (isset($data['auto_enroll_confirm'])) {
                $data['auto_enroll_confirm'] = (bool) $data['auto_enroll_confirm'];
            }
            if (isset($data['is_approved'])) {
                $data['is_approved'] = (bool) $data['is_approved'];
            }

            if (isset($data['type'])) {
                $data['type'] = strtolower($data['type']);
            }

            $course = Course::findOrFail($id);
            $course->update($data);
            return $course->fresh(['guarantor', 'students', 'lecturers', 'news', 'terms']);
        });
    }

    /**
     * Delete a course
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $course = Course::findOrFail($id);
            return $course->delete();
        });
    }

    /**
     * Search courses by name or code
     */
    public function search(string $query): Collection
    {
        return Course::with(['guarantor', 'students', 'lecturers'])
            ->where('name', 'like', "%{$query}%")
            ->orWhere('code', 'like', "%{$query}%")
            ->orderBy('name')
            ->get();
    }

    /**
     * Get course by guarantor
     * @param int $guarantorId
     * @return Collection<int, Course>
     */
    public function getByGuarantor(int $guarantorId): Collection
    {
        return Course::with(['guarantor', 'students', 'lecturers'])
            ->where('guarantor_id', $guarantorId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get course by academic year
     * @param string $academicYear
     * @return Collection<int, Course>
     */
    public function getByAcademicYear(string $academicYear): Collection
    {
        return Course::with(['guarantor', 'students', 'lecturers'])
            ->where('academic_year', $academicYear)
            ->orderBy('name')
            ->get();
    }

    /**
     * Approve a course
     * @param int $id
     * @return Course
     */
    public function approve(int $id): Course
    {
        return DB::transaction(function () use ($id) {
            $course = Course::findOrFail($id);
            $course->update(['is_approved' => true]);
            return $course;
        });
    }

    /**
     * Get approved courses
     * @return Collection<int, Course>
     */
    public function getApproved(): Collection
    {
        return Course::with(['guarantor', 'students', 'lecturers'])
            ->where('is_approved', true)
            ->orderBy('name')
            ->get();
    }

    /**
     * Get paginated list of courses
     * @param int $perPage
     * @return LengthAwarePaginator<int, Course>
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Course::with(['guarantor', 'students', 'lecturers'])->orderBy('created_at', 'desc')->paginate($perPage);
    }
}
