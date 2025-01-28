<?php

namespace Modules\Auth\Http\Requests\Register;

use App\Helpers\RequestHelper;
use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Modules\Auth\Enums\DegreeEnum;
use Modules\Auth\Enums\UserTypeEnum;

class ExpertRegisterRequest extends FormRequest
{
    use HttpResponse;

    public function prepareForValidation()
    {
        RequestHelper::formatPhoneNumber($this);
    }

    public function rules(): array
    {
        return [
            ...BaseRegisterRequest::baseRules(),
            'degree' => ValidationRuleHelper::enumRules(DegreeEnum::toArray()),
            'type' => ValidationRuleHelper::enumRules([
                UserTypeEnum::EXPERT,
                UserTypeEnum::EXPERT_LEARNER
            ]),
            'skills' => ValidationRuleHelper::arrayRules(),
            'skills.*' => ValidationRuleHelper::foreignKeyRules(),
            'cv' => ValidationRuleHelper::pdfRules()
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
