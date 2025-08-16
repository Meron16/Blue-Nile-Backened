<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class RoomType extends Model
{
    protected $fillable = [
        'name','slug','description','guest_capacity','beds_count',
        'has_lake_view','has_balcony','base_price','images'
    ];

    protected $casts = [
        'has_lake_view' => 'boolean',
        'has_balcony'   => 'boolean',
        'images'        => 'array',
    ];

    public function amenities() {
        return $this->belongsToMany(Amenity::class)->withTimestamps();
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    public function rates() {
        return $this->hasMany(BookingRate::class);
    }
}

