<?php

namespace App\Helpers;

use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SaveCoverImage
{
    public function save($file)
    {
        $dt = DateTime::createFromFormat('U.u', microtime(true));
        $now = $dt->format("YmdHisu");

        $extention = $file->getClientOriginalExtension();
        $filename = Str::uuid()->toString()."-{$now}.{$extention}";

        $image = Image::make($file);
        $image->fit(1152, 300);

        $path = "img/cover-images/{$filename}";

        Storage::disk('public')->put($path, $image->encode());

        return $path;
    }
}
