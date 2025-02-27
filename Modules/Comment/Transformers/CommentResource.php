<?php

namespace Modules\Comment\Transformers;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Transformers\UserResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->whenHas('created_at'),
            'content' => $this->whenHas('content'),
            'user' => $this->whenLoaded('user', function(){
                return UserResource::make($this->user);
            }),
            'replied_user' => $this->whenLoaded('repliedUser', function(){
               return UserResource::make($this->repliedUser);
            }),
        ];
    }
}
