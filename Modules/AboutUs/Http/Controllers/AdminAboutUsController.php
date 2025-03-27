<?php

namespace Modules\AboutUs\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Modules\AboutUs\Http\Requests\AboutUsRequest;
use Modules\AboutUs\Services\AboutUsService;

class AdminAboutUsController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly AboutUsService $aboutUsService) {}

    public function index()
    {
        $items = $this->aboutUsService->index();

        return view('aboutus::index', compact('items'));
    }

    public function show($id)
    {
        $item = $this->aboutUsService->show($id);

        return view('aboutus::show', compact('item'));
    }

    public function update(AboutUsRequest $request, $id)
    {
        $this->aboutUsService->update($request->validated(), $id);

        return $this->okResponse();
    }
}
