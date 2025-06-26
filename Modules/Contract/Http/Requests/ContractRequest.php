<?php

namespace Modules\Contract\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ContractRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            'name' => ValidationRuleHelper::stringRules(),
            'address' => ValidationRuleHelper::stringRules(),
            'other_user_id' => ValidationRuleHelper::foreignKeyRules(),
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
