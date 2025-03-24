<?php

namespace Modules\Subscription\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'starts_at' => $this->whenHas('starts_at'),
            'ends_at' => $this->whenHas('ends_at'),
            'paid' => $this->whenHas('paid'),
        ];
    }
}
