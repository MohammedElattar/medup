<?php

namespace Modules\Comment\Services;

use Modules\Comment\Models\Builders\CommentBuilder;
use Modules\Comment\Models\Comment;

class AdminCommentService
{
    public function index($types)
    {
        return Comment::query()
            ->latest()
            ->where(PublicCommentService::getMorph($types))
            ->when(true, fn(CommentBuilder $b) => $b->withDetails())
            ->where(function($q){
                $q
                    ->searchable(['content'])
                    ->searchByRelation('user', ['name'], orWhere: true);
            })
            ->paginatedCollection();
    }
}
