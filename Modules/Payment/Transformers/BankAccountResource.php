<?php

namespace Modules\Payment\Transformers;

use App\Helpers\ResourceHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->whenHas('name'),
            'account_number' => $this->whenHas('account_number'),
            'iban' => $this->whenHas('iban'),
            'swift_code' => $this->whenHas('swift_code'),
            'default' => $this->whenHas('default'),
            'other_details' => $this->whenHas('other_details'),
            'image' => $this->whenLoaded('image', function () {
                return ResourceHelper::getFirstMediaOriginalUrl($this, 'image', shouldReturnDefault: false);
            }),
        ];
    }
}
