<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\File;
use App\Models\Tag;
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
            ->where('active', 1)
            ->firstOrFail();

        header('location: ' . $model->url(), true, 301);
        die;
    }

    public function tag(Request $request, $slug)
    {
        /**
         * @var Tag $tag
         */
        $tag = Tag::query()
            ->where('slug->ru', $slug)
            ->firstOrFail();

        $query = $tag->files()
            ->with('tags')
            ->where('active', 1);

        return $this->render('file.tag', [
            'items' => $query->get(),
            'title'       => 'Поиск по тегу: ' . $tag->name,
            'description' => __('descriptions.file.tag', ['name' => $tag->name])
        ]);
    }

    public function index(Request $request, $id)
    {
        /**
         * @var File $model
         */
        $model = File::query()
            ->where('active', 1)
            ->findOrFail($id);

        $url = $model->url();

        if ($url !== $request->url())
        {
            header('location: ' . $model->url(), true, 301);
            die;
        }

        Download::addDownload($id);

        $mimes = new MimeTypes();

        header('X-Accel-Redirect: /stream/' . $model->path . '?' . $model->title . '.' . $model->type);
        header('Content-Type: ' . $mimes->getMimeType($model->type));
        header('Content-Disposition: inline;filename="' . $model->title . '.' . $model->type . '"');

        header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', Carbon::now()->addYear()->timestamp));
        die;
    }

}
