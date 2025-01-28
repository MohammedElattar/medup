<?php

namespace Modules\Auth\Http\Requests\Register;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Modules\Auth\Enums\DegreeEnum;
use Modules\Auth\Helpers\UserTypeHelper;

class BaseRegisterRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [

        ];
    }

    public static function baseRules()
    {
        return [
            'first_name' => ValidationRuleHelper::stringRules(),
            'middle_name' => ValidationRuleHelper::stringRules(),
            'email' => ValidationRuleHelper::emailRules(),
            'phone' => ValidationRuleHelper::phoneRules([
                'required' => 'nullable',
            ]),
            'password' => ValidationRuleHelper::defaultPasswordRules(),
            'city_id' => ValidationRuleHelper::foreignKeyRules(),
            'speciality_id' => ValidationRuleHelper::foreignKeyRules(),
            'avatar' => ValidationRuleHelper::storeOrUpdateImageRules(),
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
