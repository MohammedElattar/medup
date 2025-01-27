<?php

namespace Modules\Auth\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;

class AdminChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'old_password' => [
                'required',
                'current_password',
            ],
            'new_password' => ValidationRuleHelper::defaultPasswordRules(),
        ];
    }
}
