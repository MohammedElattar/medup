<?php

namespace Modules\Wallet\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Modules\Auth\Transformers\UserResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->whenHas('type'),
            'user_id' => $this->when(! $this->relationLoaded('user') && ! is_null($this->user_id), $this->user_id),
            'amount' => $this->amount,
            'incoming' => $this->incoming,
            'from_admin' => $this->whenHas('from_admin'),
            'created_at' => Carbon::parse($this->created_at),
            'description' => $this->description,
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
