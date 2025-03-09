<?php

namespace Modules\College\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CollegeRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        $inUpdate = !preg_match('/.*colleges$/', $this->url());

        return array_merge([
            'icon' => ValidationRuleHelper::storeOrUpdateImageRules($inUpdate, [
                'mimes' => 'mimes:svg',
            ]),
        ],
            ValidationRuleHelper::translatedArray(),
            ValidationRuleHelper::translatedArray('description', valueType: 'longText'),
        );
    }

    public function failedValidation(Validator $validator)
    {
        $this->throwValidationException($validator);
    }
}
