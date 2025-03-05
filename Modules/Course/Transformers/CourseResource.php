<?php

namespace Modules\Course\Transformers;

use App\Helpers\ResourceHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Expert\Transformers\ExpertResource;
use Modules\Speciality\Transformers\SpecialityResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->whenHas('name'),
            'price' => $this->whenHas('price'),
            'cover' => $this->whenNotNull(ResourceHelper::getFirstMediaOriginalUrl($this, 'cover')),
            'rating_average' => $this->whenHas('rating_average'),
            'link' => $this->whenHas('link'),
            'description' => $this->whenHas('description'),
            'expert' => $this->whenLoaded('expert', function(){
                return ExpertResource::make($this->expert);
            }),
            'speciality' => $this->whenLoaded('speciality', function(){
                return SpecialityResource::make($this->speciality);
            }),
        ];
    }
}
