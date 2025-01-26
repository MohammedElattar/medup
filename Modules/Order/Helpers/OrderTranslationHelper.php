<?php

namespace Modules\Order\Helpers;

class OrderTranslationHelper
{
    public static function en()
    {
        return [
            'order' => 'Order',
            'not_enough_quantity' => 'There is not enough quantity for this product',
            'price_is_invalid' => 'New price cannot be less than the original price',
        ];
    }

    public static function ar()
    {
        return [
            'order' => 'الطلب',
            'not_enough_quantity' => 'لا يوجد كمية كافية لهذا المنتج',
            'price_is_invalid' => 'لا يمكن أن يكون السعر الجديد أقل من السعر الأصلي',
        ];
    }
}
