<?php

namespace Modules\City\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Country\Transformers\CountryResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->whenHas('name'),
            'country' => CountryResource::make($this->whenLoaded('country')),
            'experts_count' => $this->whenHas('experts_count'),
        ];
    }
}
