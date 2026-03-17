<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

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
        View::composer('*', function ($view) {
        if (Auth::check()) {
            $unreadNotificationsCount = Notification::where('notifiable_type', 'App\Models\User')
                ->where('notifiable_id', Auth::id())
                ->whereNull('read_at')
                ->count();
            $view->with('unreadNotificationsCount', $unreadNotificationsCount);
        }
    });
    }
}
