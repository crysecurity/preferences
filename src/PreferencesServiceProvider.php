<?php

namespace Cr4sec\Preferences;

use Illuminate\Support\ServiceProvider;

class PreferencesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
