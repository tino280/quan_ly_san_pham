<?php

namespace App\Providers;

use App\Repositories\Producer\ProducerRepository;
use App\Repositories\Producer\ProducerRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Slide\SlideRepository;
use App\Repositories\Slide\SlideRepositoryInterface;
use App\Repositories\Type\TypeRepository;
use App\Repositories\Type\TypeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(
            ProducerRepositoryInterface::class,
            ProducerRepository::class
        );

        $this->app->singleton(
            TypeRepositoryInterface::class, 
            TypeRepository::class
        );

        $this->app->singleton(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->singleton(
            SlideRepositoryInterface::class,
            SlideRepository::class    
        );
    }
}
