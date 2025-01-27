<?php

namespace Modules\College\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\College\Services\AdminCollegeService;
use Modules\Country\Http\Requests\CountryRequest;

class AdminCollegeController extends Controller
{
    public function __construct(private readonly AdminCollegeService $collegeService)
    {
    }

    public function index()
    {
        $colleges = $this->collegeService->index();

        return view('college::index', compact('colleges'));
    }

    public function create()
    {
        return view('college::create');
    }

    public function edit($item)
    {
        $item = $this->collegeService->show($item);

        return view('college::edit', compact('item'));
    }

    public function store(CountryRequest $request)
    {
        $this->collegeService->store($request->validated());

        return redirect()->route('colleges.index');
    }

    public function update(CountryRequest $request, $id)
    {
        $this->collegeService->update($request->validated(), $id);

        return redirect()->route('colleges.index');
    }

    public function destroy($id)
    {
        $this->collegeService->destroy($id);

        return redirect()->route('colleges.index');
    }
}
