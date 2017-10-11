<?php

namespace App\Models;

use App\Helpers\Diff;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Rev extends Model
{
    protected $table = 'revs';
    public $timestamps = false;

    public static function makeRev(Model $model, $newData, $column = 'content')
    {
        $old = $model->getAttribute($column);

        if ($model->id && $old && \function_exists('xdiff_string_rabdiff'))
        {
            // revs
            $rev          = new static();
            $rev->patch   = Diff::diff($newData, $old);
            $rev->name    = $model->getTable();
            $rev->item_id = $model->id;
            $rev->admin_id = Auth::guard('admin')->user()->id;
            $rev->save();
            // /revs
        }
    }

    public static function fromModel(Model $model)
    {
        return static::query()
            ->where('name', $model->getTable())
            ->where('item_id', $model->id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

}
