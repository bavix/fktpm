<?php

namespace App\Models;

use App\Helpers\HasTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class File extends Model
{

    use HasTags {
        tags as tagsToMany;
    }

    /**
     * @var string
     */
    protected $table = 'files';

    public function tags(): MorphToMany
    {
        return $this->tagsToMany()
            ->where('is_block', 0);
    }

}
