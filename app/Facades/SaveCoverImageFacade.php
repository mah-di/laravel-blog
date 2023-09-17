<?php

namespace App\Facades;

use App\Helpers\SaveCoverImage;
use Illuminate\Support\Facades\Facade;

class SaveCoverImageFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SaveCoverImage::class;
    }
}
