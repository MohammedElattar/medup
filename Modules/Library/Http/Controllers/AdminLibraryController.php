<?php

namespace Modules\Library\Http\Controllers;

use App\Helpers\FlasherHelper;
use Illuminate\Routing\Controller;
use Modules\Library\Models\Builders\LibraryBuilder;
use Modules\Library\Models\Library;

class AdminLibraryController extends Controller
{
    public function index()
    {
        $library = Library::query()
            ->latest()
            ->when(true, fn(LibraryBuilder $b) => $b->withMinimalDetailsForPublic())
            ->searchable(['title'])
            ->paginatedCollection();

        return view('library::index', compact('library'));
    }

    public function destroy($id)
    {
        Library::query()->findOrFail($id)->delete();

        FlasherHelper::success(translate_success_message('library', 'deleted'));

        return redirect()->route('library.index');
    }
}
