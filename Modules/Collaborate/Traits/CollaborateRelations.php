<?php

namespace Modules\Collaborate\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Comment\Traits\CommentRelation;
use Modules\Expert\Models\Expert;
use Modules\Speciality\Models\Speciality;

trait CollaborateRelations
{
    use CommentRelation;

    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class);
    }

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }
}
