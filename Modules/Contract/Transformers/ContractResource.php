<?php

namespace Modules\Contract\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_member' => $this->whenHas('first_member'),
            'second_member' => $this->whenHas('second_member'),
            'first_member_details' => $this->whenHas('first_member_details'),
            'second_member_details' => $this->whenHas('second_member_details'),
        ];
    }
}
