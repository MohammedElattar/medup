<?php

namespace Modules\Country\Services;

use App\Exceptions\ValidationErrorsException;
use Modules\Country\Models\Country;

class CountryService
{
    public function index()
    {
        return Country::query()->latest()->paginatedCollection();
    }

    public function show($id)
    {
        return Country::query()->findOrFail($id);
    }

    public function store(array $data)
    {
        Country::query()->create($data);
    }

    public function update(array $data, $id)
    {
        $country = Country::query()->findOrFail($id);
        $country->update($data);
    }

    public function destroy($id)
    {
        Country::query()->findOrFail($id)->delete();
    }

  /**
   * @throws ValidationErrorsException
   */
  public function exists($id, string $errorKey = 'country_id')
    {
        $item = Country::query()->find($id);

        if(! $item)
        {
            throw new ValidationErrorsException([
                $errorKey => translate_error_message('country', 'not_exists'),
            ]);
        }

        return $item;
    }
}
