<?php

namespace App\Providers;

class AdminServiceProvider extends \Encore\Admin\AdminServiceProvider
{

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->loadViewsFrom(null, 'admin');
    }

}
