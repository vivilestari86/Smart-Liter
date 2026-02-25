<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalculationHistory;
use App\Models\FuzzyParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        // Pie chart: hitung distribusi kategori
        $counts = CalculationHistory::selectRaw('kategori, COUNT(*) as total')
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        $pie = [
            'mati' => (int) ($counts['mati'] ?? 0),
            'sedikit' => (int) ($counts['sedikit'] ?? 0),
            'banyak' => (int) ($counts['banyak'] ?? 0),
        ];

        // Riwayat terbaru (ambil 8 terakhir)
        $latest = CalculationHistory::latest('created_at')->take(8)->get();
        $usiaChartData = $this->getUsiaCategories()->values()->all();

        return view('admin.dashboard', compact('pie', 'latest', 'usiaChartData'));
    }

    // Uji umur dinamis berdasarkan konfigurasi fuzzy usia tanaman di database.
    public function testUmur(Request $request)
    {
        $data = $request->validate([
            'umur_hari' => ['required', 'numeric', 'min:0'],
        ]);

        $x = (float) $data['umur_hari'];
        $memberships = $this->getUsiaCategories()
            ->map(function (array $category) use ($x) {
                $value = round(
                    $this->trapmf(
                        $x,
                        $category['titik_a_x'],
                        $category['titik_b_x'],
                        $category['titik_c_x'],
                        $category['titik_d_x']
                    ),
                    2
                );

                return [
                    'name' => $category['name'],
                    'value' => $value,
                ];
            })
            ->values();

        $response = [
            'memberships' => $memberships,
        ];

        foreach ($memberships as $membership) {
            $key = (string) Str::of((string) $membership['name'])
                ->trim()
                ->lower()
                ->replace(' ', '_');

            $response[$key] = $membership['value'];
        }

        return response()->json($response);
    }

    /**
     * Trapezoidal membership function.
     * a <= b <= c <= d
     */
    private function trapmf(float $x, float $a, float $b, float $c, float $d): float
    {
        if (! ($a <= $b && $b <= $c && $c <= $d)) {
            return 0.0;
        }

        if ($x < $a || $x > $d) {
            return 0.0;
        }

        if ($x >= $b && $x <= $c) {
            return 1.0;
        }

        if ($x >= $a && $x < $b) {
            $den = $b - $a;
            return $den == 0.0 ? 1.0 : ($x - $a) / $den;
        }

        $den = $d - $c;
        return $den == 0.0 ? 1.0 : ($d - $x) / $den;
    }

    private function getUsiaCategories(): Collection
    {
        $parameter = FuzzyParameter::with([
            'categories' => function ($query) {
                $query->orderBy('id');
            },
        ])->where('slug', 'usia-tanaman')->first();

        if (! $parameter || $parameter->categories->isEmpty()) {
            return collect([
                [
                    'name' => 'Muda',
                    'titik_a_x' => 0.0, 'titik_a_y' => 1.0,
                    'titik_b_x' => 0.0, 'titik_b_y' => 1.0,
                    'titik_c_x' => 25.0, 'titik_c_y' => 1.0,
                    'titik_d_x' => 30.0, 'titik_d_y' => 0.0,
                ],
                [
                    'name' => 'Dewasa',
                    'titik_a_x' => 25.0, 'titik_a_y' => 0.0,
                    'titik_b_x' => 35.0, 'titik_b_y' => 1.0,
                    'titik_c_x' => 65.0, 'titik_c_y' => 1.0,
                    'titik_d_x' => 80.0, 'titik_d_y' => 0.0,
                ],
                [
                    'name' => 'Tua',
                    'titik_a_x' => 75.0, 'titik_a_y' => 0.0,
                    'titik_b_x' => 120.0, 'titik_b_y' => 1.0,
                    'titik_c_x' => 300.0, 'titik_c_y' => 1.0,
                    'titik_d_x' => 300.0, 'titik_d_y' => 1.0,
                ],
            ]);
        }

        return $parameter->categories->map(function ($category) {
            return [
                'name' => (string) $category->name,
                'titik_a_x' => (float) $category->titik_a_x,
                'titik_a_y' => (float) $category->titik_a_y,
                'titik_b_x' => (float) $category->titik_b_x,
                'titik_b_y' => (float) $category->titik_b_y,
                'titik_c_x' => (float) $category->titik_c_x,
                'titik_c_y' => (float) $category->titik_c_y,
                'titik_d_x' => (float) $category->titik_d_x,
                'titik_d_y' => (float) $category->titik_d_y,
            ];
        });
    }
}
