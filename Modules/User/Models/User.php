<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\User\Database\Factories\UserFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use  Modules\Term\Models\Term;
use Modules\Course\Models\Course;

class User extends Authenticatable {
    use HasFactory, HasRoles;

    /**
     * The table associated with the model.
     *
     * @var string|null
     */
    protected $table = 'users';

    /**
     * Guard name
     *
     * @var string
     */
    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['first_name', 'last_name', 'degree', 'gender', 'birth_date', 'country', 'bio', 'email', 'password'];
    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];
    /**
     * The attributes that should be cast to native types.
     */
    protected function casts(): array {
        return [
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }
    public function terms() {
        return $this->belongsToMany(
            Term::class,

            'term_student',
            'student_id',
            'term_id'
        )
            ->withPivot('score')
            ->withTimestamps();
    }
    /**
     * The courses that belong to the user.
     *
     * @return void
     */
    public function courses() {
        return $this->belongsToMany(
            Course::class,
            'course_student',
            'student_id',
            'course_id'
        )->withPivot(['final_score', 'is_approved', 'approved_at', 'created_at', 'updated_at']);
    }
    /**
     * Accessor for full name
     */
    public function getFullNameAttribute(): string {
        return trim("{$this->degree} {$this->first_name} {$this->last_name}");
    }

    public function getInitialsAttribute(): string {
        $firstInitial = $this->first_name ? mb_substr($this->first_name, 0, 1) : '';
        $lastInitial  = $this->last_name ? mb_substr($this->last_name, 0, 1) : '';

        return strtoupper($firstInitial . $lastInitial);
    }
    /**
     * Function for getting highest role
     *
     * @return string|null
     */
    public function getHighestRoleAttribute(): ?string {
        $roleHierarchy = config('user.RolesPermissions.hierarchy');
        $userRoles = $this->getRoleNames();

        return collect($roleHierarchy)
            ->first(fn($role) => $userRoles->contains($role));
    }
}
