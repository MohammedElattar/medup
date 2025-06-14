<?php

namespace Modules\Expert\Services;

use App\Models\Builders\UserBuilder;
use App\Models\User;
use Modules\Auth\Enums\UserTypeEnum;

class AdminExpertService
{
    public function index()
    {
        return User::query()
            ->where('type', '<>', UserTypeEnum::ADMIN)
            ->latest()
            ->when(true, fn(UserBuilder $b) => $b->withRelatedEntity())
            ->searchable(['name', 'email'])
            ->paginatedCollection();
    }
}
