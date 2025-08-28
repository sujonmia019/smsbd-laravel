<?php

namespace SujonMia\Smsbd;

use Illuminate\Support\ServiceProvider;

class SMSServiceProvider extends ServiceProvider {

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->app->singleton('sms', function () {
            return new SMSService();
        });

        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-sms.php', 'laravel-sms'
        );
    }


    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/laravel-sms.php' => config_path('laravel-sms.php'),
        ], 'config');
    }

}
