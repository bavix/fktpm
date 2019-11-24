<?php

namespace App\Services;

use App\Models\Link;
use Illuminate\Database\Eloquent\Collection;

class LinkService
{

    /**
     * @return Collection
     */
    public function fetchAll(): Collection
    {
        return Link::query()->where('active', 1)->get();
    }

}
