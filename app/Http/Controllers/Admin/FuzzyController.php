<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FuzzyController extends Controller
{
    public function suhuUdara()
    {
        return view('admin.config_fuzzy.suhu_udara');
    }

    public function kelembapanUdara()
    {
        return view('admin.config_fuzzy.kelembapan_udara');
    }

    public function kelembapanTanah()
    {
        return view('admin.config_fuzzy.kelembapan_tanah');
    }

    public function usiaTanaman()
    {
        return view('admin.config_fuzzy.usia_tanaman');
    }
}
