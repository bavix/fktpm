<?php

namespace App\Http\Controllers;

use App\Models\File;
use Bavix\App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mimey\MimeTypes;

class FileController extends Controller
{

    public function getFile(Request $request, $hash)
    {
        /**
         * @var File $model
         */
        $model = File::query()
            ->where('hash', $hash)
            ->first();

        abort_if(!$model, 404);

        return redirect($model->url(), 301);
    }

    public function index(Request $request, $id)
    {
        /**
         * @var File $model
         */
        $model = File::query()->find($id);
        abort_if(!$model, 404);

        $url = $model->url();

        if ($url !== $request->url())
        {
            return \redirect($url, 301);
        }

        $mimes = new MimeTypes();

        header('X-Accel-Redirect: /stream/' . $model->path . '?' . $model->title . '.' . $model->type);
        header('Content-Type: ' . $mimes->getMimeType($model->type));
        header('Content-Disposition: inline;filename="' . $model->title . '.' . $model->type . '"');

        header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', Carbon::now()->addYear()->timestamp));

        die;
    }

}
