<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FuzzyParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

class FuzzyController extends Controller
{
    public function suhuUdara()
    {
        return $this->showBySlug('suhu-udara', 'admin.config_fuzzy.suhu_udara');
    }

    public function kelembapanUdara()
    {
        return $this->showBySlug('kelembapan-udara', 'admin.config_fuzzy.kelembapan_udara');
    }

    public function kelembapanTanah()
    {
        return $this->showBySlug('kelembapan-tanah', 'admin.config_fuzzy.kelembapan_tanah');
    }

    public function usiaTanaman()
    {
        return $this->showBySlug('usia-tanaman', 'admin.config_fuzzy.usia_tanaman');
    }

    public function output()
    {
        return $this->showBySlug('output', 'admin.config_fuzzy.output');
    }

    public function save(Request $request, string $slug): JsonResponse
    {
        $parameter = FuzzyParameter::with('categories')->where('slug', $slug)->firstOrFail();
        $knownCategories = $parameter->categories->keyBy('id');

        $validator = Validator::make(
            $request->all(),
            [
                'categories' => ['required', 'array', 'min:1'],
                'categories.*.id' => ['required', 'integer'],
                'categories.*.titik_a_x' => ['required', 'numeric'],
                'categories.*.titik_a_y' => ['required', 'numeric', 'between:0,1'],
                'categories.*.titik_b_x' => ['required', 'numeric'],
                'categories.*.titik_b_y' => ['required', 'numeric', 'between:0,1'],
                'categories.*.titik_c_x' => ['required', 'numeric'],
                'categories.*.titik_c_y' => ['required', 'numeric', 'between:0,1'],
                'categories.*.titik_d_x' => ['required', 'numeric'],
                'categories.*.titik_d_y' => ['required', 'numeric', 'between:0,1'],
            ]
        );

        $validator->after(function ($validator) use ($request, $knownCategories) {
            foreach ($request->input('categories', []) as $index => $categoryRow) {
                $categoryId = (int) ($categoryRow['id'] ?? 0);
                $category = $knownCategories->get($categoryId);

                if (! $category) {
                    $validator->errors()->add(
                        "categories.$index.id",
                        'Kategori tidak valid untuk parameter yang dipilih.'
                    );
                    continue;
                }

                if (! isset(
                    $categoryRow['titik_a_x'],
                    $categoryRow['titik_b_x'],
                    $categoryRow['titik_c_x'],
                    $categoryRow['titik_d_x']
                ) || ! is_numeric($categoryRow['titik_a_x']) || ! is_numeric($categoryRow['titik_b_x'])
                    || ! is_numeric($categoryRow['titik_c_x']) || ! is_numeric($categoryRow['titik_d_x'])) {
                    continue;
                }

                $ax = (float) $categoryRow['titik_a_x'];
                $bx = (float) $categoryRow['titik_b_x'];
                $cx = (float) $categoryRow['titik_c_x'];
                $dx = (float) $categoryRow['titik_d_x'];

                if (! ($ax <= $bx && $bx <= $cx && $cx <= $dx)) {
                    $validator->errors()->add(
                        "categories.$index.titik_a_x",
                        "Urutan titik X kategori {$category->name} harus A <= B <= C <= D."
                    );
                }
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $rows = $validator->validated()['categories'];
        $updatedCount = 0;

        DB::transaction(function () use ($rows, $knownCategories, &$updatedCount) {
            foreach ($rows as $row) {
                $category = $knownCategories->get((int) $row['id']);
                if (! $category) {
                    continue;
                }

                $category->update([
                    'titik_a_x' => $row['titik_a_x'],
                    'titik_a_y' => $row['titik_a_y'],
                    'titik_b_x' => $row['titik_b_x'],
                    'titik_b_y' => $row['titik_b_y'],
                    'titik_c_x' => $row['titik_c_x'],
                    'titik_c_y' => $row['titik_c_y'],
                    'titik_d_x' => $row['titik_d_x'],
                    'titik_d_y' => $row['titik_d_y'],
                ]);

                $updatedCount++;
            }
        });

        return response()->json([
            'message' => 'Konfigurasi berhasil disimpan.',
            'updated_count' => $updatedCount,
        ]);
    }

    public function test(Request $request, string $slug): JsonResponse
    {
        $parameter = FuzzyParameter::with('categories')->where('slug', $slug)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'nilai_uji' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $nilaiUji = (float) $validator->validated()['nilai_uji'];
        $hasil = $parameter->categories
            ->sortBy('id')
            ->map(function ($category) use ($nilaiUji) {
                $membership = $this->trapmf(
                    $nilaiUji,
                    (float) $category->titik_a_x,
                    (float) $category->titik_b_x,
                    (float) $category->titik_c_x,
                    (float) $category->titik_d_x
                );

                return [
                    'id' => $category->id,
                    'kategori' => $category->name,
                    'nilai' => round($membership, 4),
                ];
            })
            ->values();

        return response()->json([
            'nilai_uji' => $nilaiUji,
            'hasil' => $hasil,
        ]);
    }

    private function showBySlug(string $slug, string $view): View
    {
        $parameter = FuzzyParameter::with('categories')->where('slug', $slug)->firstOrFail();
        $categories = $parameter->categories->sortBy('id')->values();

        return view($view, compact('parameter', 'categories'));
    }

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

        if ($x > $c && $x <= $d) {
            $den = $d - $c;
            return $den == 0.0 ? 1.0 : ($d - $x) / $den;
        }

        return 0.0;
    }
}
