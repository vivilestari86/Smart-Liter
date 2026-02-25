<?php

namespace Database\Seeders;

use App\Models\FuzzyCategory;
use App\Models\FuzzyParameter;
use Illuminate\Database\Seeder;

class FuzzyConfigSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $dataset = [
            [
                'name' => 'Suhu Udara',
                'slug' => 'suhu-udara',
                'unit' => '°C',
                'categories' => [
                    ['name' => 'Dingin', 'points' => [0, 1, 0, 1, 20, 1, 30, 0]],
                    ['name' => 'Normal', 'points' => [25, 0, 30, 1, 35, 1, 40, 0]],
                    ['name' => 'Panas', 'points' => [30, 0, 40, 1, 100, 1, 100, 1]],
                ],
            ],
            [
                'name' => 'Kelembapan Udara',
                'slug' => 'kelembapan-udara',
                'unit' => '%',
                'categories' => [
                    ['name' => 'Lembab', 'points' => [35, 0, 45, 1, 55, 1, 65, 0]],
                    ['name' => 'Kering', 'points' => [0, 1, 0, 1, 20, 1, 40, 0]],
                    ['name' => 'Basah', 'points' => [60, 0, 85, 1, 100, 1, 100, 1]],
                ],
            ],
            [
                'name' => 'Kelembapan Tanah',
                'slug' => 'kelembapan-tanah',
                'unit' => '%',
                'categories' => [
                    ['name' => 'Rendah', 'points' => [0, 1, 0, 1, 30, 1, 50, 0]],
                    ['name' => 'Sedang', 'points' => [45, 0, 55, 1, 60, 1, 70, 0]],
                    ['name' => 'Tinggi', 'points' => [65, 0, 90, 1, 100, 1, 100, 1]],
                ],
            ],
            [
                'name' => 'Usia Tanaman',
                'slug' => 'usia-tanaman',
                'unit' => 'Hari',
                'categories' => [
                    ['name' => 'Muda', 'points' => [0, 1, 0, 1, 0, 1, 30, 0]],
                    ['name' => 'Dewasa', 'points' => [25, 0, 35, 1, 65, 1, 80, 0]],
                    ['name' => 'Tua', 'points' => [75, 0, 120, 1, 300, 1, 300, 1]],
                ],
            ],
            [
                'name' => 'Output',
                'slug' => 'output',
                'unit' => 'Liter',
                'categories' => [
                    ['name' => 'Mati', 'points' => [0, 0, 0, 0, 0, 0, 0, 0]],
                    ['name' => 'Sedikit', 'points' => [0, 1, 0, 1, 0, 1, 12, 0]],
                    ['name' => 'Banyak', 'points' => [7, 0, 19, 1, 19, 1, 19, 1]],
                ],
            ],
        ];

        foreach ($dataset as $parameterData) {
            $parameter = FuzzyParameter::updateOrCreate(
                ['slug' => $parameterData['slug']],
                [
                    'name' => $parameterData['name'],
                    'unit' => $parameterData['unit'],
                ]
            );

            foreach ($parameterData['categories'] as $categoryData) {
                [$ax, $ay, $bx, $by, $cx, $cy, $dx, $dy] = $categoryData['points'];

                FuzzyCategory::updateOrCreate(
                    [
                        'fuzzy_parameter_id' => $parameter->id,
                        'name' => $categoryData['name'],
                    ],
                    [
                        'titik_a_x' => $ax,
                        'titik_a_y' => $ay,
                        'titik_b_x' => $bx,
                        'titik_b_y' => $by,
                        'titik_c_x' => $cx,
                        'titik_c_y' => $cy,
                        'titik_d_x' => $dx,
                        'titik_d_y' => $dy,
                    ]
                );
            }
        }
    }
}
