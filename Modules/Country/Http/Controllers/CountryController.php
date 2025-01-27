<?php

namespace Modules\Country\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Country\Http\Requests\CountryRequest;
use Modules\Country\Services\CountryService;

class CountryController extends Controller
{
    public function __construct(private readonly CountryService $countryService)
    {
    }

    public function index()
    {
        $countries = $this->countryService->index();

        return view('country::index', compact('countries'));
    }

    public function create()
    {
      return view('country::create');
    }

    public function edit($item)
    {
      $item = $this->countryService->show($item);

      return view('country::edit', compact('item'));
    }

    public function store(CountryRequest $request)
    {
        $this->countryService->store($request->validated());

        return redirect()->route('countries.index');
    }

    public function update(CountryRequest $request, $id)
    {
        $this->countryService->update($request->validated(), $id);

        return redirect()->route('countries.index');
    }

    public function destroy($id)
    {
        $this->countryService->destroy($id);

        return redirect()->route('countries.index');
    }
}
