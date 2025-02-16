<?php

namespace Modules\Blog\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

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

     /**
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
