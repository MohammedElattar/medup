<?php

namespace Modules\Review\Http\Controllers;

use App\Http\Requests\StatusRequest;
use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Review\Entities\Review;
use Modules\Review\Services\AdminReviewService;
use Modules\Review\Transformers\ReviewResource;

class AdminRatingController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly AdminReviewService $adminReviewService) {}

    public function index()
    {
        $reviews = $this->adminReviewService->index();

        return $this->paginatedResponse($reviews, ReviewResource::class);
    }

    public function destroy($id)
    {
        Review::query()->findOrFail($id)->delete();

        return $this->okResponse(message: translate_success_message('review', 'deleted_female'));
    }

    public function changePublic(StatusRequest $request, $id)
    {
        $this->adminReviewService->changePublic($request->status, $id);

        return $this->okResponse(message: translate_success_message('review', 'updated_female'));
    }
}
