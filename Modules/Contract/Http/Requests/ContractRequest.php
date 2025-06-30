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
            'other_user_id' => ValidationRuleHelper::foreignKeyRules(),
            'expert_name' => ValidationRuleHelper::stringRules(),
            'expert_email' => ValidationRuleHelper::emailRules(),
            'trainee_name' => ValidationRuleHelper::stringRules(),
            'trainee_email' => ValidationRuleHelper::emailRules(),
            'service_type' => ValidationRuleHelper::stringRules(),
            'description' => ValidationRuleHelper::stringRules(),
            'sessions_per_week' => ValidationRuleHelper::integerRules(),
            'start_date' => ValidationRuleHelper::dateRules(),
            'end_date' => ValidationRuleHelper::dateRules(),
            'is_online' => ValidationRuleHelper::booleanRules(),
            'contract_start_date' => ValidationRuleHelper::dateRules(),
            'contract_end_date' => ValidationRuleHelper::dateRules(),
            'price' => ValidationRuleHelper::integerRules(),
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
