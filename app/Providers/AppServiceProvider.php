<?php

namespace App\Providers;

use App\Events\UserCreated;
use App\Listeners\UserCreatedNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            UserCreated::class,
            UserCreatedNotification::class,
        );

        RateLimiter::for('comment', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip()); 
        });
    }
}
