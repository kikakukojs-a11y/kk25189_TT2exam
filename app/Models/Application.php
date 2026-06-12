<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Services\TranslationService;

class Application extends Model
{
    protected $fillable = [
        'user_id', 
        'animal_id', 
        'status',
        'date'
    ];


    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => app(TranslationService::class)->__((string)$value, app()->getLocale())
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}