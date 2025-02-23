<?php

namespace Modules\Auth\Http\Requests;

use App\Helpers\RequestHelper;
use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function prepareForValidation()
    {
        RequestHelper::formatPhoneNumber($this);
    }

    public function rules(): array
    {
        return [
            'first_name' => ValidationRuleHelper::stringRules(['required' => 'sometimes']),
            'middle_name' => ValidationRuleHelper::stringRules(['required' => 'sometimes']),
            'email' => ValidationRuleHelper::emailRules(['required' => 'sometimes']),
            'phone' => ValidationRuleHelper::phoneRules(['required' => 'sometimes']),
            'avatar' => ValidationRuleHelper::storeOrUpdateImageRules(true),
        ];
    }
}
