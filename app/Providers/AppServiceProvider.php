<?php

namespace App\Providers;
use DeepL\Translator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
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
        //
    }
    
}
function __($text) {
    $locale = app()->getLocale();
    
    if ($locale === 'en' || empty($text)) {
        return $text;
    }

    $cacheKey = 'deepl_' . $locale . '_' . md5($text);

    return Cache::rememberForever($cacheKey, function () use ($text, $locale) {
        $translator = new Translator(config('services.deepl.key'));
        $__d = $translator->__Text($text, 'en', $locale);
        return $__d->text;
    });
}

