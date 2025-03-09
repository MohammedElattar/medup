<?php

namespace Modules\Collaborate\Http\Controllers;

use App\Helpers\FlasherHelper;
use App\Http\Controllers\SelectMenuController;
use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Collaborate\Models\Collaborate;
use Modules\Collaborate\Services\AdminCollaborateService;

class AdminCollaborateController extends Controller
{
    use HttpResponse;

    public function __construct(private AdminCollaborateService $adminCollaborateService)
    {
    }

    public function index()
    {
        $collaborates = $this->adminCollaborateService->index();

        return view('collaborate::index', compact('collaborates'));
    }

    public function edit($id)
    {
        $item = Collaborate::query()->findOrFail($id);

        return view('collaborate::edit', ['item' => $item]);
    }

    public function destroy($id)
    {
        Collaborate::query()->findOrFail($id)->delete();

        FlasherHelper::success(translate_success_message('collaborate', 'deleted_female'));

        return redirect()->route('collaborates.index');
    }

    public function changeStatus($id)
    {
        $item = Collaborate::query()->findOrFail($id);
        $item->forceFill(['status' => !$item->status])->save();

        FlasherHelper::success(translate_success_message('collaborate', 'updated_female'));

        return redirect()->route('collaborates.index');
    }
}
