<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;
use App\Helpers\TranslationHelper;

class PreTranslateWebsite extends Command
{
    protected $signature = 'app:pre-translate {lang}';
    protected $description = 'Cache';

    public function handle()
    {
        $targetLang = strtolower($this->argument('lang'));
        $pattern = '/(?:tr|___)\(\s*[\'"]([^\'"]+)[\'"]\s*\)/';
        $foundStrings = [];

        foreach (File::allFiles(resource_path('views')) as $file) {
            if ($file->getExtension() === 'php') {
                if (preg_match_all($pattern, File::get($file), $matches)) {
                    foreach ($matches[1] as $string) {
                        $foundStrings[$string] = true;
                    }
                }
            }
        }

        $originalLocale = App::getLocale();
        App::setLocale($targetLang);

        foreach (array_keys($foundStrings) as $string) {
            TranslationHelper::__($string);
        }

        App::setLocale($originalLocale);
    }
}