<?php

namespace Modules\Product\Http\Requests;

use App\Helpers\RequestHelper;
use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ProductOrderRequest extends FormRequest
{
    use HttpResponse;

    public function prepareForValidation()
    {
        RequestHelper::formatPhoneNumber($this);
    }

    public function rules(): array
    {
        return [
            'name' => ValidationRuleHelper::stringRules(),
            'email' => ValidationRuleHelper::emailRules(),
            'phone' => ValidationRuleHelper::phoneRules(),
            'quantity' => ValidationRuleHelper::integerRules(),
            'new_price' => ValidationRuleHelper::doubleRules(),
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
