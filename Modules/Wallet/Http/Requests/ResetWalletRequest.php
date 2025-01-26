<?php

namespace Modules\Wallet\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ResetWalletRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            'incoming' => ValidationRuleHelper::booleanRules(),
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
