<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class TagService
{

    /**
     * @param string $class
     * @param Collection $tags
     * @return array
     */
    public function getIdsByClass(string $class, Collection $tags): array
    {
        return $this->getIdsBy($class)
            ->whereIn('tag_id', $tags->pluck('id')->toArray())
            ->limit(10000)
            ->get()
            ->unique('id')
            ->pluck('id')
            ->toArray();
    }

    /**
     * @param string $class
     * @return Builder
     */
    public function getIdsBy(string $class): Builder
    {
        return DB::query()
            ->select(['taggable_id as id'])
            ->distinct()
            ->from('taggables')
            ->where('taggable_type', $class);
    }

}
