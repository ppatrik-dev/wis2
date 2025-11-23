<?php
/**
 * @file CourseLecturer.php
 * @author Nataliia Solomatina (xsolom02)
 * @brief Model for Course Lecturer table
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

namespace Modules\Course\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Models\User;

class CourseLecturer extends Pivot
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = "course_lecturer";
    protected $fillable = ['course_id', 'lecturer_id', 'role'];


    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    // protected static function newFactory(): CourseLecturerFactory
    // {
    //     // return CourseLecturerFactory::new();
    // }
}
