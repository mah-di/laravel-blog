<?php

namespace App\Models\Traits;



trait HasBodyPreviewTrait
{

    protected function getBodyPreviewAttribute(): string
    {
        $preview = substr($this->body, 0, 20);

        return (strlen($this->body) > 20) ? "$preview.." : $preview;
    }

}