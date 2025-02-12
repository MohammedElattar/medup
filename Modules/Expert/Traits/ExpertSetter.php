<?php

namespace Modules\Expert\Traits;

use Modules\Expert\Helpers\ExpertHelper;
use Modules\Expert\Models\Expert;

trait ExpertSetter
{
    private ?Expert $expert = null;

    public function setExpert(Expert $expert): static
    {
        $this->expert = $expert;

        return $this;
    }

    public function getExpert()
    {
        return $this->expert ?: ExpertHelper::getUserExpert();
    }
}
