<?php

namespace Modules\Tag\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Country\Http\Requests\CountryRequest;
use Modules\Tag\Services\TagService;

class TagController extends Controller
{
    public function __construct(private readonly TagService $tagService) {}

    public function index()
    {
        $tags = $this->tagService->index();

        return view('tag::index', compact('tags'));
    }

    public function create()
    {
        return view('tag::create');
    }

    public function edit($item)
    {
        $item = $this->tagService->show($item);

        return view('tag::edit', compact('item'));
    }

    public function store(CountryRequest $request)
    {
        $this->tagService->store($request->validated());

        return redirect()->route('tags.index');
    }

    public function update(CountryRequest $request, $id)
    {
        $this->tagService->update($request->validated(), $id);

        return redirect()->route('tags.index');
    }

    public function destroy($id)
    {
        $this->tagService->destroy($id);

        return redirect()->route('tags.index');
    }
}
