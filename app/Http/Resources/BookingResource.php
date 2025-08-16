<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'roomType'=> new RoomTypeResource($this->whenLoaded('roomType')),
            'firstName'=>$this->first_name,
            'lastName'=>$this->last_name,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'checkIn'=>$this->check_in?->toDateString(),
            'checkOut'=>$this->check_out?->toDateString(),
            'guestCount'=>$this->guest_count,
            'status'=>$this->status,
            'totalPrice'=>$this->total_price,
            'meta'=>$this->meta,
        ];
    }
}
