<?php

namespace Modules\Wallet\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;

class ClientWalletController extends Controller
{
    use HttpResponse;

    public function show($clientId) {}
}
