<?php

namespace Modules\Setting\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'mail_from' => ValidationRuleHelper::stringRules(),
            'mail_username' => ValidationRuleHelper::emailRules(),
            'mail_password' => ValidationRuleHelper::stringRules(),
            'mail_host' => ValidationRuleHelper::stringRules(),
            'mail_port' => ValidationRuleHelper::stringRules(),
            'mail_encryption' => ValidationRuleHelper::stringRules(),
            'mail_protocol' => ValidationRuleHelper::stringRules(),
            'stripe_secret_key' => ValidationRuleHelper::stringRules(),
        ];
    }
}
