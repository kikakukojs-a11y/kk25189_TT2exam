<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TranslationService
{
    public function translate(string $text, string $targetLang): string
    {
        if (blank($text) || is_numeric($text) || strtoupper($targetLang) === 'EN') {
            return $text;
        }

        return Cache::remember("trans_{$targetLang}_" . md5($text), 86400, function () use ($text, $targetLang) {
            try {
                $response = Http::withoutVerifying()
                    ->withHeaders([
                        'Authorization' => 'DeepL-Auth-Key ' . config('services.deepl.key'),
                    ])->post('https://api-free.deepl.com/v2/translate', [
                        'text' => [$text],
                        'target_lang' => strtoupper($targetLang),
                    ]);

                return $response->successful() ? ($response->json('translations.0.text') ?? $text) : $text;
            } catch (\Exception $e) {
                logger('DeepL API Exception: ' . $e->getMessage());
                return $text;
            }
        });
    }
}