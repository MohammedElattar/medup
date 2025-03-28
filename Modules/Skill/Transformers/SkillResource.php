<?php

namespace Modules\Skill\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->whenHas('name'),
            'experts_count' => $this->whenHas('experts_count'),
            'posts_count' => 0,
            'specialities' => $this->whenLoaded('specialities', function(){
                return $this->specialities->pluck('id');
            })
        ];
    }
}
