<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Department
 *
 * @property int $id
 * @property string $name
 * @property int $faculty_id
 * @property int $active
 * @property string $created_at
 * @property string $updated_at
 * @property-read \App\Models\Faculty $faculty
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Professor[] $professors
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Department extends Model
{

    public $timestamps = false;

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function professors()
    {
        return $this->hasMany(Professor::class);
    }

}
