<?php

namespace Modules\Course\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class CourseRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            'name' => ValidationRuleHelper::stringRules(),
            'link' => ValidationRuleHelper::urlRules(),
            'speciality_id' => ValidationRuleHelper::foreignKeyRules(),
            'price' => ValidationRuleHelper::doubleRules(),
            'description' => ValidationRuleHelper::longTextRules(),
            'cover' => ValidationRuleHelper::storeOrUpdateImageRules(),
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


/*
 * */
