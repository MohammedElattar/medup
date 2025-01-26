<?php

namespace Modules\InventoryOwner\Http\Requests;

use App\Helpers\RequestHelper;
use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;

class InventoryOwnerRequest extends FormRequest
{
    public function prepareForValidation()
    {
        self::basePrepareForValidation($this);
    }

    public function rules(): array
    {
        $inUpdate = ! preg_match('/.*inventory-owners$/', $this->url());

        return self::baseRules($inUpdate);
    }

    public static function basePrepareForValidation($thisValue)
    {
        $inputs = $thisValue->all();
        RequestHelper::formatPhoneNumber($thisValue);

        if (! isset($inputs['password'])) {
            unset($inputs['password']);
        }

        $thisValue->replace($inputs);
    }

    public static function baseRules(bool $inUpdate)
    {
        return [
            'name' => ValidationRuleHelper::stringRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
            'email' => ValidationRuleHelper::emailRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
            'phone' => ValidationRuleHelper::phoneRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
            'password' => ValidationRuleHelper::defaultPasswordRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
        ];
    }
}
