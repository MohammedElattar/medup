<?php

namespace Modules\Library\Traits;

use App\Models\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Expert\Models\Builders\ExpertBuilder;
use Modules\Library\Models\Builders\LibraryBuilder;

trait CommonLibraryEloquent
{
    public function withCover(): static
    {
        return $this->with('cover');
    }

    public function withExpertDetails(): static
    {
        return $this->with([
            'expert:id,user_id,is_premium,city_id,speciality_id',
            'expert' => fn(ExpertBuilder|BelongsTo $b) => $b->withCityDetails(),
            'expert.user' => fn(UserBuilder|BelongsTo $b) => $b->withMinimalDetails(false, ['type', 'status'])
        ]);
    }

    public function withMinimalExpertDetails(): static
    {
        return $this->with([
            'expert:id,user_id',
            'expert.user' => fn(UserBuilder|BelongsTo $b) => $b->withMinimalDetails(false)
        ]);
    }

    public function withSpecialityDetails(): static
    {
        return $this->with('speciality.college:id,name');
    }
}
