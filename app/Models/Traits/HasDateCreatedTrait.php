<?php

namespace App\Models\Traits;



trait HasDateCreatedTrait
{

    protected function getDateCreatedAttribute(): string
    {
        return date('d M Y', strtotime($this->created_at));
    }

}