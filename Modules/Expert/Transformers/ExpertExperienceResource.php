<?php

namespace Modules\Expert\Transformers;

use App\Helpers\ResourceHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Modules\City\Transformers\CityResource;

class ExpertExperienceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'hospital_name' => $this->whenHas('hospital_name'),
            'job_title' => $this->whenHas('job_title'),
            'start_date' => $this->whenHas('start_date'),
            'end_date' => $this->whenHas('end_date'),
            'work_type' => $this->whenHas('work_type'),
            'experience_years' => $this->whenHas('experience_years'),
            'content' => $this->whenHas('content'),
            'city_id' => $this->when(ResourceHelper::shouldReturnForeignKey($this, 'city', 'city_id'), $this->city_id),
            'city' => $this->whenLoaded('city', function(){
                return CityResource::make($this->city);
            }),
        ];
    }
}
