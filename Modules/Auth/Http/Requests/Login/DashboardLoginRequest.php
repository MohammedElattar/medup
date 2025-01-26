<?php

namespace Modules\Auth\Http\Requests\Login;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;

class DashboardLoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ValidationRuleHelper::emailRules(),
            'password' => 'required',
            'fcm_token' => ['sometimes', 'string'],
        ];
    }
}
