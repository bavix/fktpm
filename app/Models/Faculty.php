<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Faculty
 *
 * @property int $id
 * @property string $name
 * @property int $active
 * @property string $created_at
 * @property string $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faculty whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faculty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faculty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faculty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Faculty whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Faculty extends Model
{

    public $timestamps = false;

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

}
