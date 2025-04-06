<?php

namespace Modules\Expert\Transformers;

use App\Helpers\ResourceHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Transformers\UserResource;
use Modules\City\Transformers\CityResource;
use Modules\Review\Transformers\ReviewResource;
use Modules\Skill\Transformers\SkillResource;
use Modules\Speciality\Transformers\SpecialityResource;

class ExpertResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reviewed' => $this->whenHas('reviewed', function(){
                return !!$this->reviewed;
            }),
            'reviews_count' => $this->whenHas('reviews_count'),
            'rating_average' => $this->whenHas('rating_average'),
            'is_premium' => $this->whenHas('is_premium'),
            'headline' => $this->whenHas('headline'),
            'graduation_year' => $this->whenHas('graduation_year'),
            'experience_years' => $this->whenHas('experiences_sum_experience_years'),
            'degree' => $this->whenHas('degree'),
            'education' => $this->whenHas('education'),
            'cv' => $this->whenNotNull(ResourceHelper::getFirstMediaOriginalUrl($this, 'cv')),
            'city' => $this->whenLoaded('city', function(){
                return CityResource::make($this->city);
            }),
            'speciality' => $this->whenLoaded('speciality', function(){
                return SpecialityResource::make($this->speciality);
            }),
            'certification' => $this->whenLoaded('certification', function(){
                return ExpertCertificationResource::make($this->certification);
            }),
            'skills' => $this->whenLoaded('skills', function(){
               return SkillResource::collection($this->skills);
            }),
            'user' => $this->whenLoaded('user', function(){
                return UserResource::make($this->user);
            }),
            'social_contacts' => $this->whenLoaded('socialContacts', function(){
                return ExpertSocialContactResource::make($this->socialContacts);
            }),
            'experiences' => $this->whenLoaded('experiences', function(){
                return ExpertExperienceResource::collection($this->experiences);
            }),
            'reviews' => $this->whenLoaded('reviews', function(){
                return ReviewResource::collection($this->reviews);
            }),
        ];
    }
}
