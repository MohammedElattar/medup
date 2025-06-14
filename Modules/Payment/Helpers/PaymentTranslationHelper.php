<?php

namespace Modules\Payment\Helpers;

class PaymentTranslationHelper
{
    public static function en()
    {
        return [
            'unknown_payment_method' => 'Unknown payment method',
            'unknown_payment_gateway' => 'Unknown payment gateway',
            'bank_account' => 'Bank account',
            'iban' => 'IBAN',
            'account_number' => 'Account number',
            'not_enough_balance' => 'You don\'t have enough balance, please recharge first and try again',
            'not_implemented_payment_method' => 'Payment method not implemented',
            'DECLINED' => 'Your payment has expired',
            'UNPAID' => 'Your payment is not paid yet',
        ];
    }

    public static function ar()
    {
        return [
            'unknown_payment_method' => 'وسيله دفع غير معروفة',
            'unknown_payment_gateway' => 'بوابة دفع غير معروفة',
            'bank_account' => 'الحساب البنكي',
            'iban' => 'الرقم الدولي للحساب المصرفي',
            'account_number' => 'رقم الحساب',
            'not_enough_balance' => 'ليس لديك رصيد كافي، يرجي اعاده الشحن والمحاوله مره اخري',
            'not_implemented_payment_method' => 'وسيلة الدفع غير مدعومة',
            'DECLINED' => 'انتهت صلاحية الدفع الخاص بك',
            'UNPAID' => 'لم يتم دفع الدفعة الخاصة بك بعد',
        ];
    }

    public static function ku()
    {
        return [
            'unknown_payment_method' => 'شێوازی پارەدانی نەناسراو',
            'unknown_payment_gateway' => 'دەروازەی پارەدانی نەناسراو',
            'bank_account' => 'هەژماری بانک',
            'iban' => 'ژمارەی بانکی نیشانی جیهانی',
            'account_number' => 'ژمارەی هەژمار',
            'not_enough_balance' => 'تۆ رێژەی پارەی کافی نییە، تکایە پێشتر پارە بنێرە و دووبارە هەوڵ بدەرەوە',
        ];
    }
}
