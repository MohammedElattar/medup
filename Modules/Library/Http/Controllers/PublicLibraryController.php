<?php

namespace Modules\Library\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Helpers\RequestHelper;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Library\Http\Requests\LibraryFilterRequest;
use Modules\Library\Http\Requests\LibraryRequest;
use Modules\Library\Services\PublicLibraryService;
use Modules\Library\Transformers\LibraryResource;

class PublicLibraryController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly PublicLibraryService $publicLibraryService)
    {
        RequestHelper::loginIfHasToken($this, GeneralHelper::getDefaultLoggedUserMiddlewares());
    }

    public function index(LibraryFilterRequest $request)
    {
        $library = $this->publicLibraryService->index($request->validated());

        return $this->paginatedResponse($library, LibraryResource::class);
    }

    public function show($id): JsonResponse
    {
        $item = $this->publicLibraryService->show($id);

        return $this->resourceResponse(LibraryResource::make($item));
    }

    public function store(LibraryRequest $request)
    {
        $this->publicLibraryService->store($request->validated());

        return $this->createdResponse(message: translate_success_message('library_item', 'created'));
    }
}
