<?php

namespace Modules\Wallet\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class MoneyTransferRequest extends FormRequest
{
    use HttpResponse;

    public function rules()
    {
        return [
            'from_user_id' => ValidationRuleHelper::foreignKeyRules(),
            'to_user_id' => ValidationRuleHelper::foreignKeyRules(),
            'amount' => ValidationRuleHelper::doubleRules(),
            'description' => ValidationRuleHelper::stringRules([
                'required' => 'sometimes',
            ]),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
