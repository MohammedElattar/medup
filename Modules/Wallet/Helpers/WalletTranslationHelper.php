<?php

namespace Modules\Wallet\Helpers;

class WalletTranslationHelper
{
    public static function en(): array
    {
        return [
            'transaction_failed' => 'Transaction failed',
            'deposit' => 'Deposit',
            'withdrawal' => 'Withdrawal',
            'user_has_no_wallet' => 'User has no wallet',
            'does_not_have_enough_balance' => 'User does not have :amount in his wallet',
            'money_sender' => 'Money sender',
            'money_receiver' => 'Money receiver',
            'transfer' => 'Money Transfer',
            'transferring_to_the_same_user' => 'Cannot transfer money to yourself',
            'money_transfer' => 'Money transfer',
        ];
    }

    public static function ar(): array
    {
        return [
            'transaction_failed' => 'فشل التحويل',
            'deposit' => 'الأيداع',
            'withdrawal' => 'السحب',
            'user_has_no_wallet' => 'المستخدم ليس لديه محفظة',
            'does_not_have_enough_balance' => 'المستخدم ليس لديه :amount في محفظته',
            'money_sender' => 'مرسل الأموال',
            'money_receiver' => 'مستقبل الاموال',
            'transfer' => 'تحويل الأموال',
            'transferring_to_the_same_user' => '',
            'money_transfer' => 'تحويل الأموال',
        ];
    }

    public static function fr(): array
    {
        return [
            'transaction_failed' => 'Transaction échouée',
            'deposit' => 'Dépôt',
            'withdrawal' => 'Retrait',
            'user_has_no_wallet' => 'L\'utilisateur :name n\'a pas de portefeuille',
            'does_not_have_enough_balance' => 'L\'utilisateur n\'a pas :amount dans son portefeuille',
            'money_sender' => 'Expéditeur d\'argent',
            'money_receiver' => 'Récepteur d\'argent',
            'transfer' => 'Transfert d\'argent',
            'transferring_to_the_same_user' => 'Impossible de transférer de l\'argent au même utilisateur',
            'money_transfer' => 'Transfert d\'argent',
        ];
    }

    public static function ku(): array
    {
        return [
            'transaction_failed' => 'کارەکە شکستی هات',
            'deposit' => 'دانان',
            'withdrawal' => 'بیروانی',
            'user_has_no_wallet' => 'بەکارهێنەر :name کۆشکێک نییە',
            'does_not_have_enough_balance' => 'بەکارهێنەر :amount لە کۆشکی خۆی نییە',
            'money_sender' => 'ناردنی پارە',
            'money_receiver' => 'وەرگرتنی پارە',
            'transfer' => 'ناردنی پارە',
            'transferring_to_the_same_user' => 'ناتوانێت پارە ناردەکە بۆ هەمان بەکارهێنەرە',
            'money_transfer' => 'ناردنی پارە',
        ];
    }
}
