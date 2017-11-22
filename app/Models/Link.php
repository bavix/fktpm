<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Link
 *
 * @property int    $id
 * @property string $title
 * @property string $url
 * @property int    $active
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereUrl($value)
 * @mixin \Eloquent
 */
class Link extends Model
{

    public $timestamps = false;

    protected function parse()
    {
        return \parse_url($this->url);
    }

    /**
     * @return null|string
     */
    public function host()
    {
        return $this->parse()['host'] ?? null;
    }

    public static function getActive()
    {
        return static::query()
            ->where('active', 1)
            ->get();
    }

}
