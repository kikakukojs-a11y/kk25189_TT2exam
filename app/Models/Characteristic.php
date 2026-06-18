<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Services\TranslationService;

class Characteristic extends Model
{
    protected $fillable = ['name'];


    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => app(TranslationService::class)->translate((string)$value, app()->getLocale())
        );
    }

    public function animals()
    {
        return $this->belongsToMany(Animal::class);
    }
}