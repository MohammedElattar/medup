<?php

namespace Modules\Speciality\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class SpecialityRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            ...ValidationRuleHelper::translatedArray(),
            'skills'=> ValidationRuleHelper::arrayRules(),
            'skills.*' => ValidationRuleHelper::foreignKeyRules(),
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
