<?php

namespace Modules\Term\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Term\Models\Term;
// use Modules\Term\Database\Factories\RoomFactory;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = "room";
    protected $fillable = ['name', 'location', 'capacity'];


    public function terms()
    {
        return $this->hasMany(Term::class, 'room_id');
    }


    // protected static function newFactory(): RoomFactory
    // {
    //     // return RoomFactory::new();
    // }
}
