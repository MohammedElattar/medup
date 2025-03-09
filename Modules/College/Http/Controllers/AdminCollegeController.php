<?php

namespace Modules\College\Http\Controllers;

use App\Helpers\FlasherHelper;
use App\Http\Controllers\Controller;
use Modules\College\Http\Requests\CollegeRequest;
use Modules\College\Services\AdminCollegeService;
use Modules\Country\Http\Requests\CountryRequest;

class AdminCollegeController extends Controller
{
    public function __construct(private readonly AdminCollegeService $collegeService) {}

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

    public function store(CollegeRequest $request)
    {
        $this->collegeService->store($request->validated());

        FlasherHelper::success(translate_success_message('college', 'created_female'));

        return redirect()->route('colleges.index');
    }

    public function update(CollegeRequest $request, $id)
    {
        $this->collegeService->update($request->validated(), $id);

        FlasherHelper::success(translate_success_message('college', 'updated_female'));

        return redirect()->route('colleges.index');
    }

    public function destroy($id)
    {
        $this->collegeService->destroy($id);

        FlasherHelper::success(translate_success_message('college', 'deleted_female'));

        return redirect()->route('colleges.index');
    }
}
