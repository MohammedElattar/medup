<?php

namespace Modules\Collaborate\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CollaborateFilterRequest extends FormRequest
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
