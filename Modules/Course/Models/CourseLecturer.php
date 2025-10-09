<?php

namespace Modules\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Course\Database\Factories\CourseLecturerFactory;
use Modules\User\Models\User;

class CourseLecturer extends Model
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
