<?php

namespace App\Providers;
use DeepL\Translator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }
    Mail::extend('brevo', function () {
            $key = config('services.brevo.key');
            
            return (new BrevoTransportFactory())->create(
                Dsn::fromString("brevo+api://{$key}@default")
            );
        });
    }
    
    
}

