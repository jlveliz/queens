<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Event;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $eventModel = new Event();
         view()->share('current_event',$eventModel->getCurrent());

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
