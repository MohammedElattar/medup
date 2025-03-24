<?php

use App\Exceptions\InternalServerErrorException;
use App\Exceptions\ValidationErrorsException;
use App\Helpers\FlasherHelper;
use App\Http\Middleware\AccountMustBeActive;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\MustBeVerified;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\SetDefaultLocale;
use App\Http\Middleware\TrustProxies;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Helpers\AuthExceptionHelper;
use Modules\Auth\Http\Middleware\CheckUserType;
use Modules\Expert\Helpers\ExpertExceptionHelper;
use Modules\Wallet\Helpers\WalletExceptionHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
//    ->withBroadcasting(
//        __DIR__.'/../routes/channels.php',
//        ['prefix' => 'api', 'middleware' => ['api', GeneralHelper::authMiddleware()]],
//    )
    ->withMiddleware(function (Middleware $middleware) {
        //        $middleware->statefulApi();
        $middleware->append([
            SetDefaultLocale::class,
            //            AlwaysAcceptJson::class,
        ]);

        $middleware->api([
            'throttle:api',
        ]);

        $middleware->use([
            TrustProxies::class,
            HandleCors::class,
            PreventRequestsDuringMaintenance::class,
            ValidatePostSize::class,
            TrimStrings::class,
            ConvertEmptyStringsToNull::class,
        ]);

        $middleware->alias([
            'auth' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
            'account_must_be_active' => AccountMustBeActive::class,
            'must_be_verified' => MustBeVerified::class,
            'user_type_in' => CheckUserType::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        AuthExceptionHelper::handle($exceptions);

        $httpResponse = (new class
        {
            use \App\Traits\HttpResponse;
        });

        $exceptions->render(function (ValidationException $e, Request $req) {
            if ($req->acceptsJson() ||
                ($req->hasHeader('show-toast') && ! $req->header('show-toast'))
            ) {
                return;
            }

            foreach ($e->errors() as $field => $errors) {
                $translatedKey = translate_ui(str_replace('.', '_', $field));
                flash()
                    ->options([
                        'position' => 'bottom-center',
                    ])
                    ->error("$translatedKey : $errors[0]");
                break;
            }
        });


        $exceptions->renderable(function (ValidationErrorsException $e) use ($httpResponse) {
            return $httpResponse->validationErrorsResponse($e->getErrors());
        });

        $exceptions->renderable(function (InternalServerErrorException $e) use ($httpResponse) {
            return $httpResponse->errorResponse(message: $e->getMessage());
        });

        $exceptions->renderable(function (NotFoundHttpException $e, $req) use ($httpResponse) {
            $msg = $e->getMessage();

            if (Str::contains($msg, 'No query', true)) {
                $msg = translate_word('record_not_found');
            }

            return $httpResponse->errorResponse(null, Response::HTTP_NOT_FOUND, $msg);
        });

        $exceptions->renderable(function (MethodNotAllowedHttpException $e, $request) use ($httpResponse) {
            return $httpResponse->errorResponse(
                null,
                Response::HTTP_METHOD_NOT_ALLOWED,
                $e->getMessage()
            );
        });

        // Too Many Requests
        $exceptions->renderable(function (ThrottleRequestsException $e, $request) use ($httpResponse) {
            return $httpResponse->errorResponse(
                null,
                Response::HTTP_TOO_MANY_REQUESTS,
                translate_word('rate_limit_exceeded'),
            );
        });

        $exceptions->renderable(function (HttpException $e) use ($httpResponse) {
            if ($e->getMessage() == 'Service Unavailable') {
                return $httpResponse->errorResponse(code: $e->getStatusCode(), message: translate_word('maintenance_mode'));
            }

            return $httpResponse->errorResponse(code: $e->getStatusCode(), message: $e->getMessage());
        });

        AuthExceptionHelper::handle($exceptions);
        ExpertExceptionHelper::handle($exceptions);
        WalletExceptionHelper::handle($exceptions);
        \Modules\Order\Helpers\OrderExceptionHelper::handle($exceptions);
        \Modules\Chat\Helpers\ConversationExceptionHelper::handle($exceptions);
    })
    ->create();
