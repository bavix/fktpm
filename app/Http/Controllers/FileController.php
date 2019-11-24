<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Tag;
use App\Services\FileService;
use App\Services\RouteService;
use App\Services\TagService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Mimey\MimeTypes;

class FileController extends BaseController
{

    /**
     * @param Request $request
     * @param Collection $tags
     * @return View
     */
    public function tag(Request $request, Collection $tags): View
    {
        $tag = $tags->first();
        $ids = app(TagService::class)
            ->getIdsBy(File::class, $tags);

        $query = File::with('tags')
            ->where('active', 1)
            ->whereIn('id', $ids);

        return view('file.tag', [
            'items' => $query->get(),
            'title' => 'Поиск по тегу: ' . $tag->name,
            'description' => __('descriptions.file.tag', ['name' => $tag->name])
        ]);
    }

    /**
     * Support for a very ancient version of the site
     *
     * @param Request $request
     * @param File $file
     * @return RedirectResponse
     */
    public function getFile(Request $request, File $file): RedirectResponse
    {
        return redirect(app(RouteService::class)->file($file), 301);
    }

    /**
     * @param Request $request
     * @param File $file
     * @return RedirectResponse
     */
    public function index(Request $request, File $file): RedirectResponse
    {
        $url = app(RouteService::class)
            ->file($file);

        if ($url !== $request->url()) {
            return redirect($url, 301);
        }

        app(FileService::class)
            ->download($file);

        $mimes = new MimeTypes();

        header('X-Accel-Redirect: /stream/' . $file->path . '?' . $file->title . '.' . $file->type);
        header('Content-Type: ' . $mimes->getMimeType($file->type));
        header('Content-Disposition: inline;filename="' . $file->title . '.' . $file->type . '"');

        header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', Carbon::now()->addYear()->timestamp));
        die; // nginx
    }

}
