<?php

namespace Modules\Auth\Http\Controllers;

use App\Traits\HttpResponse;
use Exception;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\Login\DashboardLoginRequest;
use Modules\Auth\Http\Requests\Login\MobileLoginRequest;
use Modules\Auth\Services\LoginService;
use Modules\Auth\Transformers\RefreshTokenResource;
use Modules\Auth\Transformers\SanctumTokenResource;
use Modules\Auth\Transformers\UserResource;

class LoginController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly LoginService $loginService) {}

    public function mobile(MobileLoginRequest $request)
    {
        $user = $this->loginService->mobile($request->validated());

        return $this->okResponse(array_merge([
            'user' => UserResource::make($user),
        ],
            SanctumTokenResource::make($user->tokens['token'])->toArray(request()),
            RefreshTokenResource::make($user->tokens['refresh_token'])->toArray(request())
        ), message: translate_word('logged_in'));
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
}
