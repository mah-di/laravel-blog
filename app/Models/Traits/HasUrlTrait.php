<?php

namespace App\Models\Traits;



trait HasUrlTrait
{

    protected function constructUrl(string $path, int $id = null): string
    {
        if ($id === null) $id = $this->id;

        return env('APP_URL')."/{$path}/{$id}";
    }

}
