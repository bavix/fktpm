<?php

namespace App\Models;

use App\Helpers\HasTags;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    use HasTags;

    /**
     * @var string
     */
    protected $table = 'files';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'files_categories');
    }

}
