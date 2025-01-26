<?php

namespace Modules\Auth\Strategies;

use App\Models\User;

interface Verifiable
{
    public function verifyCode($handle, $code);

    public function sendCode($handle);

    public function forgetPassword($handle);

    public function resetPassword($handle, $code, $newPassword);

    public function validateCode($handle, $code);

    public function sendPhoneCode(string $newPhone, ?User $user = null);

    public function updatePhone($code, array $data = [], ?User $user = null);

    public function generalSendOtp($handle, $type);
}
