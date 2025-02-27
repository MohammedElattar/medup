<?php

namespace Modules\Comment\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Modules\Comment\Services\PublicCommentService;

class CommentRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            'replied_user_id' => ValidationRuleHelper::foreignKeyRules([
                'required' => 'nullable',
            ]),
            'content' => ValidationRuleHelper::longTextRules(),
            'type' => ValidationRuleHelper::enumRules(array_keys(PublicCommentService::$allowedTypes)),
            'commentable_id' => ValidationRuleHelper::foreignKeyRules(),
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
