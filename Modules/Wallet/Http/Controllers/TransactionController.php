<?php

namespace Modules\Wallet\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Wallet\Services\TransactionService;
use Modules\Wallet\Transformers\TransactionResource;

class TransactionController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly TransactionService $transactionService) {}

    public function index($userId = null): JsonResponse
    {
        $userId = $userId ?: auth()->id();
        $transactions = $this->transactionService->index($userId);

        return $this->paginatedResponse($transactions, TransactionResource::class);
    }
}
