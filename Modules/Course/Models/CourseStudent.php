<?php
/**
 * @file CourseStudent.php
 * @author Nataliia Solomatina (xsolom02)
 * @brief Model for Course Student table
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

namespace Modules\Course\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Models\User;

class CourseStudent extends Pivot
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = "course_student";
    protected $fillable = ['course_id', 'student_id', 'final_score', 'is_approved'];
    protected $casts = ['is_approved' => 'boolean', 'approved_at' => 'datetime'];


    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // protected static function newFactory(): CourseStudentFactory
    // {
    //     // return CourseStudentFactory::new();
    // }
}
