<?php

namespace Modules\Collaborate\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Expert\Transformers\ExpertResource;
use Modules\Speciality\Transformers\SpecialityResource;

class CollaborateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->whenHas('title'),
            'price' => $this->whenHas('price'),
            'comments_count' => $this->whenHas('comments_count'),
            'orcid_number' => $this->whenHas('orcid_number'),
            'created_at' => $this->whenHas('created_at'),
            'expert' => $this->whenLoaded('expert', function(){
                return ExpertResource::make($this->expert);
            }),
            'speciality' => $this->whenLoaded('speciality', function(){
                return SpecialityResource::make($this->speciality);
            }),
            'description' => $this->whenHas('description'),
        ];
    }
}
