<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSetting;

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
        // INI ADALAH KUNCI UTAMA:
        // Membuat variabel $userSettings tersedia di SEMUA halaman secara otomatis
        // Tanpa perlu membuat file Composer terpisah yang sering error
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('userSettings', UserSetting::getOrCreate(Auth::id()));
            }
        });
    }
}
