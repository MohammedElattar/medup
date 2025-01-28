<?php

namespace Modules\Auth\Actions\Register;

use App\Services\ImageService;
use Modules\Auth\Strategies\Verifiable;
use Modules\Expert\Models\Expert;
use Modules\Skill\Services\AdminSkillService;

class ExpertRegisterAction
{
    public function __construct(private readonly BaseRegisterAction $baseRegisterAction, private AdminSkillService $adminSkillService)
    {
    }

    public function handle(array $data, Verifiable $verifiable)
    {
        $this->adminSkillService->exist($data['skills']);

        $this->baseRegisterAction->handle($data, $verifiable, function($user) use ($data){
           $expert = Expert::query()->create($data + ['user_id' => $user->id]);
           $expert->skills()->sync($data['skills']);

           $imageService = new ImageService($expert, $data);
           $imageService->storeOneMediaFromRequest('cv', 'expert_cv');
        });
    }
}
