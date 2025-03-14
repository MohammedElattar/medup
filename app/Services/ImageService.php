<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ImageService
{
    private HasMedia $model;

    private array $data;
    private string $disk;

    public function __construct($model, $data, string $disk = 'public')
    {
        $this->model = $model;
        $this->data = $data;
        $this->disk = $disk;
    }

    public static function createInstance(HasMedia $model, array $data): ImageService
    {
        return new self($model, $data);
    }

    /**
     * store Just one media
     */
    public function storeOneMediaFromRequest(string $collectionName, string $requestFileName)
    {
        if (isset($this->data[$requestFileName])) {
            (new FileOperationService)->storeImageFromRequest(
                $this->model,
                $collectionName,
                $requestFileName,
                disk: $this->disk
            );
        }
    }

    public function updateOneMedia(string $collectionName, string $requestFileName, string $resetMainImageCollectionName = 'resetImage'): void
    {
        if (isset($this->data[$requestFileName])) {
            $this->model->clearMediaCollection($collectionName);
            $this->storeOneMediaFromRequest($collectionName, $requestFileName);
        }
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function updateMultipleMedia(
        string $collectionName,
        string $deleteMediasRequest = '',
        string $otherMediasRequest = '',
        string $otherMediasRelationName = 'otherImages',
    ) {
        $this->deleteMultipleMediaViaIds($deleteMediasRequest, $otherMediasRelationName);

        return $this->storeMultipleMedia($collectionName, $otherMediasRequest);
    }

    /**
     * store many medias
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function storeMultipleMedia(string $collectionName, string $multipleMediaRequestKey = 'other_images')
    {
        $items = [];

        if (isset($this->data[$multipleMediaRequestKey])) {
            foreach ($this->data[$multipleMediaRequestKey] as $media) {
                $items[] = $this->storeMediaFromFile($media, $collectionName);
            }
        }

        return $items;
    }

    public function deleteMultipleMediaViaIds(string $deletedMediaRequestKey, string $otherMediasRelationName = 'otherImages'): void
    {
        if (isset($this->data[$deletedMediaRequestKey])) {
            $deletedMedias = array_unique($this->data[$deletedMediaRequestKey]);

            $this->model
                ->$otherMediasRelationName()
                ->whereIntegerInRaw('id', $deletedMedias)
                ->delete();

            Artisan::call('media-library:clean');
        }
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function storeMediaFromFile(UploadedFile $media, string $collectionName)
    {
        if (self::isCompressibleImage($media->getMimeType())) {
            return $this
                ->model
                ->addMediaFromString(self::getCompressesImagePath($media->getPathname()))
                ->usingFileName(Str::random().'.webp')
                ->toMediaCollection($collectionName, $this->disk);
        }

        return $this
            ->model
            ->addMedia($media)
            ->usingFileName(Str::random().'.'.static::getMediaExtension($media))
            ->toMediaCollection($collectionName, $this->disk);
    }

    public static function getMediaExtension(UploadedFile $uploadedFile): string
    {
        return self::isCompressibleImage($uploadedFile->getMimeType()) ? 'webp' : $uploadedFile->extension();
    }

    public static function getCompressesImagePath(string $path)
    {
        $manager = new ImageManager(new Driver);

        $image = $manager->read($path);

        return $image->encode(new WebpEncoder(10))->toString();
    }

    public static function isCompressibleImage(string $mimeType)
    {
        $mimeType = explode('/', $mimeType);

        return $mimeType[0] == 'image' && $mimeType[1] != 'svg+xml';
    }

    public function setDisk(string $disk)
    {
        $this->disk = $disk;

        return $this;
    }
}
