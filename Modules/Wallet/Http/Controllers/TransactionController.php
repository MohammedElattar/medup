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

    public function index()
    {
        $transactions = $this->transactionService->index();

        return view('wallet::index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = $this->transactionService->show($id);

        return view('wallet::show', compact('transaction'));
    }
}
