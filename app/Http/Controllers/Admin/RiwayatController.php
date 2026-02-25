<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalculationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $year     = $request->query('year', 'all');
        $month    = $request->query('month', 'all');
        $kategori = $request->query('kategori', 'all');

        $baseQuery = CalculationHistory::query();

        $driver = DB::connection()->getDriverName(); // sqlite / mysql / pgsql

        // Filter tahun & bulan: beda function tiap DB
        if ($year !== 'all') {
            if ($driver === 'sqlite') {
                $baseQuery->whereRaw("strftime('%Y', created_at) = ?", [(string)$year]);
            } else {
                $baseQuery->whereYear('created_at', (int)$year);
            }
        }

        if ($month !== 'all') {
            if ($driver === 'sqlite') {
                $mm = str_pad((string)$month, 2, '0', STR_PAD_LEFT); // 01..12
                $baseQuery->whereRaw("strftime('%m', created_at) = ?", [$mm]);
            } else {
                $baseQuery->whereMonth('created_at', (int)$month);
            }
        }

        if ($kategori !== 'all') {
            $baseQuery->where('kategori', $kategori);
        }

        $histories = (clone $baseQuery)->latest()->paginate(8)->withQueryString();

        // ===== SUMMARY + CHART DATA (tambahan) =====
        $base = clone $baseQuery; // base filter yang sama (tanpa efek pagination)

        // Total perhitungan hari ini (mengikuti filter yang dipilih)
        $totalHariIni = (clone $base)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Tamu unik (mengikuti filter)
        $tamuUnik = (clone $base)
            ->whereNotNull('ip')
            ->distinct('ip')
            ->count('ip');

        // Rata-rata output (mengikuti filter)
        $rataOutput = (clone $base)->avg('output_liter');
        $rataOutput = $rataOutput ? round($rataOutput, 2) : 0;

        // Pie distribusi kategori (mati/sedikit/banyak) mengikuti filter
        $pieCounts = (clone $base)
            ->reorder() // <--- ini kuncinya: hapus ORDER BY yang kebawa
            ->selectRaw("kategori, COUNT(*) as total")
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        $pie = [
            'mati' => (int)($pieCounts['mati'] ?? 0),
            'sedikit' => (int)($pieCounts['sedikit'] ?? 0),
            'banyak' => (int)($pieCounts['banyak'] ?? 0),
        ];

        // Line chart per jam (0-23) mengikuti filter
        if ($driver === 'sqlite') {
            $hourCounts = (clone $base)
                ->selectRaw("strftime('%H', created_at) as h, COUNT(*) as total")
                ->groupBy('h')
                ->pluck('total', 'h'); // key '00'..'23'
        } else {
            $hourCounts = (clone $base)
                ->reorder()
                ->selectRaw("HOUR(created_at) as h, COUNT(*) as total")
                ->groupBy('h')
                ->pluck('total', 'h');
        }

        $perJam = [];
        for ($h=0; $h<=23; $h++) {
            $key = $driver === 'sqlite'
                ? str_pad((string)$h, 2, '0', STR_PAD_LEFT)
                : $h;

            $perJam[] = (int)($hourCounts[$key] ?? 0);
        }


        // ===== Dropdown Tahun (dari data, kalau kosong fallback range) =====
        if ($driver === 'sqlite') {
            $yearsFromDb = CalculationHistory::selectRaw("strftime('%Y', created_at) as y")
                ->whereNotNull('created_at')
                ->distinct()->orderByDesc('y')
                ->pluck('y')->filter()->values();
        } else {
            $yearsFromDb = CalculationHistory::selectRaw("YEAR(created_at) as y")
                ->whereNotNull('created_at')
                ->distinct()->orderByDesc('y')
                ->pluck('y')->filter()->values();
        }

        $nowYear = Carbon::now()->year;
        $yearsFallback = collect(range($nowYear, $nowYear - 5)); // contoh: 2026..2021
        $years = $yearsFromDb
            ->merge($yearsFallback)
            ->unique()
            ->sortDesc()
            ->values();

        // ===== Dropdown Kategori (dari data, kalau kosong fallback default) =====
        $kategorisFromDb = CalculationHistory::select('kategori')
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $kategorisDefault = collect(['mati', 'sedikit', 'banyak']);

        $kategoris = $kategorisFromDb
            ->map(fn($v) => strtolower(trim($v)))
            ->merge($kategorisDefault)
            ->unique()
            ->values();

        return view('admin.riwayat.index', compact(
            'histories', 'years', 'kategoris', 'year', 'month', 'kategori',
                    'totalHariIni', 'tamuUnik', 'rataOutput', 'pie', 'perJam'
        ));
    }
}
