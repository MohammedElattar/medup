<?php

namespace Modules\Library\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Library\Models\Library;

class LibraryFileController extends Controller
{
    public function getFile($bookId)
    {
        $library = Library::query()
            ->whereHas('order', fn($q) => $q->where('user_id', auth()->id()))
            ->with('file')
            ->findOrFail($bookId);

        $filePath = $library->file->first() ? $library->file->first()->getPath() : public_path('storage/default/test.pdf');
        $fileName = $library->file->first() ? $library->file->first()->name : 'default.pdf';

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }
}
