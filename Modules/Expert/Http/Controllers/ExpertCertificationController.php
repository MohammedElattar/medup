<?php

namespace Modules\Expert\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Expert\Http\Requests\ExpertCertificationRequest;
use Modules\Expert\Services\ExpertCertificationService;
use Modules\Expert\Transformers\ExpertCertificationResource;

class ExpertCertificationController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly ExpertCertificationService $expertCertificationService)
    {
    }

    public function show()
    {
        $certificate = $this->expertCertificationService->show();

        return $this->resourceResponse($certificate ? ExpertCertificationResource::make($certificate) : null);
    }

    public function update(ExpertCertificationRequest $request)
    {
        $certificate = $this->expertCertificationService->update($request->validated());

        return $this->resourceResponse(ExpertCertificationResource::make($certificate));
    }
}
