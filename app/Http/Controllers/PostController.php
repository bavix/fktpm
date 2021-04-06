<?php

namespace App\Http\Controllers;

use App\Http\Kernel;
use App\Models\Category;
use App\Models\Post;
use App\Services\TagService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class PostController extends BaseController
{

    /**
     * @var string
     */
    protected $title = 'Посты из инстаграмма #fktpm';

    /**
     * @var string
     */
    protected $description = 'descriptions.posts';

    /**
     * @param Request $request
     * @param Collection $tags
     * @return View
     */
    public function tag(Request $request, Collection $tags): View
    {
        $tag = $tags->first(); // get first tag

        $postIds = app(TagService::class)
            ->getIdsByClass(Post::class, $tags);

        abort_if(!count($postIds), 404);

        $paginate = Post::with(['image', 'category', 'tags'])
            ->whereIn('id', $postIds)
            ->where('active', 1)
            ->orderBy('id', 'desc')
            ->simplePaginate();

        abort_if($paginate->isEmpty(), 404);

        return view('post.index', [
            'items' => $paginate,
            'title' => trans('Поиск по тегу: :tag  — :title', [
                'tag' => $tag->name,
                'title' => $this->title
            ]),
            'description' => trans($this->description),
        ]);
    }

    /**
     * @param Request $request
     * @param string $username
     * @return View
     */
    public function username(Request $request, string $username): View
    {
        $paginate = Post::with(['image', 'category', 'tags'])
            ->where('user_name', $username)
            ->orderBy('id', 'desc')
            ->simplePaginate();

        abort_if($paginate->isEmpty(), 404);

        return view('post.index', [
            'items' => $paginate,
            'title' => trans('Фильтрация по пользователю: :username  — :title', [
                'username' => $username,
                'title' => $this->title
            ]),
            'description' => trans($this->description),
        ]);
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return View
     */
    public function category(Request $request, Category $category): View
    {
        $paginate = $category->posts()
            ->with(['image', 'category', 'tags'])
            ->where('active', 1)
            ->orderBy('id', 'desc')
            ->simplePaginate();

        abort_if($paginate->isEmpty(), 404);

        return view('post.index', [
            'items' => $paginate,
            'title' => trans(':category — :title', [
                'category' => $category->title,
                'title' => $this->title,
            ]),
            'description' => trans($this->description),
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $paginate = Post::with(['image', 'category', 'tags'])
            ->where('active', 1)
            ->orderBy('id', 'desc')
            ->simplePaginate();

        abort_if($paginate->isEmpty(), 404);

        return view('post.index', [
            'items' => $paginate,
            'title' => trans(':title', ['title' => $this->title]),
            'description' => trans($this->description),
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @param Post $post
     *
     * @return View
     */
    public function view(Request $request, Post $post): View
    {
        $category = '';
        if (method_exists($post, 'category')) {
            $category = $post->category->title . ' — ';
        }

        return view('post.view', [
            'item' => $post,
            'title' => trans(':post — :title', [
                'post' => $post->title,
                'title' => $category . $this->title,
            ]),
            'description' => trans($post->description ?? ''),
        ]);
    }

}
