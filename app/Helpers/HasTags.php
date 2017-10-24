<?php

namespace App\Helpers;

use App\Models\Tag;

trait HasTags
{
    use \Spatie\Tags\HasTags;

    public static function getTagClassName(): string
    {
        return Tag::class;
    }
}
