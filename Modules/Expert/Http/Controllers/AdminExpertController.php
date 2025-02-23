<?php

namespace Modules\Expert\Http\Controllers;

use App\Helpers\FlasherHelper;
use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Expert\Models\Expert;
use Modules\Expert\Services\AdminExpertService;
use Modules\Expert\Transformers\ExpertResource;

class AdminExpertController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly AdminExpertService $adminExpertService)
    {
    }

    public function index()
    {
        $experts = $this->adminExpertService->index();

        return view('expert::index', compact('experts'));
    }

    public function changeStatus($id)
    {
        $expert = Expert::query()->findOrFail($id);

        $expert->user->forceFill([
            'status' => !$expert->user->status
        ])->save();

        FlasherHelper::success(translate_success_message('expert', 'updated'));

        return redirect()->route('experts.index');
    }
}
