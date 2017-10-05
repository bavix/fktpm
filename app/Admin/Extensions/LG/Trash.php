<?php

namespace App\Admin\Extensions\LG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Trash extends Controller
{

    /**
     * @param Request $request
     *
     * @return array
     */
    public function index(Request $request)
    {
        $model   = $request->input('model', null);
        $itemId  = $request->input('itemId', null);
        $imageId = $request->input('imageId', null);

        if (!$itemId || !$imageId || !$model)
        {
            return ['result' => false];
        }

        $item = $model::query()->findOrFail($itemId);

        return ['result' => (bool)$item->images()->detach($imageId)];
    }

}
