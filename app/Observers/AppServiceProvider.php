<?php

namespace App\Observers;

use App\Models\User;

class AppServiceProvider
{
    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
