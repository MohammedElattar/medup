<?php

namespace Modules\Expert\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Modules\Auth\Enums\DegreeEnum;
use Modules\Auth\Enums\UserTypeEnum;

class ExpertRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            ...self::baseRules(true),
        ];
    }

    public static function baseRules($inUpdate = false)
    {
        $updateFields = [
            'city_id' => ValidationRuleHelper::foreignKeyRules([
                'required' => 'sometimes',
            ]),
            'speciality_id' => ValidationRuleHelper::foreignKeyRules([
                'required' => 'sometimes',
            ]),
        ];

        $rules = array_merge([
            'degree' => ValidationRuleHelper::enumRules(DegreeEnum::toArray(), [
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
            'type' => ValidationRuleHelper::enumRules([
                UserTypeEnum::EXPERT,
                UserTypeEnum::EXPERT_LEARNER
            ], [
                'required' => $inUpdate ? 'exclude' : 'required',
            ]),
            'skills' => ValidationRuleHelper::arrayRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
            'skills.*' => ValidationRuleHelper::foreignKeyRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
            'cv' => ValidationRuleHelper::pdfRules($inUpdate),
            'headline' => ValidationRuleHelper::longTextRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
            'graduation_year' => ValidationRuleHelper::yearRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
            'education' => ValidationRuleHelper::stringRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
        ], $inUpdate ? $updateFields : []);

        if(request()->has('social_contacts')) {
            $rules = array_merge($rules, ExpertSocialContactRequest::baseRules());
        }

        return $rules;
    }

     /**
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
