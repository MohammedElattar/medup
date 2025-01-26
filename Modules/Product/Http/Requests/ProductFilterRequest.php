<?php

namespace Modules\Product\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ProductFilterRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            'category_id' => ValidationRuleHelper::foreignKeyRules([
                'required' => 'nullable',
            ]),
            'inventory_owner_id' => ValidationRuleHelper::foreignKeyRules([
                'required' => 'nullable',
            ]),
        ];
    }

    /**
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
