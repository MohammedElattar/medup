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
        'cities' => 'city',
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
            'only_premium' => ValidationRuleHelper::booleanRules([
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
            'cities' => ValidationRuleHelper::arrayRules([
                'required' => 'sometimes',
            ]),
            'skills.*' => ValidationRuleHelper::foreignKeyRules([
                'required' => 'sometimes',
            ]),
            'cities.*' => ValidationRuleHelper::foreignKeyRules([
                'required' => 'sometimes',
            ]),
            'order_by_date' => ValidationRuleHelper::enumRules(['asc', 'desc'], [
                'required' => 'nullable'
            ]),
            'city' => ValidationRuleHelper::stringRules([
                'required' => 'nullable',
            ])
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
