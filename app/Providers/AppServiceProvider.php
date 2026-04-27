<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Listeners\LogAuthActivity;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Event::listen(Login::class, [LogAuthActivity::class, 'handleLogin']);
        Event::listen(Logout::class, [LogAuthActivity::class, 'handleLogout']);
    }
}
