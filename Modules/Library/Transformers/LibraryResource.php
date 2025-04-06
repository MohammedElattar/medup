<?php

namespace Modules\Library\Transformers;

use App\Helpers\ResourceHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Expert\Transformers\ExpertResource;
use Modules\Speciality\Transformers\SpecialityResource;
use Modules\Tag\Transformers\TagResource;

class LibraryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->whenHas('title'),
            'price' => $this->whenHas('price'),
            'rating_average' => $this->whenHas('rating_average'),
            'cover' => $this->whenNotNull(ResourceHelper::getFirstMediaOriginalUrl($this, 'cover')),
            $this->mergeWhen($this->relationLoaded('order'), function(){
                return [
                    'purchased' => !is_null($this->order),
                    'order_id' => $this->order ? $this->order->id : null,
                    'reviewed' => !! $this->myReview,
                ];
            }),
            'file' => $this->whenNotNull(ResourceHelper::getFirstMediaOriginalUrl($this, 'file')),
            'created_at' => $this->whenHas('created_at'),
            'pages_count' => $this->whenHas('pages_count'),
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
