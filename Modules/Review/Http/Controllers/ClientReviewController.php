<?php

namespace Modules\Review\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Review\Services\ClientReviewService;
use Modules\Review\Transformers\ReviewResource;

class ClientReviewController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly ClientReviewService $clientReviewService) {}

    public function index()
    {
        $reviews = $this->clientReviewService->index();

        return $this->paginatedResponse($reviews, ReviewResource::class);
    }
}
