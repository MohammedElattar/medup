<?php

namespace Modules\Auth\Http\Controllers;

use App\Exceptions\ValidationErrorsException;
use App\Helpers\ToastHelper;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Modules\Auth\Enums\AuthEnum;
use Modules\Auth\Http\Requests\ProfileRequest;
use Modules\Auth\Http\Requests\UpdateLocaleRequest;
use Modules\Auth\Services\ProfileService;
use Modules\Auth\Transformers\UserResource;

class ProfileController extends Controller
{
    use HttpResponse;

    public static function getUsersCollectionName(): string
    {
        return AuthEnum::AVATAR_COLLECTION_NAME;
    }

    public function handle(ProfileRequest $request, ProfileService $profileService)
    {
        try {
            $profileService->handle($request->validated());

            ToastHelper::successToast();

            return redirect()->route('profile.show');
        } catch (ValidationErrorsException $e) {
            return redirect()->back()->withErrors($e->getErrors());
        }
    }

    public function publicHandle(ProfileRequest $request, ProfileService $profileService): JsonResponse
    {
        $result = $profileService->handle($request->validated());

        $msg = translate_success_message('profile', 'updated');

        if (isset($result['verified'])) {
            $msg .= ' and sms verification sent';
        }

        if (is_bool($result) || isset($result['verified'])) {
            return $this->okResponse(message: $msg);
        }

        return $this->validationErrorsResponse($result);
    }


    public function show()
    {
        $loggedUserInfo = User::whereId(auth()->id())->with(['avatar'])->first();

        return $this->resourceResponse(new UserResource($loggedUserInfo));
    }

    public function updateLocale(UpdateLocaleRequest $request): JsonResponse
    {
        auth()->user()->forceFill($request->validated())->save();

        return $this->okResponse(message: translate_success_message('profile', 'updated'), showToast: false);
    }

    public function updateDashboardLocale($locale): RedirectResponse
    {
        auth()->user()->forceFill(['locale' => $locale])->save();
        session()->put('locale', $locale);
        App::setLocale($locale);

        return redirect()->back();
    }

    public function showView()
    {
        $user = User::whereId(auth()->id())->with(['avatar'])->first();

        return view('auth::profile', compact('user'));
    }
}
