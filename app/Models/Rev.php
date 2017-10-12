<?php

namespace App\Models;

use Bavix\Diff\Differ;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Rev extends Model
{
    protected $table      = 'revs';
    public    $timestamps = false;

    public static function makeRev(Model $model, $newData, $column = 'content')
    {
        $old = $model->getAttribute($column);

        if ($model->id && $old && $old !== $newData)
        {
            $diff = new Differ();

            // revs
            $rev           = new static();
            $rev->patch    = $diff->diff($newData, $old);
            $rev->name     = $model->getTable();
            $rev->column   = $column;
            $rev->item_id  = $model->id;
            $rev->admin_id = Auth::guard('admin')->user()->id;
            $rev->save();
            // /revs
        }
    }

    /**
     * @param Model  $model
     * @param string $column
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function fromModel(Model $model, $column = 'content')
    {
        return static::query()
            ->where('name', $model->getTable())
            ->where('item_id', $model->id)
            ->where('column', $column)
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->get();
    }

}
