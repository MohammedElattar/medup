<?php

namespace Modules\Wallet\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Payment\Http\Requests\PaymentRequest;

class WalletRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            'amount' => ValidationRuleHelper::doubleRules(),
            ...PaymentRequest::availableRules(),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
