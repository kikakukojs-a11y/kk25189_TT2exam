<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

class TranslationHelper
{
    public static function __($text)
{
    if (blank($text) || is_numeric($text)) {
        return $text;
    }

    $targetLang = strtoupper(App::getLocale());

    if ($targetLang === 'EN') {
        return $text;
    }

    $apiKey = config('services.deepl.key');
    if (!$apiKey) {
        return $text;
    }

    $cacheKey = "translation_" . $targetLang . "_" . md5($text);

    return Cache::rememberForever($cacheKey, function () use ($text, $targetLang, $apiKey) {
        try {
            $response = Http::withoutVerifying()
    ->withHeaders([
        'Authorization' => 'DeepL-Auth-Key ' . config('services.deepl.key'),
    ])
    ->post('https://api-free.deepl.com/v2/__', [
        'text' => [$text],
        'target_lang' => strtoupper(app()->getLocale()),
    ]);

            if ($response->successful()) {
                return $response->json('translations.0.text') ?? $text;
            } else {
                logger('DeepL API Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            logger('Translation API Exception: ' . $e->getMessage());
        }

        return $text;
    });
}
}