<?php

namespace Modules\Term\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Models\User;
use Modules\Term\Models\Room;
use Modules\Term\Models\TermStudent;
use Modules\Course\Models\Course;
// use Modules\Term\Database\Factories\TermFactory;

class Term extends Model {
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = "terms";
    protected $fillable = [
        'lecturer_id',
        'room_id',
        'course_id',
        'name',
        'type',
        'description',
        'registration_required',
        'max_score',
        'capacity',
        'start_at',
        'end_at'
    ];
    protected $casts = [
        'registration_required' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function lecturer() {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function course() {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function room() {
        return $this->belongsTo(Room::class, 'room_id');
    }


    // To get score of students in this term
    public function termStudents() {
        return $this->hasMany(TermStudent::class, 'term_id');
    }

    // To get all students registered for this term
    public function students() {
        return $this->hasManyThrough(
            User::class,
            TermStudent::class,
            'term_id',
            'id',
            'id',
            'student_id'
        );
    }
    public function getDayAttribute() {
        return $this->start_at->format('l');
    }

    public function getDurationInMinutes() {
        return $this->start_at->diffInMinutes($this->end_at);
    }

    public function isOverlapping($otherTerm): bool {
        return $this->start_at < $otherTerm->end_at &&
            $this->end_at > $otherTerm->start_at;
    }
}
