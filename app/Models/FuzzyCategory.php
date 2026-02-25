<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FuzzyCategory extends Model
{
    protected $fillable = [
        'fuzzy_parameter_id',
        'name',
        'titik_a_x',
        'titik_a_y',
        'titik_b_x',
        'titik_b_y',
        'titik_c_x',
        'titik_c_y',
        'titik_d_x',
        'titik_d_y',
    ];

    protected $casts = [
        'titik_a_x' => 'decimal:2',
        'titik_a_y' => 'decimal:2',
        'titik_b_x' => 'decimal:2',
        'titik_b_y' => 'decimal:2',
        'titik_c_x' => 'decimal:2',
        'titik_c_y' => 'decimal:2',
        'titik_d_x' => 'decimal:2',
        'titik_d_y' => 'decimal:2',
    ];

    public function parameter(): BelongsTo
    {
        return $this->belongsTo(FuzzyParameter::class, 'fuzzy_parameter_id');
    }
}
