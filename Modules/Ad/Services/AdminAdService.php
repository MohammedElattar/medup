<?php

namespace Modules\Ad\Services;

use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Modules\Ad\Models\Ad;
use Modules\Tile\Services\AdminTileService;

readonly class AdminAdService
{
    public function index()
    {
        return Ad::query()
            ->latest()
            ->with(['image'])
            ->paginatedCollection();
    }

    public function show($id)
    {
        return Ad::query()
            ->with(['image'])
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        DB::transaction(function () use ($data) {
            $ad = Ad::query()->create($data);

            $imageService = new ImageService($ad, $data);
            $imageService->storeOneMediaFromRequest('ad_image', 'image');
        });
    }

    public function update(array $data, $id)
    {
        DB::transaction(function () use ($data, $id) {
            $ad = Ad::query()->findOrFail($id);
            $ad->update($data);

            $imageService = new ImageService($ad, $data);
            $imageService->updateOneMedia('ad_image', 'image', 'resetImage');
        });
    }

    public function destroy($id)
    {
        Ad::query()->findOrFail($id)->delete();
    }
}
