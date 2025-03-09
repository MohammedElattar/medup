<?php

namespace Modules\Idea\Http\Controllers;

use App\Helpers\FlasherHelper;
use App\Http\Controllers\SelectMenuController;
use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Idea\Models\Idea;
use Modules\Idea\Services\AdminIdeaService;

class AdminIdeaController extends Controller
{
    use HttpResponse;

    public function __construct(private AdminIdeaService $adminIdeaService)
    {
    }

    public function index()
    {
        $ideas = $this->adminIdeaService->index();

        return view('idea::index', compact('ideas'));
    }

    public function edit($id)
    {
        $item = Idea::query()->findOrFail($id);

        return view('idea::edit', ['item' => $item]);
    }

    public function destroy($id)
    {
        Idea::query()->findOrFail($id)->delete();

        FlasherHelper::success(translate_success_message('idea', 'deleted_female'));

        return redirect()->route('ideas.index');
    }

    public function changeStatus($id)
    {
        $item = Idea::query()->findOrFail($id);
        $item->forceFill(['status' => !$item->status])->save();

        FlasherHelper::success(translate_success_message('idea', 'updated_female'));

        return redirect()->route('ideas.index');
    }

    private function getMenus(): array
    {
        $selectMenuController = new SelectMenuController();

        return ['colleges' => $selectMenuController->colleges(), 'specialities' => $selectMenuController->specialities()];
    }
}
