<?php
/**
 * @file Term.php
 * @author Patrik Procházka (xprochp00@vutbr.cz)
 * @brief Model for Term table
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

namespace Modules\Term\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Models\User;
use Modules\Term\Models\Room;
use Modules\Term\Models\TermStudent;
use Modules\Course\Models\Course;
// use Modules\Term\Database\Factories\TermFactory;

class Term extends Model {
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "terms";

    /**
     * The attributes that are mass assignable.
     */
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

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'registration_required' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    /**
     * The lecturer that belong to the term.
     *
     * @return void
     */
    public function lecturer() {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    /**
     * The course that belong to the term.
     *
     * @return void
     */
    public function course() {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * The room that belong to the term.
     *
     * @return void
     */
    public function room() {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * Score of students in this term.
     *
     * @return void
     */
    public function termStudents() {
        return $this->hasMany(TermStudent::class, 'term_id');
    }

    /**
     * All students registered for this term.
     *
     * @return void
     */
    public function students() {
        return $this->belongsToMany(
            User::class,
            'term_student',
            'term_id',
            'student_id'
        )->withPivot('score');
    }

    /**
     * Course students.
     *
     * @return array
     */
    public function getCourseStudentsAttribute(): array {
        $students = $this->course->students ?? collect();

        return $students->mapWithKeys(
            fn($student) => [$student->id => $student->getFullNameAttribute()]
        )->toArray();
    }

    /**
     * Term students.
     *
     * @return void
     */
    public function getTermStudentsAttribute() {
        return $this->termStudents()->with('student')->get();
    }

    /**
     * Term student by id.
     *
     * @param [type] $studentId
     * @return void
     */
    public function termStudentBy($studentId) {
        return $this->termStudents()
            ->where('student_id', $studentId)
            ->first();
    }

    /**
     * Term day attribute.
     *
     * @return void
     */
    public function getDayAttribute() {
        return $this->start_at->format('l');
    }

    /**
     * Term duration in minutes.
     *
     * @return void
     */
    public function getDurationInMinutes() {
        return $this->start_at->diffInMinutes($this->end_at);
    }

    /**
     * Term overlapping start and end.
     *
     * @param [type] $otherTerm
     * @return boolean
     */
    public function isOverlapping($otherTerm): bool {
        return $this->start_at < $otherTerm->end_at &&
            $this->end_at > $otherTerm->start_at;
    }

    /**
     * Term model boot method checks for term registration required value.
     *
     * @return void
     */
    protected static function booted() {

        static::created(function (Term $term) {
            if ($term->registration_required == false) {
                $students = $term->course->students;
                
                foreach ($students as $student) {
                    TermStudent::firstOrCreate([
                        'term_id'    => $term->id,
                        'student_id' => $student->id,
                        'score'      => null,
                    ]);
                }
            }
        });

        static::updated(function (Term $term) {
            if ($term->wasChanged('registration_required')) {
                if ($term->registration_required == false) {
                    $students = $term->course->students;

                    foreach ($students as $student) {
                        TermStudent::firstOrCreate([
                            'term_id'    => $term->id,
                            'student_id' => $student->id,
                            'score'      => null,
                        ]);
                    }
                }
            }
        });
    }
}
