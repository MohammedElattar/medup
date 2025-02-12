<?php

namespace Modules\Expert\Models;

use App\Helpers\MediaHelper;
use Illuminate\Database\Eloquent\Model;
use Modules\Expert\Models\Builders\CertificationBuilder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ExpertCertification extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'date', 'expert_id'];

    public function image()
    {
        return MediaHelper::mediaRelationship($this, 'expert_certification');
    }

    public function newEloquentBuilder($query)
    {
        return new CertificationBuilder($query);
    }
}
