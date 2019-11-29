<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\File;
use App\Models\Image;
use App\Models\Post;
use App\Models\Professor;
use App\Models\Tag;
use App\Observers\ImageObserver;
use App\Services\FileService;
use App\Services\HumanService;
use App\Services\ImageService;
use App\Services\LinkService;
use App\Services\PostService;
use App\Services\RouteService;
use App\Services\SeoService;
use App\Services\TagService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Image::observe(ImageObserver::class);
        $this->professorBind();
        $this->categoryBind();
        $this->fileBind();
        $this->postBind();
        $this->tagBind();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(PostService::class);
        $this->app->singleton(HumanService::class);
        $this->app->singleton(FileService::class);
        $this->app->singleton(RouteService::class);
        $this->app->singleton(ImageService::class);
        $this->app->singleton(LinkService::class);
        $this->app->singleton(TagService::class);
        $this->app->singleton(SeoService::class);
    }

    /**
     * @return void
     */
    protected function categoryBind(): void
    {
        Route::bind('category', static function (int $categoryId) {
            return Category::findOrFail($categoryId);
        });
    }

    /**
     * @return void
     */
    protected function postBind(): void
    {
        Route::bind('post', static function (int $postId) {
            return Post::with(['image', 'category'])
                ->where('active', 1)
                ->findOrFail($postId);
        });
    }

    /**
     * @return void
     */
    protected function fileBind(): void
    {
        Route::bind('hash', static function (string $hash) {
            return File::query()
                ->where('hash', $hash)
                ->where('active', 1)
                ->firstOrFail();
        });

        Route::bind('file', static function (int $fileId) {
            return File::query()
                ->where('active', 1)
                ->findOrFail($fileId);
        });
    }

    /**
     * @return void
     */
    protected function tagBind(): void
    {
        Route::bind('tag', static function (string $slug) {
            $tags = Tag::query()
                ->where('slug->ru', $slug)
                ->get();

            abort_if(!$tags->count(), 404);

            return $tags;
        });
    }

    /**
     * @return void
     */
    protected function professorBind(): void
    {
        Route::bind('professor', static function (int $rateId) {
            return Professor::query()
                ->where('active', 1)
                ->where('professorrating', $rateId)
                ->firstOrFail();
        });
    }

}
