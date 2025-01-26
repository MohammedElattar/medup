<?php

namespace Modules\Auth\Http\Controllers;

use App\Traits\HttpResponse;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Enums\VerifyTokenTypeEnum;
use Modules\Auth\Http\Requests\CodeSendRequest;
use Modules\Auth\Http\Requests\Login\DashboardLoginRequest;
use Modules\Auth\Http\Requests\Login\MobileLoginRequest;
use Modules\Auth\Services\LoginService;
use Modules\Auth\Strategies\Verifiable;
use Modules\Auth\Transformers\UserResource;

class LoginController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly LoginService $loginService) {}

    public function mobile(MobileLoginRequest $request)
    {
        $user = $this->loginService->mobile($request->validated());

        return $this->okResponse(UserResource::make($user), message: translate_word('logged_in'))->withCookie(Cookie::make(
            'isLoggedIn',
            'true',
            config('session.lifetime'),
            httpOnly: false,
        ));
    }

    public function show()
    {
      $pageConfigs = ['myLayout' => 'blank'];

      return view('auth::login', ['pageConfigs' => $pageConfigs]);
    }

    public function dashboard(DashboardLoginRequest $request)
    {
      $data = $request->validated();

      try {
        $user = $this->loginService->dashboard($data);
      } catch (Exception $e) {
        return redirect()->route('login')->withInput($data)->withErrors(['error' => $e->getMessage()]);
      }

      session()->put('user', $user);

      return redirect()->route('dashboard-ecommerce');
    }

    public function loginOtp(CodeSendRequest $request, Verifiable $verifiable)
    {
        DB::transaction(fn () => $verifiable->generalSendOtp($request->handle, VerifyTokenTypeEnum::LOGIN));

        return $this->okResponse(message: translate_word('resend_verify_code'));
    }
}
