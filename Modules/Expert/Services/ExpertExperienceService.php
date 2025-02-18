<?php

namespace Modules\Expert\Services;

use App\Exceptions\ValidationErrorsException;
use Illuminate\Support\Carbon;
use Modules\City\Services\CityService;
use Modules\Expert\Exceptions\ExpertException;
use Modules\Expert\Models\Builders\ExpertExperienceBuilder;
use Modules\Expert\Models\ExpertExperience;
use Modules\Expert\Traits\ExpertSetter;

class ExpertExperienceService
{
    use ExpertSetter;

    public function __construct(private CityService $cityService)
    {
    }

    public function index()
    {
        return ExpertExperience::query()
            ->when(true, fn(ExpertExperienceBuilder $b) => $b->withMinimalDetailsForExpert())
            ->latest()
            ->where('expert_id', $this->getExpert()->id)
            ->get();
    }

    public function show($id)
    {
        return ExpertExperience::query()
            ->when(true, fn(ExpertExperienceBuilder $b) => $b->withCityDetails())
            ->where('expert_id', $this->getExpert()->id)
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        $this->cityService->exists($data['city_id']);

        $this->assertUnique($data);

        ExpertExperience::query()->create($data + [
            'expert_id' => $this->getExpert()->id,
            'experience_years' => $this->calculateTotalExperience($data),
        ]);
    }

    public function update(array $data, $id)
    {
        $experience = ExpertExperience::query()->where('expert_id', $this->getExpert()->id)->findOrFail($id);

        if(isset($data['city_id'])) {
            $this->cityService->exists($data['city_id']);
        }

        $this->assertUnique([
            'job_title' => $data['job_title'] ?? $experience->job_title,
            'start_date' => $data['start_date'] ?? $experience->start_date,
            'hospital_name' => $data['hospital_name'] ?? $experience->hospital_name,
        ], $id);

        $experience->update($data + [
            'experience_years' => $this->calculateTotalExperience([
                'start_date' => $data['start_date'] ?? $experience->start_date,
                'end_date' => $data['end_date'] ?? $experience->end_date,
            ]),
        ]);
    }

    public function destroy($id)
    {
        ExpertExperience::query()
            ->where('expert_id', $this->getExpert()->id)
            ->findOrFail($id)
            ->delete();
    }

    private function assertUnique(array $data, $id = null)
    {
        $exists = ExpertExperience::query()
            ->where('job_title', $data['job_title'])
            ->where('start_date', $data['start_date'])
            ->where('hospital_name', $data['hospital_name'])
            ->where('expert_id', $this->getExpert()->id)
            ->when(!is_null($id), fn($q) => $q->where('id', '<>', $id))
            ->exists();

        if($exists) {
            ExpertException::duplicateExperience();
        }
    }

    private function calculateTotalExperience(array $data)
    {
        return round(Carbon::parse($data['start_date'])->diffInYears(Carbon::parse($data['end_date'])));
    }
}
