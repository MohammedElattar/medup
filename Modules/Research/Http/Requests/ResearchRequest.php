<?php

namespace Modules\Research\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ResearchRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            'title' => ValidationRuleHelper::stringRules(),
            'contributors' => ValidationRuleHelper::stringRules(),
            'skills' => ValidationRuleHelper::stringRules(),
            'notes' => ValidationRuleHelper::longTextRules(),
            'file' => ValidationRuleHelper::pdfRules(),
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
