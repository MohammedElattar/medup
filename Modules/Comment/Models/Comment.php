<?php

namespace Modules\Comment\Models;

use App\Models\User;
use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Comment\Models\Builders\CommentBuilder;
use Modules\Markable\Entities\FavoriteModel;
use Modules\Markable\Traits\Markable;

class Comment extends Model
{
    use PaginationTrait, Searchable, Markable;

    protected $fillable = [
        'user_id',
        'replied_user_id',
        'content',
        'commentable_type',
        'commentable_id',
    ];

    protected static $marks = [
        FavoriteModel::class,
    ];

    public static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('valid_user', function($builder){
           $builder->whereHas('user');
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function repliedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'replied_user_id');
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function newEloquentBuilder($query): CommentBuilder
    {
        return new CommentBuilder($query);
    }
}
