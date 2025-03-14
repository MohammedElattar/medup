<?php

namespace Modules\Library\Services;

use App\Exceptions\ValidationErrorsException;
use App\Helpers\PdfHelper;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Modules\Expert\Traits\ExpertSetter;
use Modules\Library\Models\Builders\LibraryBuilder;
use Modules\Library\Models\Library;
use Modules\Speciality\Services\AdminSpecialityService;

class PublicLibraryService
{
    use ExpertSetter;

    public function __construct(private readonly AdminSpecialityService $adminSpecialityService)
    {
    }

    public function index(array $filters)
    {
        return Library::query()
            ->when(true, fn(LibraryBuilder $b) => $b->handleFilters($filters)->withMinimalDetailsForPublic())
            ->searchable(['title'])
            ->paginatedCollection();
    }

    public function show($id)
    {
        return Library::query()
            ->when(true, fn(LibraryBuilder $b) => $b->withDetailsForPublic())
            ->findOrFail($id);
    }

    /**
     * @throws ValidationErrorsException
     */
    public function store(array $data)
    {
        $this->adminSpecialityService->exists($data['speciality_id']);
        $this->assertUnique($data['title']);

        DB::transaction(function() use ($data){
            $library = Library::query()->create($data + [
                'pages_count' => PdfHelper::getPagesCount($data['file']->getPathName()),
                'expert_id' => $this->getExpert()->id,
            ]);

            $imageService = new ImageService($library, $data);
            $imageService->storeOneMediaFromRequest('library_cover', 'cover');
            $imageService
                ->setDisk('books')
                ->storeOneMediaFromRequest('library_file', 'file');
        });
    }

    /**
     * @throws ValidationErrorsException
     */
    private function assertUnique(string $title)
    {
        $exists = Library::query()
            ->where('title', $title)
            ->where('expert_id', $this->getExpert()->id)
            ->exists();

        if($exists) {
            throw new ValidationErrorsException([
                'title' => translate_error_message('title', 'exists'),
            ]);
        }
    }
}
