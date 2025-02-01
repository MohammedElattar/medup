<?php

namespace Modules\Speciality\Transformers;

use App\Helpers\ResourceHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\College\Transformers\CollegeResource;

class SpecialityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->whenHas('name'),
            'college_id' => $this->when(
                ResourceHelper::shouldReturnForeignKey($this, 'college', 'college_id'),
                $this->college_id
            ),
            'college' => $this->whenLoaded('college', function(){
                return CollegeResource::make($this->college);
            })
        ];
    }
}
