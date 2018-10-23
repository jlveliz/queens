<?php

namespace App\Providers;

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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\RepositoryInterface\MissRepositoryInterface','App\Repository\MissRepository');
        $this->app->bind('App\RepositoryInterface\CityRepositoryInterface','App\Repository\CityRepository');
        $this->app->bind('App\RepositoryInterface\EventRepositoryInterface','App\Repository\EventRepository');
        $this->app->bind('App\RepositoryInterface\UserRepositoryInterface','App\Repository\UserRepository');
        
    }
}
