<?php

namespace Modules\AboutUs\Transformers;

use App\Helpers\ResourceHelper;
use App\Traits\Translatable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsResource extends JsonResource
{
    use Translatable;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->whenHas('title'),
            'description' => $this->whenHas('description'),
            'first_image' => $this->whenNotNull(ResourceHelper::getFirstMediaOriginalUrl($this, 'firstImage')),
            'other_images' => $this->whenLoaded('publicOtherImages', function () {
                return $this->publicOtherImages->map(fn ($image) => $image->original_url);
            }),
        ];
    }
}
