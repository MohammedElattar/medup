<?php

namespace Modules\Payment\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Payment\Http\Requests\BankAccountRequest;
use Modules\Payment\Services\BankAccountService;
use Modules\Payment\Transformers\BankAccountResource;

class BankAccountController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly BankAccountService $bankAccountService) {}

    public function index()
    {
        $bankAccounts = $this->bankAccountService->index();

        return $this->resourceResponse(BankAccountResource::collection($bankAccounts));
    }

    public function show($id)
    {
        $bankAccount = $this->bankAccountService->show($id);

        return $this->resourceResponse(new BankAccountResource($bankAccount));
    }

    public function store(BankAccountRequest $request)
    {
        $this->bankAccountService->store($request->validated());

        return $this->createdResponse(message: translate_success_message('bank_account', 'created'));
    }

    public function update(BankAccountRequest $request, $id)
    {
        $this->bankAccountService->update($request->validated(), $id);

        return $this->okResponse(message: translate_success_message('bank_account', 'updated'));
    }

    public function destroy($id)
    {
        $this->bankAccountService->destroy($id);

        return $this->okResponse(message: translate_success_message('bank_account', 'deleted'));
    }

    public function makeDefault($id)
    {
        $this->bankAccountService->makeDefault($id);

        return $this->okResponse(message: translate_success_message('bank_account', 'updated'));
    }
}
