<?php

namespace Modules\AboutUs\Services;

use App\Exceptions\ValidationErrorsException;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Modules\AboutUs\Models\AboutUs;

class AboutUsService
{
    public function index(bool $inPublic = false)
    {
        return AboutUs::query()->when($inPublic, fn ($q) => $q->where('id', '<>', 1))->get();
    }

    public function show($id, bool $isPublic = false)
    {
        return AboutUs::query()->with(['firstImage', $isPublic ? 'publicOtherImages' : 'otherImages'])->findOrFail($id);
    }

    public function update(array $data, $id): void
    {
        DB::transaction(function () use ($data, $id) {
            $item = AboutUs::query()->findOrFail($id);
            $item->update($data);

            $imageService = new ImageService($item, $data);
            $imageService->updateOneMedia('about_us_first_image', 'first_image');

            $imageService->updateMultipleMedia(
                'about_us_other_images',
                'deleted_images',
                'other_images'
            );

            if ($item->id == 1 && $item->otherImages()->count() != 4) {
                throw new ValidationErrorsException([
                    'other_images' => translate_word('other_images_count_error'),
                ]);
            }
        });
    }
}
