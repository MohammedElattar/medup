<?php

namespace Modules\Skill\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Skill\Http\Requests\SkillRequest;
use Modules\Skill\Services\AdminSkillService;

class AdminSkillController extends Controller
{
    public function __construct(private readonly AdminSkillService $adminSkillService) {}

    public function index()
    {
        $skills = $this->adminSkillService->index();

        return view('skill::index', compact('skills'));
    }

    public function show($id)
    {
        $item = $this->adminSkillService->show($id);

        return view('skill::edit', compact('item'));
    }

    public function create()
    {
        return view('skill::create');
    }

    public function store(SkillRequest $request)
    {
        $this->adminSkillService->store($request->validated());

        return redirect()->route('skills.index');
    }

    public function update(SkillRequest $request, $id)
    {
        $this->adminSkillService->update($request->validated(), $id);

        return redirect()->route('skills.index');
    }

    public function destroy($id)
    {
        $this->adminSkillService->destroy($id);

        return redirect()->route('skills.index');
    }
}
