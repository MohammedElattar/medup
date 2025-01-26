<?php

namespace Modules\Vendor\Helpers;

use Modules\Vendor\Exceptions\VendorException;

class VendorHelper
{
    public static function getUserVendor($user = null)
    {
        $user = $user ?: auth()->user();
        $vendor = $user->vendor;

        if(! $vendor) {
            VendorException::notExists();
        }

        return $vendor;
    }
}