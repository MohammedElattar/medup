<?php

namespace Modules\College\Services;

use App\Exceptions\ValidationErrorsException;
use Modules\College\Models\College;

class AdminCollegeService
{
    public function index()
    {
        return College::query()->latest()->paginatedCollection();
    }

    public function show($id)
    {
        return College::query()->findOrFail($id);
    }

    public function store(array $data)
    {
        College::query()->create($data);
    }

    public function update(array $data, $id)
    {
        $college = College::query()->findOrFail($id);
        $college->update($data);
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
