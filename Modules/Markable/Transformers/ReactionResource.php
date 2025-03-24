<?php

namespace Modules\Markable\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Transformers\UserResource;
use Modules\Chat\Transformers\ConversationMessageResource;

class ReactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->whenHas('value'),
            'reacted_user_id' => $this->whenHas('user_id'),
            $this->mergeWhen($this->relationLoaded('user'), function () {
                return UserResource::make($this->user);
            }),
            'message' => ConversationMessageResource::make($this->whenLoaded('markable')),
        ];
    }
}
