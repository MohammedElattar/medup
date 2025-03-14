<?php

namespace Modules\Wallet\Exceptions;

use App\Exceptions\BaseExceptionClass;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class WalletException extends BaseExceptionClass
{
    /**
     * @throws WalletException
     */
    public static function userWalletNotExists(?User $user = null)
    {
        $user = $user ?: auth()->user();

        throw new self(translate_word('user_has_no_wallet', [
            'name' => $user->name,
        ]),
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @throws WalletException
     */
    public static function notEnoughBalance(float|int $amount)
    {
        throw new self(translate_word('does_not_have_enough_balance', [
            'amount' => $amount,
        ]),
            Response::HTTP_BAD_REQUEST
        );
    }
}
