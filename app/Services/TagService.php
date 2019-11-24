<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TagService
{

    /**
     * @param string $class
     * @param Collection $tags
     * @return array
     */
    public function getIdsBy(string $class, Collection $tags): array
    {
        return DB::query()
            ->select(['taggable_id as id'])
            ->from('taggables')
            ->whereIn('tag_id', $tags->pluck('id')->toArray())
            ->where('taggable_type', $class)
            ->limit(10000)
            ->get()
            ->unique('id')
            ->pluck('id')
            ->toArray();
    }

}
