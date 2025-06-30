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
            'service_type' => $this->whenHas('service_type'),
            'description' => $this->whenHas('description'),
            'sessions_per_week' => $this->whenHas('sessions_per_week'),
            'start_date' => $this->whenHas('start_date'),
            'end_date' => $this->whenHas('end_date'),
            'is_online' => $this->whenHas('is_online'),
            'contract_start_date' => $this->whenHas('contract_start_date'),
            'contract_end_date' => $this->whenHas('contract_end_date'),
            'price' => $this->whenHas('price'),
            'expert_name' => $this->whenHas('expert_name'),
            'expert_email' => $this->whenHas('expert_email'),
            'trainee_name' => $this->whenHas('trainee_name'),
            'trainee_email' => $this->whenHas('trainee_email'),
        ];
    }
}
