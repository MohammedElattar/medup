<?php

namespace Modules\Auth\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cookie;
use Modules\Auth\Actions\LogoutUser;

class LogoutController extends Controller
{
    use HttpResponse;

    public function __invoke(LogoutUser $logoutUserAction): JsonResponse
    {
        $logoutUserAction->handle();

        return $this->okResponse(message: translate_word('user_logged_out'))->withCookie(Cookie::forget('isLoggedIn'));
    }

    public function dashboard(LogoutUser $logoutUserAction)
    {
        $logoutUserAction->handle();

        return redirect()->route('login');
    }
}
