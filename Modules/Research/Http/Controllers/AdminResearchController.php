<?php

namespace Modules\Research\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Research\Models\Research;

class AdminResearchController extends Controller
{
    use HttpResponse;

    public function index()
    {
        $researches = Research::query()->latest()->searchable(['title', 'skills', 'contributors'])->with('file')->paginatedCollection();

        return view('research::index', compact('researches'));
    }

    public function destroy($id)
    {
        Research::query()->findOrFail($id)->delete();

        return redirect()->route('researches.index');
    }
}
