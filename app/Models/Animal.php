<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Services\TranslationService;

class Animal extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 
        'name', 
        'breed', 
        'age', 
        'description', 
        'status',
        'image'
    ];


    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => app(TranslationService::class)->__((string)$value, app()->getLocale())
        );
    }


    protected function breed(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => app(TranslationService::class)->__((string)$value, app()->getLocale())
        );
    }


    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => app(TranslationService::class)->__((string)$value, app()->getLocale())
        );
    }


    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => app(TranslationService::class)->__((string)$value, app()->getLocale())
        );
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'animal_id', 'user_id')->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function characteristics()
    {
        return $this->belongsToMany(Characteristic::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}