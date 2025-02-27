<?php

namespace Modules\Comment\Services;

use App\Exceptions\ValidationErrorsException;
use App\Models\User;
use Modules\Collaborate\Models\Collaborate;
use Modules\Comment\Models\Builders\CommentBuilder;
use Modules\Comment\Models\Comment;
use Modules\Idea\Models\Idea;

class PublicCommentService
{
    public static array $allowedTypes = [
        'collaborate' => Collaborate::class,
        'idea' => Idea::class,
    ];

    public static array $flippedTypes = [
        Collaborate::class, 'collaborate',
        Idea::class, 'idea',
    ];
    public static array $hasStatus = [
        'idea' => true,
        'collaborate' => true,
    ];

    public function index(array $types)
    {
        return Comment::query()
            ->where(self::getMorph($types))
            ->when(true, fn(CommentBuilder $b) => $b->withDetails())
            ->latest()
            ->paginatedCollection();
    }

    public function show($id)
    {
        return Comment::query()
            ->where('id', $id)
            ->when(true, fn(CommentBuilder $b) => $b->withDetails())
            ->firstOrFail();
    }

    /**
     * @throws ValidationErrorsException
     */
    public function store(array $data)
    {
        if(isset($data['replied_user_id'])) {
            $repliedUser = User::query()->find($data['replied_user_id']);

            if(! $repliedUser) {
                throw new ValidationErrorsException([
                    'replied_user_id' => translate_error_message('user', 'not_exists'),
                ]);
            }
        }

        $model = self::$allowedTypes[$data['type']]::query()
            ->when(
                isset(self::$hasStatus[$data['type']]) && self::$hasStatus[$data['type']],
                fn($q) => $q->where('status', true)
            )
            ->find($data['commentable_id']);

        if(! $model) {
            throw new ValidationErrorsException([
                'commentable_id' => translate_error_message('model', 'not_exists'),
            ]);
        }

        $comment = Comment::query()->create($data + self::getMorph($data) + [
            'user_id' => auth()->id()
        ]);

        return $this->show($comment->id);
    }

    public function destroy($id)
    {
        Comment::query()->where('user_id', auth()->id())->findOrFail($id)->delete();
    }

    public static function getMorph(array $data)
    {
        return ['commentable_type' => self::$allowedTypes[$data['type']], 'commentable_id' => $data['commentable_id']];
    }
}
