<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'room_type_id','first_name','last_name','email','phone',
        'check_in','check_out','guest_count','status','total_price','meta'
    ];

    protected $casts = [
        'check_in'   => 'date',
        'check_out'  => 'date',
        'meta'       => 'array',
    ];

    public function roomType() {
        return $this->belongsTo(RoomType::class);
    }
}

