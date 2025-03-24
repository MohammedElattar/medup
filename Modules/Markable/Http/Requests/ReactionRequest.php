<?php

namespace Modules\Markable\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Markable\Helpers\EmojiValidatorHelper;

class ReactionRequest extends FormRequest
{
    use HttpResponse;

    public function prepareForValidation()
    {
        EmojiValidatorHelper::mergeOneValidEmoji($this);
    }

    public function rules(): array
    {
        return [
            'remove' => ValidationRuleHelper::booleanRules(),
            'value' => ValidationRuleHelper::emojiRules([
                'required' => $this->remove ? 'exclude' : 'required',
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
