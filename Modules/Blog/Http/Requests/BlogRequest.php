<?php

namespace Modules\Blog\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        $inUpdate = !preg_match('/.*blogs$/', $this->url());

        return array_merge(
            ValidationRuleHelper::translatedArray('title'),
            ValidationRuleHelper::translatedArray('sub_title'),
            ValidationRuleHelper::translatedArray('content'),
            [
                'image' => ValidationRuleHelper::storeOrUpdateImageRules($inUpdate),
                'created_at' => ValidationRuleHelper::dateRules([
                    'required' => 'nullable',
                ]),
                'user' => ValidationRuleHelper::stringRules(),
                'tags' => ValidationRuleHelper::arrayRules(),
                'tags.*' => ValidationRuleHelper::foreignKeyRules(),
            ]
        );
    }

    public function failedValidation(Validator $validator)
    {
        $this->throwValidationException($validator);
    }
}
