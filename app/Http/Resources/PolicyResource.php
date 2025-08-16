<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PolicyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'type'=>$this->type,
            'content'=>$this->content,
        ];
    }
}

