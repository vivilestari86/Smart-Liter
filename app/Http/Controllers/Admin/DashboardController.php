<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalculationHistory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Pie chart: hitung distribusi kategori
        $counts = CalculationHistory::selectRaw("kategori, COUNT(*) as total")
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->groupBy('kategori')
            ->pluck('total', 'kategori'); // ['mati'=>2, 'sedikit'=>5, ...]

        $pie = [
            'mati' => (int)($counts['mati'] ?? 0),
            'sedikit' => (int)($counts['sedikit'] ?? 0),
            'banyak' => (int)($counts['banyak'] ?? 0),
        ];

        // Riwayat terbaru (ambil 8 terakhir)
        $latest = CalculationHistory::latest()->take(8)->get();

        return view('admin.dashboard', compact('pie', 'latest'));
    }

    // Uji umur: simulasi sederhana biar dinamis (nanti bisa diganti ke fuzzy asli)
    public function testUmur(Request $request)
{
    $data = $request->validate([
        'umur_hari' => ['required', 'numeric', 'min:0', 'max:120'],
    ]);

    $x = (float) $data['umur_hari'];

    // MUDA: trapesium [0, 0, 25, 30]
    $muda = $this->trapmf($x, 0, 0, 25, 30);

    // DEWASA: trapesium [25, 30, 75, 80]
    $dewasa = $this->trapmf($x, 25, 30, 75, 80);

    // TUA: trapesium [75, 80, 120, 120]
    $tua = $this->trapmf($x, 75, 80, 120, 120);

    return response()->json([
        'muda' => round($muda, 2),
        'dewasa' => round($dewasa, 2),
        'tua' => round($tua, 2),
    ]);
}

/**
 * Trapezoidal membership function.
 * a <= b <= c <= d
 */
private function trapmf(float $x, float $a, float $b, float $c, float $d): float
{
    // handle degenerate edges (a=b or c=d)
    if ($x <= $a) return 0.0;
    if ($x >= $d) return 0.0;

    if ($x >= $b && $x <= $c) return 1.0;

    if ($x > $a && $x < $b) {
        $den = ($b - $a);
        return $den == 0 ? 1.0 : ($x - $a) / $den;
    }

    // ($x > $c && $x < $d)
    $den = ($d - $c);
    return $den == 0 ? 1.0 : ($d - $x) / $den;
}


    private function clamp01(float $v): float
    {
        return max(0, min(1, $v));
    }
}
