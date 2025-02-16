<?php

namespace Modules\Expert\Services;

use App\Exceptions\ValidationErrorsException;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Modules\Expert\Models\ExpertCertification;
use Modules\Expert\Traits\ExpertSetter;

class ExpertCertificationService
{
    use ExpertSetter;

    public function show()
    {
        return ExpertCertification::query()
            ->where('expert_id', $this->getExpert()->id)
            ->with('image')
            ->first();
    }

    public function update(array $data)
    {
        $expertCertification = ExpertCertification::query()
            ->where('expert_id', $this->getExpert()->id)
            ->first();

        if(! $expertCertification && !isset($data['file'])) {
            throw new ValidationErrorsException([
                'file' => translate_error_message('file', 'required')
            ]);
        }

        DB::transaction(function() use ($data, $expertCertification) {
            if($expertCertification) {
                $expertCertification->update($data);
            } else {
                $expertCertification = ExpertCertification::query()->create($data + ['expert_id' => $this->getExpert()->id]);
            }

            $imageService = new ImageService($expertCertification, $data);
            $imageService->storeOneMediaFromRequest('expert_certification', 'file');
        });

        return $this->show();
    }
}
