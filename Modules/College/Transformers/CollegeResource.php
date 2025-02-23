<?php

namespace Modules\College\Transformers;

use App\Helpers\ResourceHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Speciality\Transformers\SpecialityResource;

class CollegeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->whenHas('name'),
            'description' => $this->whenHas('description'),
            'icon' => $this->whenNotNull(ResourceHelper::getFirstMediaOriginalUrl($this, 'icon', 'science.svg')),
            'experts_count' => $this->whenHas('experts_count'),
            'specialities' => $this->whenLoaded('specialities', function(){
                return SpecialityResource::collection($this->specialities);
            }),
        ];
    }
}
