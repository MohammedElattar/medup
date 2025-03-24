<?php

namespace Modules\Markable\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Incenteev\EmojiPattern\EmojiPattern;

class EmojiRule implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $emojiRegexp = '/'.EmojiPattern::getEmojiPattern().'/u';
        $matches = [];
        preg_match($emojiRegexp, $value, $matches);

        dd($matches);
    }
}
