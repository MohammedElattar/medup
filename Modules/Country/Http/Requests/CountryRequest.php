<?php

namespace Modules\Country\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return ValidationRuleHelper::translatedArray();
    }

    public function failedValidation(Validator $validator)
    {
        $this->throwValidationException($validator);
    }
}
