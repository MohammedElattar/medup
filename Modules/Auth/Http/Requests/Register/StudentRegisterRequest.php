<?php

namespace Modules\Auth\Http\Requests\Register;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Enums\UserTypeEnum;

class StudentRegisterRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            ...BaseRegisterRequest::baseRules(),
            'type' => ValidationRuleHelper::enumRules([
                UserTypeEnum::STUDENT,
                UserTypeEnum::TRAINEE,
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
