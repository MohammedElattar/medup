<?php

namespace Modules\Wallet\Http\Requests;

use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest
{
    use HttpResponse;

    public function rules()
    {
        return [
            //
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
