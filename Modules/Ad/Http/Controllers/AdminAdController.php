<?php

namespace Modules\Ad\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Modules\Ad\Http\Requests\AdRequest;
use Modules\Ad\Services\AdminAdService;
use Modules\Tile\Models\Tile;

class AdminAdController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly AdminAdService $adminAdService) {}

    public function index()
    {
        $ads = $this->adminAdService->index();

        return view('ad::index', compact('ads'));
    }

    public function create()
    {
        return view('ad::create');
    }

    public function store(AdRequest $request)
    {
        $this->adminAdService->store($request->validated());

        return $this->createdResponse();
    }

    public function show($id)
    {
        $item = $this->adminAdService->show($id);

        return view('ad::edit',  compact('item'));
    }

    public function update(AdRequest $request, $id)
    {
        $this->adminAdService->update($request->validated(), $id);

        return $this->okResponse();
    }

    public function destroy($id)
    {
        $this->adminAdService->destroy($id);

        return redirect()->route('ads.index');
    }
}
