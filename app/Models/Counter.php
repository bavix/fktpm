<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Counter
 *
 * @property int    $id
 * @property string $title
 * @property string $code
 * @property int    $active
 * @property string $created_at
 * @property string $updated_at
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
    protected $table      = 'counters';
    public    $timestamps = false;
}
