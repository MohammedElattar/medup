<?php

namespace Modules\Expert\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ExpertSocialContactRequest extends FormRequest
{
    use HttpResponse;

    public static function baseRules(): array
    {
        return [
            'social_contacts' => ValidationRuleHelper::arrayRules([
                'required' => 'sometimes',
            ]),
            'social_contacts.facebook' => ValidationRuleHelper::urlRules(false),
            'social_contacts.twitter' => ValidationRuleHelper::urlRules(false),
            'social_contacts.linkedin' => ValidationRuleHelper::urlRules(false),
            'social_contacts.email' => ValidationRuleHelper::emailRules([
                'required' => 'nullable',
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
