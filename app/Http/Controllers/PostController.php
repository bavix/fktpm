<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Bavix\App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    protected $model       = Post::class;
    protected $withModel   = ['image', 'category'];
    protected $isCategory  = true;
    protected $route       = 'post';
    protected $title       = 'bavix.controllers.posts';
    protected $description = 'descriptions.posts';

    protected $mainPage = false;
    protected $draft    = false;
    protected $tag      = false;

    protected $query;

    /**
     * @param Request $request
     * @param string  $query
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function search(Request $request, $query = null)
    {
        if ($query === null)
        {
            $query = (string)$request->query('query');

            abort_if($query === null, 400);

            return redirect(route($request->route()->getName(), [
                'query' => urlencode($request->query('query'))
            ]));
        }

        $this->query = urldecode($query);

        return $this->index($request);
    }

    public function tag(Request $request, $tag)
    {
        $this->tag = $tag;
        return $this->index($request);
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id = null)
    {

        $name        = $request->route()->getName();
        $model       = $this->model;
        $this->title = __($this->title);

        /**
         * @var \Illuminate\Database\Eloquent\Builder $query
         */
        $query = $this->query ?
            $model::search($this->query) :
            $model::query();

        $query->where('active', 1);

        if ($this->tag)
        {
            $slug = $this->tag;
            $query->whereHas('tagged', function (\Illuminate\Database\Eloquent\Builder $query) use ($slug) {
                $query->where('tag_slug', $slug);
            });
        }

        if ($this->isCategory && $name === $this->route . '.category' && is_numeric($id))
        {
            $category = Category::query()->find($id);
            \abort_if($category === null, 404);

            $query->where('category_id', $id);

            $this->title = $category->title . ' — ' . $this->title;
        }

        if ($this->mainPage)
        {
            $query->where('main_page', 0);
        }

        $sort = $request->query('sort');

        if (!is_array($sort))
        {
            $sort = [
                config('sort.column', 'id') => config('sort.direction', 'desc')
            ];
        }

        foreach ($sort as $column => $direction)
        {
            $query->orderBy($column, $direction);
        }

        $paginate = $query->paginate(config('limits.paginate', 10));
        $paginate->load($this->withModel);

        $empty = $paginate->isEmpty();

        abort_if($paginate->lastPage() !== $paginate->currentPage() &&
            $empty, 404);

        $view = view(
            'post.index',
            [
                'hasError'    => $empty,
                'items'       => $paginate,
                'title'       => $this->title,
                'description' => __($this->description),
                'message'     => __('bavix.page.empty', [
                    'name' => __($this->title)
                ]),
                'searchBar'   => true,
                'selfRoute'   => $this->route,
                'query'       => $this->query
            ]
        );

        return response($view, $empty ? 404 : 200);
    }

    public function draft(Request $request, $id)
    {
        abort_if(!Auth::guard('admin')->user(), 404);

        $this->draft = true;

        return $this->view($request, $id);
    }

    /**
     * Show the application dashboard.
     *
     * @param Request   $request
     * @param int|Model $id
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        $modelName = $this->model;
        $model     = $modelName::query();

        if (!$this->draft)
        {
            $model->where('active', 1);
        }

        $model = \is_object($id) ? $id : $model->find($id);

        \abort_if(!$model, 404);

        // if main page, disable *.view
        \abort_if(
            !$this->draft &&
            $this->mainPage &&
            $model->main_page &&
            $request->route()->getName() !== 'home',
            404
        );

        $category = '';

        if (method_exists($model, 'category'))
        {
            $category = $model->category->title . ' — ';
        }

        return view('post.view', [
            'item'        => $model,
            'title'       => $model->title . ' — ' . $category . __($this->title),
            'description' => $model->description ?? ''
        ]);
    }

}
