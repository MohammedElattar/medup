<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Course\Models\Course;
use Modules\Course\Transformers\CourseResource;
use Modules\Library\Models\Library;
use Modules\Library\Transformers\LibraryResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->getType()[$this->orderable_type],
            'price' => round($this->price),
            'created_at' => $this->whenHas('created_at'),
            'item' => $this->whenLoaded('orderable', function(){
               if($this->orderable_type === Library::class){
                   return LibraryResource::make($this->orderable);
               }

               return CourseResource::make($this->orderable);
            }),
        ];
    }

    private function getType()
    {
        return [
            Library::class => 'library',
            Course::class => 'course',
        ];
    }
}
