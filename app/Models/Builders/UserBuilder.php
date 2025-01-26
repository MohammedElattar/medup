<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Auth\Helpers\UserTypeHelper;
use Modules\Auth\Traits\VerificationBuilderTrait;

class UserBuilder extends Builder
{
    use VerificationBuilderTrait;

    public function loginByType(array $data, bool $inMobile)
    {
        if ($inMobile) {
            return $this->where('type', UserTypeEnum::VENDOR)->whereNotNull('email')->where('email', $data['email'])->whereIn('type', UserTypeHelper::mobileTypes());
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
            'users.name',
        ], array_map(fn ($column) => "users.$column", $excludeColumns));

        return $this->select([...$columns, ...$additionalColumns]);
    }

    public function withConditionalAvatar(bool $withAvatar = true)
    {
        return $this->when($withAvatar, fn (self $q) => $q->with('avatar'));
    }

    public function withMinimalDetails(bool $withAvatar = true, array $excludeColumns = [], array $additionalColumns = [])
    {
        return $this
            ->withMinimalSelectedColumns($excludeColumns, $additionalColumns)
            ->withConditionalAvatar($withAvatar);
    }

    public function whereIsAdmin()
    {
        return $this->where('type', UserTypeEnum::ADMIN);
    }
}
