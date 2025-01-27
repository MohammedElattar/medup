<?php

namespace Modules\Skill\Http\Requests;

use App\Helpers\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
{
    public function rules(): array
    {
        $inUpdate = ! preg_match('/.*skills$/', $this->url());

        return array_merge(ValidationRuleHelper::translatedArray(), [
            'icon' => ValidationRuleHelper::storeOrUpdateImageRules($inUpdate),
        ]);
    }
}
