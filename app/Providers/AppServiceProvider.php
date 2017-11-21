<?php

namespace App\Providers;

use App\Models\Image;
use App\Observers\ImageObserver;
use Encore\Admin\Config\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Image::observe(ImageObserver::class);

        try
        {
            Config::load();
        }
        catch (\Throwable $throwable)
        {
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production' && class_exists(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class))
        {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        //
    }
}
