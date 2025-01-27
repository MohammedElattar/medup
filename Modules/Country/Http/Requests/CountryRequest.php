<?php

namespace Modules\Country\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class CountryRequest extends FormRequest
{
    public function rules(): array
    {
        return ValidationRuleHelper::translatedArray();
    }
}
