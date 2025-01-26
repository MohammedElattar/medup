<?php

namespace Modules\Category\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            ...ValidationRuleHelper::translatedArray(),
        ];
    }
}
