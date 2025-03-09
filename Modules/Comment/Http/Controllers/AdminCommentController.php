<?php

namespace Modules\Comment\Http\Controllers;

use App\Helpers\FlasherHelper;
use Illuminate\Routing\Controller;
use Modules\Collaborate\Models\Collaborate;
use Modules\Comment\Http\Requests\CommentFetchRequest;
use Modules\Comment\Models\Comment;
use Modules\Comment\Services\AdminCommentService;
use Modules\Comment\Services\PublicCommentService;

class AdminCommentController extends Controller
{
    public function __construct(private AdminCommentService $adminCommentService)
    {
    }

    public function index(CommentFetchRequest $request)
    {
        $comments = $this->adminCommentService->index($request->validated());

        return view('comment::index', compact('comments'));
    }

    public function show($id)
    {
        $comment = Comment::query()->findOrFail($id);

        return view('comment::show', compact('comment'));
    }

    public function destroy($id)
    {
        $params = [];
        $comment = Comment::query()->findOrFail($id);

        $params['type'] = $comment->commentable_type == Collaborate::class ? 'collaborate' : 'idea';
        $params['commentable_id'] = $comment->commentable_id;
        $comment->delete();

        FlasherHelper::success(translate_success_message('comment', 'deleted'));

        return redirect()->route('comments.index', $params);
    }
}
