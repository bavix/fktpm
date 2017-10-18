<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    protected $model       = Post::class;
    protected $withModel   = ['image', 'category', 'tagged'];
    protected $isCategory  = true;
    protected $route       = 'post';
    protected $title       = 'blocks.posts';
    protected $description = 'blocks.listPosts';

    protected $mainPage = false;
    protected $draft    = false;

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
        $query = $model::search($this->query);

        $query->orderBy('id', 'desc');
        $query->where('active', 1);

        if ($this->isCategory && $name === $this->route . '.category' && is_numeric($id))
        {
            $category = Category::query()->find($id);
            \abort_if($category === null, 404);

            $query->where('category_id', $id);

            $this->title = $category->title . ' / ' . $this->title;
        }

        if ($this->mainPage)
        {
            $query->where('main_page', 0);
        }

        $paginate = $query->paginate(config('limits.paginate', 10));
        $paginate->load($this->withModel);

        abort_if($paginate->lastPage() !== $paginate->currentPage() &&
            $paginate->isEmpty(), 404);

        return view('post.index', [
            'items'       => $paginate,
            'title'       => $this->title,
            'description' => __($this->description),
            // todo
            'message'     => __('blocks.empty', [
                'name' => __($this->title)
            ]),
            'searchBar'   => true,
            'selfRoute'   => $this->route,
            'query'       => $this->query
        ], $this->mergeData());
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
            $category = $model->category->title . ' / ';
        }

        return view('post.view', [
            'item'        => $model,
            'title'       => $model->title . ' / ' . $category . __($this->title),
            'description' => $model->description ?? ''
        ], $this->mergeData());
    }

}
