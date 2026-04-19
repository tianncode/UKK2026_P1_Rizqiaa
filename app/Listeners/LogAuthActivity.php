<?php

namespace App\Listeners;

use App\Services\ActivityLogService;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class LogAuthActivity
{
    public function handleLogin(Login $event): void
    {
        ActivityLogService::login($event->user->id);
    }

    public function handleLogout(Logout $event): void
    {
        if ($event->user) {
            ActivityLogService::log(
                'logout',
                'auth',
                'User logout',
                null,
                $event->user->id
            );
        }
    }
}
