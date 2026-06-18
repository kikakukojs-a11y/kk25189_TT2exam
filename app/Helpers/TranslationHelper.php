<?php

use Illuminate\Support\Facades\App;
use App\Services\TranslationService;

if (!function_exists('auto_translate')) {
    function auto_translate($text)
    {
        if (empty($text)) {
            return $text;
        }

        $locale = App::getLocale();

        if ($locale === 'en') {
            return $text;
        }

        $laravelTranslation = __($text);
        if ($laravelTranslation !== $text) {
            return $laravelTranslation;
        }

        try {

            $translationService = app(TranslationService::class);
            return $translationService->translate($text, $locale);
        } catch (\Exception $e) {

            return $text;
        }
    }
}