<?php

namespace Modules\Expert\Transformers;

use App\Helpers\ResourceHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpertCertificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->whenHas('name'),
            'date' => $this->whenHas('date'),
            'file' => $this->whenNotNull(ResourceHelper::getFirstMediaOriginalUrl($this, 'file')),
        ];
    }
}
