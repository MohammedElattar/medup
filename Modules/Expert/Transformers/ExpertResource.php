<?php

namespace Modules\Expert\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Transformers\UserResource;
use Modules\City\Transformers\CityResource;
use Modules\Skill\Transformers\SkillResource;
use Modules\Speciality\Transformers\SpecialityResource;

class ExpertResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rating_average' => $this->whenHas('rating_average'),
            'is_premium' => $this->whenHas('is_premium'),
            'city' => $this->whenLoaded('city', function(){
                return CityResource::make($this->city);
            }),
            'speciality' => $this->whenLoaded('speciality', function(){
                return SpecialityResource::make($this->speciality);
            }),
            'skills' => $this->whenLoaded('skills', function(){
               return SkillResource::collection($this->skills);
            }),
            'user' => $this->whenLoaded('user', function(){
                return UserResource::make($this->user);
            }),
        ];
    }
}
