<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Services\TranslationService;

class Category extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name'];


    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => app(TranslationService::class)->__((string)$value, app()->getLocale())
        );
    }

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
}