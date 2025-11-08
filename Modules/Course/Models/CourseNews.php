<?php

namespace Modules\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Models\User;

class CourseNews extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

    protected $table = 'course_news';
    protected $fillable = ['course_id', 'author_id', 'title', 'description'];

    /**
     * The course this news belongs to
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * The author (user) who created this news item
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // protected static function newFactory(): CourseNewsFactory
    // {
    //     // return CourseNewsFactory::new();
    // }
}
