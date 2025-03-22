<?php

namespace Modules\Course\Traits;

use App\Helpers\MediaHelper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Expert\Models\Expert;
use Modules\Order\Models\Order;
use Modules\Review\Traits\ReviewRelation;
use Modules\Speciality\Models\Speciality;

trait CourseRelations
{
    use ReviewRelation;

    public function cover()
    {
        return MediaHelper::mediaRelationship($this, 'course_cover');
    }

    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class);
    }

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }

    public function order()
    {
        return $this->morphOne(Order::class, 'orderable');
    }
}
