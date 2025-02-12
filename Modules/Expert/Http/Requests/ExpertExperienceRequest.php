<?php

namespace Modules\Expert\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Modules\Expert\Enums\ExperienceWorkTypeEnum;

class ExpertExperienceRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        $inUpdate = in_array($this->method(), ['PUT', 'PATCH']);

        return [
            'hospital_name' => ValidationRuleHelper::stringRules([
                'required' => $inUpdate ? 'sometimes' : 'required'
            ]),
            'job_title' => ValidationRuleHelper::stringRules([
                'required' => $inUpdate ? 'sometimes' : 'required'
            ]),
            'start_date' => ValidationRuleHelper::dateRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
                'before' => 'before:end_date',
            ]),
            'end_date' => ValidationRuleHelper::dateRules([
                'required' => 'nullable',
                'after' => 'after:start_date',
            ]),
            'content' => ValidationRuleHelper::longTextRules([
                'required' => $inUpdate ? 'sometimes' : 'required'
            ]),
            'work_type' => ValidationRuleHelper::enumRules(ExperienceWorkTypeEnum::toArray(), [
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
            'city_id' => ValidationRuleHelper::foreignKeyRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
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
