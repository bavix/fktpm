<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Department $department
 * @property-read string $full_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Professor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Professor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Professor query()
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

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name;
    }

    /**
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

}
