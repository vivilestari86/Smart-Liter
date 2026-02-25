<?php

namespace App\Http\Controllers\homepage;

use App\Http\Controllers\Controller;
use App\Models\CalculationHistory;
use App\Services\FuzzyCalculatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;

class LandingFuzzyController extends Controller
{
    public function __construct(private FuzzyCalculatorService $fuzzyCalculator)
    {
    }

    public function hitung(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'suhu' => ['required', 'numeric'],
            'kelembapan_udara' => ['required', 'numeric'],
            'kelembapan_tanah' => ['required', 'numeric'],
            'umur' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi input gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        try {
            $hasil = $this->fuzzyCalculator->calculate([
                'suhu' => (float) $data['suhu'],
                'kelembapan_udara' => (float) $data['kelembapan_udara'],
                'kelembapan_tanah' => (float) $data['kelembapan_tanah'],
                'usia_tanaman' => (float) $data['umur'],
            ]);
        } catch (RuntimeException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

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

        // Return JSON untuk AJAX di landing page.
        $hasilMl = (int) round($hasil['output_liter'] * 1000);

        return response()->json([
            'message' => 'Perhitungan berhasil.',
            'hasil_ml' => $hasilMl,
            'output_liter' => $hasil['output_liter'],
            'kategori' => $hasil['kategori'] ?? null,
            'deskripsi' => $hasil['deskripsi'] ?? null,
            'debug_rules' => $hasil['debug_rules'] ?? null,
        ]);
    }
}
