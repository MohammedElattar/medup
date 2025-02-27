<?php

namespace Modules\Library\Traits;

use App\Helpers\MediaHelper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Expert\Models\Expert;
use Modules\Speciality\Models\Speciality;
use Modules\Tag\Models\Tag;

trait LibraryRelations
{
    public function cover()
    {
        return MediaHelper::mediaRelationship($this, 'library_cover');
    }

    public function file()
    {
        return MediaHelper::mediaRelationship($this, 'library_file');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class);
    }

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }
}
