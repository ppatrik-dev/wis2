<?php

namespace Modules\Term\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Term\Database\Factories\RoomFactory;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = "room";
    protected $fillable = ['name', 'location', 'capacity'];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function terms()
    {
        return $this->hasMany(\Modules\Term\Models\Term::class, 'room_id');
    }


    // protected static function newFactory(): RoomFactory
    // {
    //     // return RoomFactory::new();
    // }
}
