<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Modules\City\Models\City;
use Modules\College\Models\College;
use Modules\Country\Models\Country;
use Modules\Country\Transformers\CountryResource;
use Modules\Skill\Models\Skill;
use Modules\Speciality\Models\Speciality;

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
                Skill::query()->latest()->select(['id', 'name'])->get()
            )
        );
    }

    public function colleges()
    {
        return $this->resourceResponse(
            CountryResource::collection(
                College::query()->whereHas('specialities')->latest()->select(['id', 'name'])->get()
            )
        );
    }

    public function specialities()
    {
        $collegeId = request()->input('college_id');

        return $this->resourceResponse(
            CountryResource::collection(
                Speciality::query()->latest()->where('college_id', $collegeId)->select(['id', 'name'])->get()
            )
        );
    }
}
