<?php
/**
 * @file Room.php
 * @author Patrik Procházka (xprochp00@vutbr.cz)
 * @brief Model for Room table
 * @version 0.1
 * @date 2025-11-22
 * @copyright Copyright (c) 2025
 */

namespace Modules\Term\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Term\Models\Term;
// use Modules\Term\Database\Factories\RoomFactory;

class Room extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = "rooms";
    protected $fillable = ['name', 'location', 'capacity'];


    public function terms() {
        return $this->hasMany(Term::class, 'room_id');
    }


    // protected static function newFactory(): RoomFactory
    // {
    //     // return RoomFactory::new();
    // }
}
