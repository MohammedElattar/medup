<?php

namespace Modules\Blog\Transformers;

use App\Helpers\ResourceHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Country\Transformers\CountryResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->whenHas('title'),
            'sub_title' => $this->whenHas('sub_title'),
            'user' => $this->whenHas('user'),
            'created_at' => $this->whenHas('created_at'),
            'image' => $this->whenNotNull(ResourceHelper::getFirstMediaOriginalUrl($this, 'image')),
            'tags' => $this->whenLoaded('tags', function(){
                return CountryResource::collection($this->tags);
            }),
            'content' => $this->whenHas('content'),
        ];
    }
}
