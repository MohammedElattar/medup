<?php

namespace Modules\Expert\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ExpertCertificationRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            'name' => ValidationRuleHelper::stringRules(),
            'date' => ValidationRuleHelper::dateRules(),
            'image' => ValidationRuleHelper::storeOrUpdateImageRules(true)
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
