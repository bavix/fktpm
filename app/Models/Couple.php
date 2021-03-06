<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Couple
 *
 * @property int $id
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Couple newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Couple newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Couple query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Couple whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Couple whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Couple whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Couple whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Couple whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Couple extends Model
{

}
