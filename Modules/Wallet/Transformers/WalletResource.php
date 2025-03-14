<?php

namespace Modules\Wallet\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'balance' => round($this->balance, 2),
            'incoming_sum' => $this->whenHas('incoming_transactions_sum_amount'),
        ];
    }
}
