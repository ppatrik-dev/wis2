<?php

namespace Modules\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Course\Database\Factories\CourseFactory;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'courses';
    protected $fillable = ['guarantor_id', 'code', 'name', 'academic_year', 'description', 'type', 'credits', 'capacity', 'auto_enroll_confirm', 'is_approved'];

    protected $casts = [
        'auto_enroll_confirm' => 'boolean',
        'is_approved' => 'boolean',
        'deleted_at' => 'datetime'
    ];

    public function guarantor()
    {
        return $this->belongsTo(\Modules\User\Models\User::class, 'guarantor_id');
    }

    public function news()
    {
        return $this->hasMany(\Modules\Course\Models\CourseNews::class);
    }

    public function students()
    {
        return $this->belongsToMany(\Modules\User\Models\User::class, 'course_student', 'course_id', 'student_id')
            ->using(\Modules\Course\Models\CourseStudent::class)
            ->withPivot(['final_score', 'is_approved', 'approved_at']);
    }


    public function lecturers()
    {
        return $this->belongsToMany(\Modules\User\Models\User::class, 'course_lecturer', 'course_id', 'lecturer_id')
            ->using(\Modules\Course\Models\CourseLecturer::class)
            ->withPivot('role');
    }

    public function terms()
    {
        return $this->hasMany(\Modules\Term\Models\Term::class);
    }

    // protected static function newFactory(): CourseFactory
    // {
    //     // return CourseFactory::new();
    // }
}
