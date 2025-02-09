<?php

namespace Modules\College\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;

class CollegeRequest extends FormRequest
{
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
}
