<?php

namespace Modules\Vendor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\InventoryOwner\Http\Requests\InventoryOwnerRequest;

class VendorRequest extends FormRequest
{
    public function prepareForValidation(): void
    {
        InventoryOwnerRequest::basePrepareForValidation($this);
    }

    public function rules(): array
    {
        $inUpdate = ! preg_match('/.*vendors$/', $this->url());

        return InventoryOwnerRequest::baseRules($inUpdate);
    }
}
