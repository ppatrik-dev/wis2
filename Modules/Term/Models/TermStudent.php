<?php

namespace Modules\Term\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Term\Database\Factories\TermStudentFactory;

class TermStudent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = "term_student";
    protected $fillable = ['term_id', 'student_id', 'score'];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(\Modules\User\Models\User::class, 'student_id');
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
