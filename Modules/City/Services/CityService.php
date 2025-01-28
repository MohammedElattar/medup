<?php

namespace Modules\City\Services;

use App\Exceptions\ValidationErrorsException;
use Modules\City\Models\City;
use Modules\Country\Services\CountryService;

class CityService
{
    public function __construct(private readonly CountryService $countryService) {}

    public function index($countryId)
    {
        return City::query()
            ->where('country_id', $countryId)
            ->latest()
            ->paginatedCollection();
    }

    public function show($countryId, $id)
    {
        return City::query()
            ->where('country_id', $countryId)
            ->findOrFail($id);
    }

    public function store(array $data, $countryId)
    {
        $this->countryService->exists($countryId);

        City::query()->create($data + ['country_id' => $countryId]);
    }

    public function update(array $data, $countryId, $id)
    {
        $this->countryService->exists($countryId);

        City::query()->where('country_id', $countryId)->findOrFail($id)->update($data);
    }

    public function destroy($countryId, $id)
    {
        City::query()->where('country_id', $countryId)->findOrFail($id)->delete();
    }

    public function exists(int $id, string $errorKey = 'city_id')
    {
        $city = City::query()->find($id);

        if(! $city) {
            throw new ValidationErrorsException([
                $errorKey => translate_error_message('city', 'not_exists')
            ]);
        }

        return $city;
    }
}
