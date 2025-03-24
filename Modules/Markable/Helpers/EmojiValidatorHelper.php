<?php

namespace Modules\Markable\Helpers;

use Illuminate\Http\Request;

class EmojiValidatorHelper
{
    public static function mergeOneValidEmoji(Request $request): void
    {
        $inputs = $request->all();
        $emojiRegexp = '/'.EmojiPatternHelper::getEmojiPattern().'/u';
        $matches = [];
        preg_match($emojiRegexp, $request->value, $matches);

        if (empty($matches)) {
            unset($inputs['value']);
        } else {
            $inputs['value'] = $matches[0];
        }

        $request->replace($inputs);
    }
}
