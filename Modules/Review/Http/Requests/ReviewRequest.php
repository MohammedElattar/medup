<?php

namespace Modules\Review\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ReviewRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            'description' => ValidationRuleHelper::longTextRules(),
            'rating' => ValidationRuleHelper::doubleRules([
                'max' => 'max:5',
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
