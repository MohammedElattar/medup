<?php

namespace Modules\City\Http\Controllers;

use App\Helpers\FlasherHelper;
use App\Http\Controllers\Controller;
use Modules\City\Services\CityService;
use Modules\Country\Http\Requests\CountryRequest;

class CityController extends Controller
{
    public function __construct(private readonly CityService $cityService) {}

    public function index($countryId)
    {
        $cities = $this->cityService->index($countryId);

        return view('city::index', compact('cities', 'countryId'));
    }

    public function show($countryId, $id)
    {
        $item = $this->cityService->show($countryId, $id);

        return view('city::show', compact('item'));
    }

    public function create($countryId)
    {
        return view('city::create', compact('countryId'));
    }

    public function store(CountryRequest $request, $countryId)
    {
        $this->cityService->store($request->validated(), $countryId);

        FlasherHelper::success(translate_success_message('city', 'created_female'));

        return redirect()->route('cities.index', $countryId);
    }

    public function edit($countryId, $id)
    {
        $item = $this->cityService->show($countryId, $id);

        return view('city::edit', compact('item', 'countryId'));
    }

    public function update(CountryRequest $request, $countryId, $id)
    {
        $this->cityService->update($request->validated(), $countryId, $id);

        FlasherHelper::success(translate_success_message('city', 'updated_female'));

        return redirect()->route('cities.index', $countryId);
    }

    public function destroy($countryId, $id)
    {
        $this->cityService->destroy($countryId, $id);

        FlasherHelper::success(translate_success_message('city', 'deleted_female'));

        return redirect()->route('cities.index', $countryId);
    }
}
