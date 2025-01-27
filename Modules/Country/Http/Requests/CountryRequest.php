<?php

namespace Modules\Country\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function rules(): array
    {
        return ValidationRuleHelper::translatedArray();
    }
}
