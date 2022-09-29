<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

class Image
{
    public function generateThumbnails($path, $file, $name)
    {
        $x1 = "thumbnails/1x/$path";
        $originalImage  = \Intervention\Image\Facades\Image::make($file);
        Storage::disk(config('mediaManager.storage_disk'))->put($x1, $originalImage->resize(16, 16));
    }
}
