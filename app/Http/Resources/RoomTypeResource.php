<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'slug'          => $this->slug,
            'description'   => $this->description,
            'guestCapacity' => $this->guest_capacity,
            'bedsCount'     => $this->beds_count,
            'hasLakeView'   => $this->has_lake_view,
            'hasBalcony'    => $this->has_balcony,
            'basePrice'     => $this->base_price,
            'images'        => $this->images,
            'amenities'     => AmenityResource::collection($this->whenLoaded('amenities')),
        ];
    }
}
