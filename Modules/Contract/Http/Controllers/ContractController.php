<?php

namespace Modules\Contract\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Modules\Contract\Http\Requests\ContractRequest;
use Modules\Contract\Services\ContractService;
use Modules\Contract\Transformers\ContractResource;

class ContractController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly ContractService $contractService) {}

    public function index()
    {
        $contracts = $this->contractService->index();

        return $this->resourceResponse(ContractResource::collection($contracts));
    }

    public function show($id)
    {
        $contract = $this->contractService->show($id);

        return $this->resourceResponse(ContractResource::make($contract));
    }

    public function sync(ContractRequest $request)
    {
        $this->contractService->sync($request->validated());

        return $this->okResponse();
    }
}
