<?php

namespace Modules\Order\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Modules\Order\Enums\OrderTypeEnum;

class OrderRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            'type' => ValidationRuleHelper::enumRules(OrderTypeEnum::toArray()),
            'id' => ValidationRuleHelper::foreignKeyRules(),
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
