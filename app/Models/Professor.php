<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Professor
 *
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 * @property int|null $professorrating
 * @property int $department_id
 * @property int $active
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Professor whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Professor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Professor whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Professor whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Professor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Professor whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Professor whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Professor whereProfessorrating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Professor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Professor extends Model
{
    protected $table      = 'professors';
    public    $timestamps = false;
}
