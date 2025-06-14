<?php

namespace Modules\Expert\Http\Controllers;

use App\Helpers\FlasherHelper;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Expert\Services\AdminExpertService;

class AdminExpertController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly AdminExpertService $adminExpertService) {}

    public function index()
    {
        $experts = $this->adminExpertService->index();

        return view('expert::index', compact('experts'));
    }

    public function changeStatus($id)
    {
        $user = User::query()->where('type', '<>', UserTypeEnum::ADMIN)->findOrFail($id);

        $user->forceFill([
            'status' => !$user->status
        ])->save();

        FlasherHelper::success(translate_success_message('user', 'updated'));

        return redirect()->route('experts.index');
    }
}
