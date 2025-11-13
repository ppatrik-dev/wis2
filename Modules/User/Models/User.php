<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\User\Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia; // Add this import if using Spatie Media Library
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use  Modules\Term\Models\Term;

class User extends Authenticatable implements HasMedia {
    use HasFactory, SoftDeletes, InteractsWithMedia, HasRoles;

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
     * Defining media collection for user's avatar
     */
    public function registerMediaCollections(): void {
        $this->addMediaCollection('avatar')
            ->useDisk('public')
            ->usePath('avatars/' . $this->id)
            ->singleFile();
    }
    /**
     * Function for getting highest role
     *
     * @return string|null
     */
    public function getHighestRole(): ?string {
        $roleHierarchy = config('user.RolesPermissions.hierarchy');
        $userRoles = $this->getRoleNames();

        return collect($roleHierarchy)
            ->first(fn($role) => $userRoles->contains($role));
    }
}
