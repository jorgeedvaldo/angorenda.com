<?php

namespace App\Observers;

use App\Models\PropertyImage;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class PropertyImageObserver
{
    /**
     * Handle the PropertyImage "created" event.
     */
    public function created(PropertyImage $propertyImage): void
    {
        if (empty($propertyImage->image_path)) {
            return;
        }

        $disk = Storage::disk('public');

        if (!$disk->exists($propertyImage->image_path)) {
            return;
        }

        $originalPath = $disk->path($propertyImage->image_path);

        $pathInfo = pathinfo($propertyImage->image_path);
        $thumbnailDir = 'property-images/thumbnails';
        $thumbnailFilename = $pathInfo['filename'] . '_thumb.' . ($pathInfo['extension'] ?? 'jpg');
        $thumbnailRelativePath = $thumbnailDir . '/' . $thumbnailFilename;

        if (!$disk->exists($thumbnailDir)) {
            $disk->makeDirectory($thumbnailDir);
        }

        $thumbnailFullPath = $disk->path($thumbnailRelativePath);

        $manager = ImageManager::gd();
        $image = $manager->read($originalPath);
        $image->scale(width: 800, height: 600);
        $image->save($thumbnailFullPath);

        $propertyImage->updateQuietly([
            'thumbnail_path' => $thumbnailRelativePath,
        ]);
    }

    /**
     * Handle the PropertyImage "deleted" event.
     */
    public function deleted(PropertyImage $propertyImage): void
    {
        $disk = Storage::disk('public');

        if (!empty($propertyImage->image_path) && $disk->exists($propertyImage->image_path)) {
            $disk->delete($propertyImage->image_path);
        }

        if (!empty($propertyImage->thumbnail_path) && $disk->exists($propertyImage->thumbnail_path)) {
            $disk->delete($propertyImage->thumbnail_path);
        }
    }
}
