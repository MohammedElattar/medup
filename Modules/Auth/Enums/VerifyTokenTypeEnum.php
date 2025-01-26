<?php

namespace Modules\Auth\Enums;

enum VerifyTokenTypeEnum
{
    const VERIFICATION = 0;

    const PASSWORD_RESET = 1;

    const LOGIN = 2;

    const UPDATE_PHONE_NUMBER = 3;
}
