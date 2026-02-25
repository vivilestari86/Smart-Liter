<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FuzzyParameter extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'unit',
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(FuzzyCategory::class);
    }
}
