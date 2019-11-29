<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Blacklist
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Blacklist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Blacklist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Blacklist query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Blacklist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Blacklist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Blacklist whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Blacklist whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Blacklist extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['name'];

}
