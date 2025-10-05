<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\User\Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['first_name', 'last_name', 'sex', 'birth_date', 'country', 'bio', 'email', 'password'];
    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];
    // protected static function newFactory(): UserFactory
    // {
    //     // return UserFactory::new();
    // }
    public function getFullNameAttribute(): string {
        return "{$this->first_name} {$this->last_name}";
    }
    protected function casts(): array {
        return [
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }
}
