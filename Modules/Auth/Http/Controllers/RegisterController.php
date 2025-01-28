<?php

namespace Modules\Auth\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Auth\Actions\Register\ExpertRegisterAction;
use Modules\Auth\Actions\Register\StudentRegisterAction;
use Modules\Auth\Http\Requests\Register\ExpertRegisterRequest;
use Modules\Auth\Http\Requests\Register\StudentRegisterRequest;
use Modules\Auth\Strategies\Verifiable;

class RegisterController extends Controller
{
    use HttpResponse;

    public function expert(ExpertRegisterRequest $request, ExpertRegisterAction $expertRegisterAction)
    {
        $expertRegisterAction->handle($request->validated(), app(Verifiable::class));

        return $this->createdResponse(
            message: translate_success_message('user', 'created')
            .' '.translate_word('user_verification_sent')
        );
    }

    public function student(StudentRegisterRequest $request, StudentRegisterAction $action)
    {
       $action->handle($request->validated(), app(Verifiable::class));

         return $this->createdResponse(
              message: translate_success_message('user', 'created')
              .' '.translate_word('user_verification_sent')
         );
    }
}
