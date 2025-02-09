<?php

namespace Modules\College\Services;

use App\Exceptions\ValidationErrorsException;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Modules\College\Models\College;

class AdminCollegeService
{
    public function index()
    {
        return College::query()->latest()->with('icon')->paginatedCollection();
    }

    public function show($id)
    {
        return College::query()->with('icon')->findOrFail($id);
    }

    public function store(array $data)
    {
        DB::transaction(function() use ($data){
            $college = College::query()->create($data);

        });
    }

    public function update(array $data, $id)
    {
        $college = College::query()->findOrFail($id);

        DB::transaction(function() use ($data, $college){
            $college->update($data);
            $imageService = new ImageService($college, $data);
            $imageService->updateOneMedia( 'college_logo', 'icon');
        });
    }

    public function destroy($id)
    {
        College::query()->findOrFail($id)->delete();
    }

    /**
     * @throws ValidationErrorsException
     */
    public function exists($id, string $errorKey = 'college_id')
    {
        $item = College::query()->find($id);

        if (! $item) {
            throw new ValidationErrorsException([
                $errorKey => translate_error_message('college', 'not_exists'),
            ]);
        }

        return $item;
    }
}
