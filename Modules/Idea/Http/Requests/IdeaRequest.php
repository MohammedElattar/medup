<?php

namespace Modules\Idea\Http\Requests;

use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Collaborate\Http\Requests\CollaborateRequest;

class IdeaRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            ...CollaborateRequest::baseRules(),
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
