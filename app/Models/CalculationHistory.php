<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculationHistory extends Model
{
    protected $fillable = [
        'ip','suhu','kelembapan_udara','kelembapan_tanah','usia_tanaman',
        'output_liter','kategori','deskripsi',
    ];
}
