<?php

namespace Modules\Idea\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class IdeaFilterRequest extends FormRequest
{
    use HttpResponse;

    public function prepareForValidation()
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
            'specialities' => ValidationRuleHelper::arrayRules([
                'required' => 'sometimes',
            ]),
            'specialities.*' => ValidationRuleHelper::foreignKeyRules([
                'required' => 'sometimes',
            ]),
            'paid' => ValidationRuleHelper::booleanRules([
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
