<?php

namespace Modules\Idea\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class IdeaRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            'title' => ValidationRuleHelper::stringRules(),
            'description' => ValidationRuleHelper::stringRules(),
            'price' => ValidationRuleHelper::integerRules(),
            'speciality_id' => ValidationRuleHelper::foreignKeyRules(),
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
