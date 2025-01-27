<?php

namespace Modules\Speciality\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Country\Http\Requests\CountryRequest;
use Modules\Speciality\Services\AdminSpecialityService;

class AdminSpecialityController extends Controller
{
    public function __construct(private readonly AdminSpecialityService $specialityService)
    {
    }

    public function index($collegeId)
    {
        $specialities = $this->specialityService->index($collegeId);

        return view('speciality::index', compact('specialities', 'collegeId'));
    }

    public function show($collegeId, $id)
    {
        $item = $this->specialityService->show($collegeId, $id);

        return view('speciality::show', compact('item'));
    }

    public function create($collegeId)
    {
        return view('speciality::create', compact('collegeId'));
    }

    public function store(CountryRequest $request, $collegeId)
    {
        $this->specialityService->store($request->validated(), $collegeId);

        return redirect()->route('specialities.index', $collegeId);
    }

    public function edit($collegeId, $id)
    {
        $item = $this->specialityService->show($collegeId, $id);

        return view('speciality::edit', compact('item', 'collegeId'));
    }

    public function update(CountryRequest $request, $collegeId, $id)
    {
        $this->specialityService->update($request->validated(), $collegeId, $id);

        return redirect()->route('specialities.index', $collegeId);
    }

    public function destroy($collegeId, $id)
    {
        $this->specialityService->destroy($collegeId, $id);

        return redirect()->route('specialities.index', $collegeId);
    }
}
