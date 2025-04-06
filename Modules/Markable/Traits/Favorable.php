<?php

namespace Modules\Markable\Traits;

use Modules\Markable\Actions\MakeModelFavorable;
use Modules\Markable\Helpers\FavoriteHelper;

trait Favorable
{
    public function whereHasFavorites()
    {
        return $this->whereHas(FavoriteHelper::RELATIONSHIP_NAME, function ($query) {
            $query->whereUserId(auth()->id());
        });
    }

    public function withFavorites(): mixed
    {
        return $this->with([FavoriteHelper::RELATIONSHIP_NAME => function ($query) {
            $query->whereUserId(auth()->id());
        }]);
    }

    public function getFavorites(): static
    {
        return (new MakeModelFavorable)->handle($this);
    }

    public function withFavoritesCount(): static
    {
        return $this->withCount(FavoriteHelper::RELATIONSHIP_NAME);
    }
}
