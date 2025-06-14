<?php

namespace Modules\Payment\Enums;

enum PaymentMethodEnum
{
    const CASH_ON_DELIVERY = 0;
    const ONLINE = 1;
    const CARD = 2;

    public static function toArray(): array
    {
        return [
            self::CASH_ON_DELIVERY,
            self::ONLINE,
        ];
    }

    public static function isOnlineMethod($method)
    {
        return $method != self::CASH_ON_DELIVERY;
    }
}
