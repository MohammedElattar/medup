<?php

namespace Modules\Testimonial\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Transformers\UserResource;

class TestimonialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->whenHas('content'),
            'user' => $this->whenLoaded('user', function(){
                return UserResource::make($this->user);
            }),
        ];
    }
}
