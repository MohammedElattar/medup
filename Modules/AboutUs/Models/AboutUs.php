<?php

namespace Modules\AboutUs\Models;

use App\Helpers\MediaHelper;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class AboutUs extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
    ];

    protected $translatable = [
        'title',
        'description',
    ];

    public function firstImage()
    {
        return MediaHelper::mediaRelationship($this, 'about_us_first_image');
    }

    public function otherImages()
    {
        return MediaHelper::mediaRelationship($this, 'about_us_other_images', ['file_name', 'size']);
    }

    public function publicOtherImages()
    {
        return $this->otherImages();
    }

    public function resetFirstImage()
    {
        MediaHelper::resetImage($this, 'about_us_first_image');
    }
}
