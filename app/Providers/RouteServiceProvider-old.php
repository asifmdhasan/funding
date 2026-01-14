<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Middleware\LoginAuthMiddleware;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        Route::middleware('web')
        ->middlewareGroup('admin', [LoginAuthMiddleware::class]) // group হিসেবে
        ->group(base_path('routes/web.php'));

        Route::aliasMiddleware('admin', LoginAuthMiddleware::class); // individual alias হিসেবে


        // // $this->configureRateLimiting();

        // $this->routes(function () {
        //     Route::middleware('api')
        //         ->prefix('api')
        //         ->group(base_path('routes/api.php'));

        //     Route::middleware('web')
        //         ->group(base_path('routes/web.php'));
        // });
    }
    
    // protected function configureRateLimiting()
    // {
    //     RateLimiter::for('api', function (Request $request) {
    //         return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
    //     });
    // }
}
