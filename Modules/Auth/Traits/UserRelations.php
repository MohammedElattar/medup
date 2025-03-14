<?php

namespace Modules\Auth\Traits;

use App\Helpers\MediaHelper;
use Modules\Auth\Enums\AuthEnum;
use Modules\Expert\Models\Expert;
use Modules\Student\Models\Student;
use Modules\Wallet\Entities\Wallet;

trait UserRelations
{
    public function avatar()
    {
        return MediaHelper::mediaRelationship($this, AuthEnum::AVATAR_COLLECTION_NAME);
    }

    public function expert()
    {
        return $this->hasOne(Expert::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
}
