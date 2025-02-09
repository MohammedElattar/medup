<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use Modules\City\Models\City;
use Modules\College\Models\College;
use Modules\College\Transformers\CollegeResource;
use Modules\Country\Models\Country;
use Modules\Country\Transformers\CountryResource;
use Modules\Skill\Models\Skill;
use Modules\Speciality\Models\Speciality;
use Modules\Speciality\Transformers\SpecialityResource;

class SelectMenuController extends Controller
{
    use HttpResponse;

    public function countries()
    {
        return $this->resourceResponse(
            CountryResource::collection(
                Country::query()->latest()->select(['id', 'name'])->whereHas('cities')->get()
            )
        );
    }

    public function cities()
    {
       $countryId = request()->input('country_id');

       return $this->resourceResponse(
           CountryResource::collection(
               City::query()->latest()->select('id', 'name')->where('country_id', $countryId)->get()
           )
       );
    }

    public function skills()
    {
        return $this->resourceResponse(
            CountryResource::collection(
                Skill::query()->latest()->select(['id', 'name'])->withCount('experts')->get()
            )
        );
    }

    public function colleges()
    {
        return $this->resourceResponse(
            CollegeResource::collection(
                College::query()->whereHas('specialities')->latest()->select(['id', 'name'])->withCount('experts')->get()
            )
        );
    }

    public function specialities()
    {
        $collegeId = request()->input('college_id');

        return $this->resourceResponse(
            SpecialityResource::collection(
                Speciality::query()
                    ->latest()
                    ->when(!is_null($collegeId), fn($q) => $q->where('college_id', $collegeId))
                    ->withCount('experts')

                    ->get()
            )
        );
    }
}
