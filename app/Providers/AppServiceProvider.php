<?php

namespace App\Providers;

use App\Models\Setting;
use App\View\Composers\GoogleTagManagerComposer;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Vite::prefetch(concurrency: 3);

        View::composer(['app', 'layouts.landing'], GoogleTagManagerComposer::class);

        // Update fraud checker config from database settings
        try {
            if (class_exists(Setting::class)) {
                config([
                    'courier-fraud-checker-bd.pathao.user' => Setting::get('pathao_user') ?: config('courier-fraud-checker-bd.pathao.user'),
                    'courier-fraud-checker-bd.pathao.password' => Setting::get('pathao_password') ?: config('courier-fraud-checker-bd.pathao.password'),
                    'courier-fraud-checker-bd.redx.phone' => Setting::get('redx_phone') ?: config('courier-fraud-checker-bd.redx.phone'),
                    'courier-fraud-checker-bd.redx.password' => Setting::get('redx_password') ?: config('courier-fraud-checker-bd.redx.password'),
                    'courier-fraud-checker-bd.steadfast.user' => Setting::get('steadfast_user') ?: config('courier-fraud-checker-bd.steadfast.user'),
                    'courier-fraud-checker-bd.steadfast.password' => Setting::get('steadfast_password') ?: config('courier-fraud-checker-bd.steadfast.password'),
                    
                    // Steadfast Courier API credentials
                    'steadfast-courier.api_key' => Setting::get('steadfast_api_key') ?: config('steadfast-courier.api_key'),
                    'steadfast-courier.secret_key' => Setting::get('steadfast_secret_key') ?: config('steadfast-courier.secret_key'),
                ]);
            }
        } catch (\Exception $e) {
            // Silently fail if database is not available (e.g., during migrations)
        }
    }
}
