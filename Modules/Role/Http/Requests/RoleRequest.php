<?php

namespace Modules\Role\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function rules(): array
    {
        $inUpdate = $this->method() == 'PUT';

        return [
            'name' => ValidationRuleHelper::stringRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
            'permissions' => ValidationRuleHelper::arrayRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
            'permissions.*' => ValidationRuleHelper::foreignKeyRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
        ];
    }
}
