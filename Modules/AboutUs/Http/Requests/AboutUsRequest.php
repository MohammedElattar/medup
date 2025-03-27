<?php

namespace Modules\AboutUs\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AboutUsRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            ...ValidationRuleHelper::translatedArray('title'),
            ...ValidationRuleHelper::translatedArray('description'),
            'first_image' => ValidationRuleHelper::storeOrUpdateImageRules(true),
            'other_images' => ValidationRuleHelper::arrayRules([
                'required' => $this->route('id') == 1 ? 'sometimes' : 'exclude',
            ]),
            'other_images.*' => ValidationRuleHelper::storeOrUpdateImageRules(true, [
                'required' => $this->route('id') == 1 ? 'sometimes' : 'exclude',
            ]),
            'deleted_images' => ValidationRuleHelper::arrayRules([
                'required' => $this->route('id') == 1 ? 'sometimes' : 'exclude',
            ]),
            'deleted_images.*' => ValidationRuleHelper::foreignKeyRules([
                'required' => $this->route('id') == 1 ? 'sometimes' : 'exclude',
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
