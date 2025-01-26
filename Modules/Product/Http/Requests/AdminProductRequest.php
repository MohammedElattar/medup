<?php

namespace Modules\Product\Http\Requests;

use App\Helpers\TranslationHelper;
use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\Enums\UserTypeEnum;

class AdminProductRequest extends FormRequest
{
  public function prepareForValidation()
  {
    TranslationHelper::mergeDefaultTranslatedInput();
    TranslationHelper::mergeDefaultTranslatedInput('description');
  }

  public function rules(): array
    {
        $inUpdate = ! preg_match('/.*products$/', $this->url());

        return [
            ...ValidationRuleHelper::translatedArray(),
            ...ValidationRuleHelper::translatedArray('description', valueType: 'longText'),
            'price' => ValidationRuleHelper::integerRules([
                'required' => $inUpdate ? 'sometimes ' : 'required',
            ]),
            'quantity' => ValidationRuleHelper::integerRules([
                'required' => $inUpdate ? 'sometimes ' : 'required',
            ]),
            'category_id' => ValidationRuleHelper::foreignKeyRules([
                'required' => $inUpdate ? 'sometimes ' : 'required',
            ]),
            'inventory_owner_id' => ValidationRuleHelper::foreignKeyRules([
                'required' => UserTypeEnum::getUserType() == UserTypeEnum::INVENTORY_OWNER ? 'exclude' : ($inUpdate ? 'sometimes ' : 'required'),
            ]),
            'image' => ValidationRuleHelper::storeOrUpdateImageRules($inUpdate),
        ];
    }
}
