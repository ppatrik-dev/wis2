<?php

namespace Modules\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Models\User;
use Modules\Term\Models\Term;
use Modules\Course\Models\CourseNews;
use Modules\Course\Models\CourseStudent;
use Modules\Course\Models\CourseLecturer;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'courses';
    protected $fillable = ['guarantor_id', 'code', 'name', 'academic_year', 'description', 'type', 'credits', 'capacity', 'auto_enroll_confirm', 'is_approved'];

    protected $casts = [
        'auto_enroll_confirm' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function guarantor()
    {
        return $this->belongsTo(User::class, 'guarantor_id');
    }

    public function news()
    {
        return $this->hasMany(CourseNews::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student', 'course_id', 'student_id')
            ->using(CourseStudent::class)
            ->withPivot(['final_score', 'is_approved', 'approved_at', 'created_at', 'updated_at']);
    }


    public function lecturers()
    {
        return $this->belongsToMany(User::class, 'course_lecturer', 'course_id', 'lecturer_id')
            ->using(CourseLecturer::class)
            ->withPivot(['role', 'created_at', 'updated_at']);
    }

    public function terms()
    {
        return $this->hasMany(Term::class);
    }

    // protected static function newFactory(): CourseFactory
    // {
    //     // return CourseFactory::new();
    // }
}
