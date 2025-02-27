<?php

namespace Modules\Comment\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Comment\Http\Requests\CommentFetchRequest;
use Modules\Comment\Http\Requests\CommentRequest;
use Modules\Comment\Services\PublicCommentService;
use Modules\Comment\Transformers\CommentResource;

class PublicCommentController extends Controller
{
    use HttpResponse;

    public function __construct(private PublicCommentService $publicCommentService)
    {
    }

    public function index(CommentFetchRequest $request)
    {
        $comments = $this->publicCommentService->index($request->validated());

        return $this->paginatedResponse($comments, CommentResource::class);
    }

    public function store(CommentRequest $request)
    {
        $comment = $this->publicCommentService->store($request->validated());

        return $this->createdResponse(CommentResource::make($comment), translate_success_message('comment', 'created'));
    }

    public function destroy($id)
    {
        $this->publicCommentService->destroy($id);

        return $this->okResponse(message: translate_success_message('comment', 'deleted'));
    }
}
