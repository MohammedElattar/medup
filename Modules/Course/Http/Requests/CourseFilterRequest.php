<?php

namespace Modules\Course\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class CourseFilterRequest extends FormRequest
{
    use HttpResponse;

    public function prepareForValidation(): void
    {
        $specialities = array_filter(explode(',', $this->input('specialities', '')));
        $inputs = $this->all();

        if(! $specialities) {
            unset($inputs['specialities']);
            $this->replace($inputs);
        } else {
            $this->merge(['specialities' => $specialities]);
        }
    }

    public function rules(): array
    {
        return [
            'recommended' => ValidationRuleHelper::booleanRules([
                'required' => 'nullable',
            ]),
            'specialities' => ValidationRuleHelper::arrayRules([
                'required' => 'sometimes',
            ]),
            'specialities.*' => ValidationRuleHelper::foreignKeyRules([
                'required' => 'sometimes',
            ]),
            'suggested_based_id' => ValidationRuleHelper::foreignKeyRules([
                'required' => 'nullable',
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
