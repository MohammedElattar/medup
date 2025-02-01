<?php

namespace Modules\Expert\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ExpertFilterRequest extends FormRequest
{
    use HttpResponse;

    public static array $keys = [
        'colleges' => 'speciality.college',
        'specialities' => 'speciality',
        'skills' => 'skills',
    ];

    public function prepareForValidation(): void
    {
        $inputs = $this->all();

        foreach (array_keys(self::$keys) as $key) {
            if (isset($inputs[$key])) {
                $inputs[$key] = explode(',', $inputs[$key]);
            }
        }

        $this->replace($inputs);
    }

    public function rules(): array
    {
        return [
            'only_top' => ValidationRuleHelper::booleanRules([
                'required' => 'nullable',
            ]),
            'colleges' => ValidationRuleHelper::arrayRules([
                'required' => 'sometimes',
            ]),
            'colleges.*' => ValidationRuleHelper::foreignKeyRules([
                'required' => 'sometimes',
            ]),
            'specialities' => ValidationRuleHelper::arrayRules([
                'required' => 'sometimes',
            ]),
            'specialities.*' => ValidationRuleHelper::foreignKeyRules([
                'required' => 'sometimes',
            ]),
            'skills' => ValidationRuleHelper::arrayRules([
                'required' => 'sometimes',
            ]),
            'skills.*' => ValidationRuleHelper::foreignKeyRules([
                'required' => 'sometimes',
            ]),
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
