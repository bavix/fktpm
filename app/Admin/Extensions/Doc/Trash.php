<?php

namespace App\Admin\Extensions\Doc;

use Bavix\App\Http\Controllers\Controller;
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
        $model      = $request->input('model', null);
        $itemId     = $request->input('itemId', null);
        $documentId = $request->input('documentId', null);

        if (!$itemId || !$documentId || !$model)
        {
            return ['result' => false];
        }

        $item = $model::query()->findOrFail($itemId);

        return ['result' => (bool)$item->files()->detach($documentId)];
    }

}
