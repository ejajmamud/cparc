<?php

namespace App\Providers;

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
        \Illuminate\Pagination\Paginator::useBootstrapFour();
        if (config('app.env') === 'production' || env('FORCE_HTTPS', false)) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Dynamically override mail configuration from settings
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                config([
                    'mail.mailers.smtp.host' => \App\Models\Setting::getVal('smtp_host', config('mail.mailers.smtp.host')),
                    'mail.mailers.smtp.port' => \App\Models\Setting::getVal('smtp_port', config('mail.mailers.smtp.port')),
                    'mail.mailers.smtp.username' => \App\Models\Setting::getVal('smtp_username', config('mail.mailers.smtp.username')),
                    'mail.mailers.smtp.password' => \App\Models\Setting::getVal('smtp_password', config('mail.mailers.smtp.password')),
                    'mail.mailers.smtp.encryption' => \App\Models\Setting::getVal('smtp_encryption', config('mail.mailers.smtp.encryption')),
                    'mail.from.address' => \App\Models\Setting::getVal('smtp_from_address', config('mail.from.address')),
                    'mail.from.name' => \App\Models\Setting::getVal('smtp_from_name', config('mail.from.name')),
                ]);
            }
        } catch (\Exception $e) {
            // Silence exception if database is not set up during build/cli runs
        }
    }
}
