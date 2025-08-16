<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = ['name','category','icon'];

    public function roomTypes() {
        return $this->belongsToMany(RoomType::class)->withTimestamps();
    }
}

