<?php

namespace App\Providers;

use App\Nova\Metrics\DownloadsPerDay;
use App\Nova\Metrics\NewCategories;
use App\Nova\Metrics\NewCouples;
use App\Nova\Metrics\NewDepartments;
use App\Nova\Metrics\NewFaculties;
use App\Nova\Metrics\NewFiles;
use App\Nova\Metrics\NewImages;
use App\Nova\Metrics\NewLinks;
use App\Nova\Metrics\NewPosts;
use App\Nova\Metrics\NewProfessors;
use App\Nova\Metrics\NewTags;
use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            (new DownloadsPerDay()),
            (new NewCategories()),
            (new NewCouples()),
            (new NewFaculties()),
            (new NewDepartments()),
            (new NewProfessors()),
            (new NewImages()),
            (new NewPosts()),
            (new NewTags()),
            (new NewLinks()),
            (new NewFiles()),
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [

        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
