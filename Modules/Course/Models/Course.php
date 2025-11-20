<?php

namespace Modules\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Models\User;
use Modules\Term\Models\Term;
use Modules\Course\Models\CourseNews;
use Modules\Course\Models\CourseStudent;
use Modules\Course\Models\CourseLecturer;

/**
 * Modules\Course\Models\Course
 *
 * @property int $id
 * @property int|null $guarantor_id
 * @property string $code
 * @property string $name
 * @property string|null $academic_year
 * @property string|null $description
 * @property string|null $type
 * @property int|null $credits
 * @property int|null $capacity
 * @property bool|null $auto_enroll_confirm
 * @property bool|null $is_approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @mixin \Eloquent
 */
class Course extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'courses';
    protected $fillable = ['guarantor_id', 'code', 'name', 'academic_year', 'description', 'type', 'credits', 'capacity', 'auto_enroll_confirm', 'is_approved'];

    protected $casts = [
        'auto_enroll_confirm' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function guarantor() {
        return $this->belongsTo(User::class, 'guarantor_id');
    }

    public function news() {
        return $this->hasMany(CourseNews::class);
    }

    public function students() {
        return $this->belongsToMany(User::class, 'course_student', 'course_id', 'student_id')
            ->using(CourseStudent::class)
            ->withPivot(['final_score', 'is_approved', 'approved_at', 'created_at', 'updated_at']);
    }


    public function lecturers() {
        return $this->belongsToMany(User::class, 'course_lecturer', 'course_id', 'lecturer_id')
            ->using(CourseLecturer::class)
            ->withPivot(['role', 'created_at', 'updated_at']);
    }

    public function terms() {
        return $this->hasMany(Term::class);
    }

    /**
     * Get the number of approved students enrolled
     */
    public function getApprovedEnrollmentCount(): int {
        return $this->students()->wherePivot('is_approved', true)->count();
    }

    /**
     * Get remaining capacity
     */
    public function getRemainingCapacity(): ?int {
        if (!$this->capacity || $this->capacity <= 0) {
            return null; // No limit
        }

        $approved = $this->getApprovedEnrollmentCount();
        return max(0, $this->capacity - $approved);
    }

    /**
     * Check if course is full
     */
    public function isFull(): bool {
        if (!$this->capacity || $this->capacity <= 0) {
            return false; // No limit, never full
        }

        return $this->getApprovedEnrollmentCount() >= $this->capacity;
    }
    /**
     *  Check if a student is approved in this course
     *
     * @param User $user
     * @return boolean
     */
    public function isStudentApproved(User $user): bool {
        return $this->students()
            ->where('student_id', $user->id)
            ->wherePivot('is_approved', true)
            ->exists();
    }


    // protected static function newFactory(): CourseFactory
    // {
    //     // return CourseFactory::new();
    // }
}
