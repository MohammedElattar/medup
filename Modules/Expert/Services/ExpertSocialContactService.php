<?php

namespace Modules\Expert\Services;

use Modules\Expert\Traits\ExpertSetter;

class ExpertSocialContactService
{
    use ExpertSetter;

    public function update(array $data)
    {
        $expert = $this->getExpert();
        $expert->socialContacts()->updateOrCreate(
            ['expert_id' => $expert->id],
            $data
        );
    }
}
