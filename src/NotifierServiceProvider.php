<?php

namespace Sinarajabpour1998\Notifier;

use Sinarajabpour1998\Notifier\Core\SMSNotifier;
use Sinarajabpour1998\Notifier\Facades\Notifier;
use Illuminate\Support\ServiceProvider;

class NotifierServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Notifier::shouldProxyTo(SMSNotifier::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
     public function boot()
     {
         $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

         $this->publishes([
             __DIR__.'/config/notifier.php' =>config_path('notifier.php')
         ], 'notifier');
     }
}
