<?php

namespace App\Facades;

use App\Helpers\ImageCleanup;
use Illuminate\Support\Facades\Facade;

/**
    * @method static string run(string $path)
    * @see ImageCleanup
    */
class ImageCleanupFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ImageCleanup::class;
    }
}