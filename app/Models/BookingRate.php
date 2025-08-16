<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingRate extends Model
{
    protected $fillable = ['room_type_id','date','price'];

    public function roomType() {
        return $this->belongsTo(RoomType::class);
    }
}

