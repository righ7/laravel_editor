<?php

namespace App\Providers\Admin;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Admin\Repositories\PostRepository::class, \App\Admin\Repositories\PostRepositoryEloquent::class);
        //:end-bindings:
    }
}
