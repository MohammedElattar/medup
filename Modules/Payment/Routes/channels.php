<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('payments.{paymentId}', function () {
    return true;
});