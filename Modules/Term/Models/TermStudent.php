<?php
/**
 * @file TermStudent.php
 * @author Patrik Procházka (xprochp00@vutbr.cz)
 * @brief Model for TermStudent table
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

namespace Modules\Term\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Term\Models\Term;
use Modules\User\Models\User;
// use Modules\Term\Database\Factories\TermStudentFactory;

class TermStudent extends Model {
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "term_student";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['term_id', 'student_id', 'score'];

    /**
     * The student that belongs to term student
     *
     * @return void
     */
    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * The term that belongs to term student
     *
     * @return void
     */
    public function term() {
        return $this->belongsTo(Term::class, 'term_id');
    }

    // protected static function newFactory(): TermStudentFactory
    // {
    //     // return TermStudentFactory::new();
    // }
}
