<?php

namespace App\Http\Controllers\homepage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalculationHistory;

class LandingFuzzyController extends Controller
{
    public function hitung(Request $request)
    {
        $data = $request->validate([
            'suhu' => 'required|numeric',
            'kelembapan_udara' => 'required|numeric',
            'kelembapan_tanah' => 'required|numeric',
            'umur' => 'required|numeric',
        ]);

        // HITUNG FUZZY (isi sesuai logic kamu)
        $hasil = $this->hitungFuzzy([
            'suhu' => (float) $data['suhu'],
            'kelembapan_udara' => (float) $data['kelembapan_udara'],
            'kelembapan_tanah' => (float) $data['kelembapan_tanah'],
            'usia_tanaman' => (int) $data['umur'],
        ]);

        /**
         * $hasil minimal berisi:
         * - output_liter (float)
         * - kategori (string)
         * - deskripsi (string)
         * Optional:
         * - debug_rules (array)
         */

        // SIMPAN RIWAYAT (untuk admin)
        CalculationHistory::create([
            'ip' => $request->ip(),
            'suhu' => $data['suhu'],
            'kelembapan_udara' => $data['kelembapan_udara'],
            'kelembapan_tanah' => $data['kelembapan_tanah'],
            'usia_tanaman' => (int) $data['umur'],
            'output_liter' => $hasil['output_liter'],
            'kategori' => $hasil['kategori'] ?? null,
            'deskripsi' => $hasil['deskripsi'] ?? null,
        ]);

        // TAMPILKAN di landing (blade kamu pakai ml/hari)
        $hasilMl = (int) round($hasil['output_liter'] * 1000);

        return redirect()->route('home')
            ->with('hasil', $hasilMl)
            ->with('debug_rules', $hasil['debug_rules'] ?? null);
    }

    private function hitungFuzzy(array $x): array
    {
        // ======================================================
        // TODO: MASUKKAN LOGIC FUZZY ASLI PUNYA KAMU DI SINI
        // ======================================================

        // Placeholder biar tidak error (GANTI!)
        $output_liter = max(0.1, 0.3 + ($x['suhu'] * 0.01) + (max(0, 50 - $x['kelembapan_tanah']) * 0.02));

        return [
            'output_liter' => round($output_liter, 2),
            'kategori' => 'Normal',
            'deskripsi' => 'Rekomendasi sementara (silakan ganti sesuai rule fuzzy asli).',
            'debug_rules' => null,
        ];
    }
}
