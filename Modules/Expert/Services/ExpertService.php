<?php

namespace Modules\Expert\Services;

use App\Exceptions\ValidationErrorsException;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Modules\City\Services\CityService;
use Modules\Expert\Models\Builders\ExpertBuilder;
use Modules\Expert\Models\Expert;
use Modules\Expert\Traits\ExpertSetter;
use Modules\Skill\Services\AdminSkillService;
use Modules\Speciality\Services\AdminSpecialityService;

class ExpertService
{
    use ExpertSetter;

    public function __construct(
        private readonly AdminSkillService $adminSkillService,
        private readonly CityService $cityService,
        private readonly AdminSpecialityService $adminSpecialityService
    )
    {
    }

    public function show()
    {
        return Expert::query()
            ->when(true, fn(ExpertBuilder $b) => $b->withProfileDetails())
            ->findOrFail($this->getExpert()->id);
    }

    public function update(array $data)
    {
        DB::transaction(function() use ($data){
            $expert = $this->getExpert();

            if(isset($data['city_id'])) {
                $this->cityService->exists($data['city_id']);
            }

            if(isset($data['speciality_id'])) {
                $this->adminSpecialityService->exists($data['speciality_id']);
            }

            if(isset($data['skills'])) {
                $this->adminSkillService->exist($data['skills']);
                $expert->skills()->sync($data['skills']);
            }

            $expert->update($data);

            if(isset($data['social_contacts'])) {
                (new ExpertSocialContactService())->update($data['social_contacts']);
            }

            $imageService = new ImageService($expert, $data);
            $imageService->updateOneMedia('expert_cv', 'cv');
        });

        return $this->show();
    }

    public function exists($id, string $errorKey = 'expert_id')
    {
        $expert = Expert::query()->find($id);

        if(! $expert) {
            throw new ValidationErrorsException([
                $errorKey => translate_error_message('expert', 'not_exists'),
            ]);
        }

        return $expert;
    }
}
