<?php

namespace App\Providers;

use App\Interfaces\BookingRepositoryContract;
use App\Interfaces\TourRepositoryContract;
use App\Repositories\BookingRepository;
use App\Repositories\TourRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(BookingRepositoryContract::class, BookingRepository::class);
        $this->app->bind(TourRepositoryContract::class, TourRepository::class);
    }
}
