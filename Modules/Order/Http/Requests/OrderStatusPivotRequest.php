<?php

namespace Modules\Order\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use App\Traits\HttpResponse;
use Illuminate\Foundation\Http\FormRequest;

class OrderStatusPivotRequest extends FormRequest
{
    use HttpResponse;

    public function rules(): array
    {
        return [
            'status_id' => ValidationRuleHelper::foreignKeyRules(),
            'description' => ValidationRuleHelper::longTextRules([
                'required' => 'nullable',
            ]),
        ];
    }
}
