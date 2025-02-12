<?php

namespace Modules\Expert\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpertSocialContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'facebook' => $this->whenHas('facebook'),
            'twitter' => $this->whenHas('twitter'),
            'linkedin' => $this->whenHas('linkedin'),
            'email' => $this->whenHas('email'),
        ];
    }
}
