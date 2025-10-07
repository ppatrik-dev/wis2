<?php

namespace Modules\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Course\Database\Factories\CourseNewsFactory;

class CourseNews extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

    protected $table = 'course_news';
    protected $fillable = ['course_id', 'author_id', 'title', 'description'];

    protected $casts = ['deleted_at' => 'datetime'];

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // protected static function newFactory(): CourseNewsFactory
    // {
    //     // return CourseNewsFactory::new();
    // }
}
