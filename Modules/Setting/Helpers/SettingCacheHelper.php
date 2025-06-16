<?php

namespace Modules\Setting\Helpers;

use Modules\Setting\Models\Setting;

class SettingCacheHelper
{
    public static function get()
    {
        if (! cache()->has('settings')) {
            cache()->forever('settings', Setting::firstOrFail());
        }

        return cache()->get('settings');
    }

    public static function set(Setting $item)
    {
        cache()->forget('settings');
        cache()->forever('settings', $item);
    }

    public static function getSubscriptionPrice()
    {
        return self::get()->subscription_price;
    }
}
