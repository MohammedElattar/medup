<?php

namespace Modules\Payment\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Auth\Helpers\UserHelper;
use Modules\Payment\Services\BankAccountService;
use Modules\Payment\Transformers\BankAccountResource;

class AdminBankAccountController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly BankAccountService $bankAccountService) {}

    public function index($userId)
    {
        $bankAccounts = $this->bankAccountService->setUser(UserHelper::getUserById($userId))->index();

        return $this->resourceResponse(BankAccountResource::collection($bankAccounts));
    }

    public function show($userId, $id)
    {
        $bankAccount = $this->bankAccountService->setUser(UserHelper::getUserById($userId))->show($id);

        return $this->resourceResponse(new BankAccountResource($bankAccount));
    }
}
