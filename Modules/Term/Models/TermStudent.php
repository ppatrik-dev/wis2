<?php

namespace Modules\Term\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Term\Models\Term;
use Modules\User\Models\User;
// use Modules\Term\Database\Factories\TermStudentFactory;

class TermStudent extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = "term_student";
    protected $fillable = ['term_id', 'student_id', 'score'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    // protected static function newFactory(): TermStudentFactory
    // {
    //     // return TermStudentFactory::new();
    // }
}
