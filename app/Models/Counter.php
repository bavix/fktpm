<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Counter
 *
 * @property int $id
 * @property string $title
 * @property string $code
 * @property bool $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Counter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Counter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Counter query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Counter whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Counter whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Counter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Counter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Counter whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Counter whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Counter extends Model
{

}
