<?php

namespace Modules\Expert\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Modules\Expert\Http\Requests\ExpertRequest;
use Modules\Expert\Services\ExpertService;
use Modules\Expert\Transformers\ExpertResource;

class ExpertController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly ExpertService $expertService)
    {
    }

    public function show()
    {
        $expert = $this->expertService->show();

        return $this->resourceResponse(ExpertResource::make($expert));
    }

    public function update(ExpertRequest $request)
    {
        $expert = $this->expertService->update($request->validated());

        return $this->okResponse(ExpertResource::make($expert), translate_success_message('expert', 'updated'));
    }
}
