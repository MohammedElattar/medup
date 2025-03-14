<?php

namespace Modules\Order\Helpers;

class OrderTranslationHelper
{
    public static function en()
    {
        return [
            'item_purchased_before' => 'You have already purchased this item.',
            'item_purchased' => 'You have successfully purchased this item.',
        ];
    }

    public static function ar()
    {
        return [
            'item_purchased_before' => 'لقد قمت بشراء هذا العنصر بالفعل.',
            'item_purchased' => 'لقد قمت بشراء هذا العنصر بنجاح.',
        ];
    }
}
