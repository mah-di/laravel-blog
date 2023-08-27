<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageCleanup
{
    /**
         * Checks if image exists in storage and deletes if does. Returns default profile image path as a easy access.
         *
         * @return string
     */
    public function run(string $path)
    {
        $defaultProfileImage = env('DEFAULT_PROFILE_IMAGE');

        if ($path != $defaultProfileImage and Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        return $defaultProfileImage;
    }
}