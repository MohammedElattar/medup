<?php

namespace Modules\College\Services;

use Modules\College\Models\College;

class PublicCollegeService
{
    public function collegesWithBestExpert()
    {
        return cache()->rememberForever('colleges_with_best_expert', function(){
            return College::query()
                ->with('icon')
                ->latest()
                ->withCount('experts')
                ->get();
        });
    }
}
