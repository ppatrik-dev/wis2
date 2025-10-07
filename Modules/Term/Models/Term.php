<?php

namespace Modules\Term\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Term\Database\Factories\TermFactory;

class Term extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = "terms";
    protected $fillable = ['lecturer_id', 'room_id', 'course_id', 'name', 'type', 'description', 'registration_required', 'max_score', 'capacity', 'event_datetime'];
    protected $casts = [
        'registration_required' => 'boolean',
        'deleted_at' => 'datetime',
        'event_datetime' => 'datetime',
    ];

    public function lecterer()
    {
        return $this->belongsTo(\Modules\User\Models\User::class, 'lecturer_id');
    }

    public function course()
    {
        return $this->belongsTo(\Modules\Course\Models\Course::class, 'course_id');
    }

    public function room()
    {
        return $this->belongsTo(\Modules\Term\Models\Room::class, 'room_id');
    }


    // To get score of students in this term
    public function termStudents()
    {
        return $this->hasMany(\Modules\Term\Models\TermStudent::class, 'term_id');
    }

    // To get all students registered for this term
    public function students()
    {
        return $this->hasManyThrough(
            \Modules\User\Models\User::class,
            \Modules\Term\Models\TermStudent::class,
            'term_id',
            'id',
            'id',
            'student_id'
        );
    }

    // protected static function newFactory(): TermFactory
    // {
    //     // return TermFactory::new();
    // }
}
