<?php

namespace Modules\Course\App\Services;

use Modules\Course\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseService
{

    public function getAll(): Collection
    {
        return Course::with(['guarantor', 'students', 'lecturers', 'news'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getById(int $id): Course
    {
        return Course::with(['guarantor', 'students', 'lecturers', 'news', 'terms'])
            ->findOrFail($id);
    }

    public function create(array $data): Course
    {
        return DB::transaction(function () use ($data) {
            // Handle checkbox values
            $data['auto_enroll_confirm'] = isset($data['auto_enroll_confirm']) ? (bool) $data['auto_enroll_confirm'] : false;
            $data['is_approved'] = isset($data['is_approved']) ? (bool) $data['is_approved'] : false;
            
            // Convert type to lowercase for database consistency
            if (isset($data['type'])) {
                $data['type'] = strtolower($data['type']);
            }
            
            return Course::create($data);
        });
    }

    public function update(int $id, array $data): Course
    {
        return DB::transaction(function () use ($id, $data) {
            // Handle checkbox values
            if (isset($data['auto_enroll_confirm'])) {
                $data['auto_enroll_confirm'] = (bool) $data['auto_enroll_confirm'];
            }
            if (isset($data['is_approved'])) {
                $data['is_approved'] = (bool) $data['is_approved'];
            }
            
            // Convert type to lowercase for database consistency
            if (isset($data['type'])) {
                $data['type'] = strtolower($data['type']);
            }
            
            $course = Course::findOrFail($id);
            $course->update($data);
            return $course->fresh(['guarantor', 'students', 'lecturers', 'news', 'terms']);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $course = Course::findOrFail($id);
            return $course->delete();
        });
    }


    //Search courses by name or code 
    public function search(string $query): Collection
    {
        return Course::with(['guarantor', 'students', 'lecturers'])
            ->where('name', 'like', "%{$query}%")
            ->orWhere('code', 'like', "%{$query}%")
            ->orderBy('name')
            ->get();
    }

    //Get courses by guarantor
    public function getByGuarantor(int $guarantorId): Collection
    {
        return Course::with(['guarantor', 'students', 'lecturers'])
            ->where('guarantor_id', $guarantorId)
            ->orderBy('created_at', 'desc')
            ->get();
    }


    //Get courses by academic year
    public function getByAcademicYear(string $academicYear): Collection
    {
        return Course::with(['guarantor', 'students', 'lecturers'])
            ->where('academic_year', $academicYear)
            ->orderBy('name')
            ->get();
    }


    // REMOVED: These methods are duplicated in CourseStudentService and CourseLecturerService
    // Use CourseStudentService::addStudent() and CourseLecturerService::addLecturer() instead

    //Approve course??? 
    public function approve(int $id): Course
    {
        return DB::transaction(function () use ($id) {
            $course = Course::findOrFail($id);
            $course->update(['is_approved' => true]);
            return $course;
        });
    }


    //Get approved courses
    public function getApproved(): Collection
    {
        return Course::with(['guarantor', 'students', 'lecturers'])
            ->where('is_approved', true)
            ->orderBy('name')
            ->get();
    }

    //Get paginated courses fot blade? 
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Course::with(['guarantor', 'students', 'lecturers'])->orderBy('created_at', 'desc')->paginate($perPage);
    }
}
