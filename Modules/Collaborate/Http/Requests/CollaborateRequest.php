<?php

namespace Modules\Collaborate\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CollaborateRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            ...self::baseRules(),
            'price' => ValidationRuleHelper::integerRules(),
        ];
    }

    public static function baseRules()
    {
        return [
            'title' => ValidationRuleHelper::stringRules(),
            'description' => ValidationRuleHelper::stringRules(),
            'orcid_number' => ValidationRuleHelper::urlRules(false),
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
