<?php

namespace Modules\Comment\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Modules\Comment\Services\PublicCommentService;

class CommentFetchRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
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
