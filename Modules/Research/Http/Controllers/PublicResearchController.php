<?php

namespace Modules\Research\Http\Controllers;

use App\Services\ImageService;
use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Research\Http\Requests\ResearchRequest;
use Modules\Research\Models\Research;

class PublicResearchController extends Controller
{
    use HttpResponse;

    public function __construct()
    {
    }

    public function store(ResearchRequest $request)
    {
        DB::transaction(function() use ($request){
           $research = Research::query()->create($request->validated() + ['user_id' => auth()->id()]);
           $imageService = new ImageService($research, $request->validated());
           $imageService->storeOneMediaFromRequest('research_file', 'file');
        });

        return $this->createdResponse(message: translate_success_message('research', 'created'));
    }
}
