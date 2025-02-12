<?php

namespace Modules\Expert\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class ExpertExperienceBuilder extends Builder
{
    public function withMinimalDetailsForExpert()
    {
        return $this->withCityDetails();
    }

    public function withMinimalDetailsForPublic(): ExpertExperienceBuilder
    {
        return $this->withMinimalDetailsForExpert();
    }

    public function withCityDetails()
    {
        return $this->with([
            'city.country:id,name'
        ]);
    }
}
