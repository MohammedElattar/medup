<?php

namespace Modules\Library\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;

class LibraryRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            'title' => ValidationRuleHelper::stringRules(),
            'description' => ValidationRuleHelper::longTextRules(),
            'cover' => ValidationRuleHelper::storeOrUpdateImageRules(),
            'file' => ValidationRuleHelper::pdfRules(),
            'price' => ValidationRuleHelper::doubleRules(),
            'speciality_id' => ValidationRuleHelper::foreignKeyRules(),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
