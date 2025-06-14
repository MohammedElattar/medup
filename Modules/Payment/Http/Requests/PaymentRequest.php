<?php

namespace Modules\Payment\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Payment\Enums\PaymentMethodEnum;

class PaymentRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            ...self::availableRules(),
        ];
    }

    /**
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }

    public static function availableRules(): array
    {
        return [
            'payment_details' => ValidationRuleHelper::arrayRules(),
            'payment_details.cvv' => ValidationRuleHelper::integerRules([
                'min' => 'min:100',
                'max' => 'max:999',
            ]),
            'payment_details.number' => ValidationRuleHelper::integerRules(),
            'payment_details.exp_month' => ValidationRuleHelper::integerRules([
                'min' => 'min:' . now()->month,
                'max' => 'max:12',
            ]),
            'payment_details.exp_year' => ValidationRuleHelper::integerRules([
                'min' => 'min:' . now()->year,
            ]),
        ];
    }
}
