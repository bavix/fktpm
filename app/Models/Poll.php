<?php

namespace App\Models;

use Bavix\Helpers\Str;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Poll extends Model
{

    use Taggable;
    use Searchable;

    /**
     * @var string
     */
    protected $table = 'polls';
    protected $route = 'poll.view';

    public function setMultipleTagAttribute($tags)
    {
        $this->id or $this->save();
        $this->tag($tags);
    }

    /**
     * Получить имя индекса для модели.
     *
     * @return string
     */
    public function searchableAs()
    {
        return $this->table . '_index';
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'poll_id');
    }

    /**
     * @return string
     */
    public function url()
    {
        return route($this->route, [
            'id'    => $this->id,
            'title' => Str::friendlyUrl($this->title),
        ]);
    }

}
