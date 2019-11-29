<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Following
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Following newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Following newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Following query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Following whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Following whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Following whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Following whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Following extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['name'];

}
