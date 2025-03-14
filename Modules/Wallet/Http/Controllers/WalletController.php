<?php

namespace Modules\Wallet\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Wallet\Http\Requests\MoneyTransferRequest;
use Modules\Wallet\Http\Requests\ResetWalletRequest;
use Modules\Wallet\Http\Requests\WalletRequest;
use Modules\Wallet\Services\WalletService;
use Modules\Wallet\Transformers\WalletResource;
use Throwable;

class WalletController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly WalletService $walletService) {}

    public function show($userId = null)
    {
        $wallet = $this->walletService->show($userId);

        return $this->resourceResponse(WalletResource::make($wallet));
    }

    public function deposit(WalletRequest $request): JsonResponse
    {
        $this->walletService->deposit($request->amount);

        return $this->okResponse(message: translate_success_message('deposit', 'created'));
    }

    public function withdrawal(WalletRequest $request): JsonResponse
    {
        $this->walletService->withdrawal($request->amount);

        return $this->okResponse(message: translate_success_message('withdrawal', 'created'));
    }

    /**
     * @throws Throwable
     */
    public function transfer(MoneyTransferRequest $request): JsonResponse
    {
        $this->walletService->transfer(
            $request->from_user_id,
            $request->to_user_id,
            $request->amount,
            $request->description,
        );

        return $this->okResponse(message: translate_success_message('transfer', 'created'));
    }

    public function reset(ResetWalletRequest $request, $userId)
    {
        $this->walletService->reset($request->validated(), $userId);
    }
}
