<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Auth\Helpers\UserTypeHelper;
use Modules\Auth\Traits\VerificationBuilderTrait;
use Modules\Expert\Models\Builders\ExpertBuilder;
use Modules\Wallet\Traits\Transafable;

class UserBuilder extends Builder
{
    use VerificationBuilderTrait, Transafable;

    public function loginByType(array $data, bool $inMobile)
    {
        if ($inMobile) {
            return $this
                ->whereIn('type', UserTypeHelper::mobileTypes())
                ->whereNotNull('email')
                ->where('email', $data['email']);
        }

        return $this
            ->whereNotNull('email')
            ->where('email', $data['email'])
            ->whereIn('type', UserTypeHelper::nonMobileTypes());
    }

    public function withMinimalSelectedColumns(array $excludeColumns = [], array $additionalColumns = []): UserBuilder
    {
        $columns = array_diff([
            'users.id',
            'users.first_name',
            'users.middle_name',
            'users.name',
        ], array_map(fn($column) => "users.$column", $excludeColumns));

        return $this->select([...$columns, ...$additionalColumns]);
    }

    public function withConditionalAvatar(bool $withAvatar = true)
    {
        return $this->when($withAvatar, fn(self $q) => $q->with('avatar'));
    }

    public function withMinimalDetails(bool $withAvatar = true, array $excludeColumns = [], array $additionalColumns = [])
    {
        return $this
            ->withMinimalSelectedColumns($excludeColumns, $additionalColumns)
            ->withConditionalAvatar($withAvatar);
    }

    public function whereIsAdmin(): UserBuilder
    {
        return $this->where('type', UserTypeEnum::ADMIN);
    }

    public function whereActive(): UserBuilder
    {
        return $this->where('status', true);
    }

    public function withRelatedEntity()
    {
        return $this->with([
            'expert' => fn(ExpertBuilder|HasOne $q) => $q->withSpecialityDetails()->select(['id', 'user_id', 'speciality_id']),
            'student.speciality.college',
        ]);
    }
}
