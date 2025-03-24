<?php

namespace Modules\Subscription\Helpers;

class SubscriptionTranslationHelper
{
    public static function en()
    {
        return [
            'subscription' => 'Subscription',
            'subscription_created' => 'Your subscription has been created successfully',
            'subscription_canceled' => 'Your subscription has been canceled',
        ];
    }

    public static function ar()
    {
        return [
            'subscription' => 'الإشتراك',
            'subscription_created' => 'تم إنشاء إشتراكك بنجاح',
            'subscription_canceled' => 'تم إلغاء إشتراكك',
        ];
    }
}
