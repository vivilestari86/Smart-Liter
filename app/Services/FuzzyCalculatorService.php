<?php

namespace App\Services;

use App\Models\FuzzyParameter;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use RuntimeException;

class FuzzyCalculatorService
{
    public function calculate(array $inputs): array
    {
        $parameters = FuzzyParameter::with('categories')->get();
        $inputConfig = config('fuzzy.inputs', []);
        $outputConfig = config('fuzzy.output', []);
        $rulebase = config('fuzzy.rulebase', []);

        if (empty($inputConfig) || empty($outputConfig) || empty($rulebase)) {
            throw new RuntimeException('Konfigurasi fuzzy belum lengkap.');
        }

        $membershipMap = [];
        $resolvedParameters = [];

        foreach ($inputConfig as $inputKey => $config) {
            $labels = $config['labels'] ?? [];
            $value = (float) ($inputs[$inputKey] ?? 0);
            [$parameter, $categories] = $this->resolveParameterByLabels(
                $parameters,
                (string) ($config['preferred_slug'] ?? ''),
                $labels
            );

            $resolvedParameters[$inputKey] = [
                'input' => $inputKey,
                'preferred_slug' => $config['preferred_slug'] ?? null,
                'used_slug' => $parameter->slug,
                'used_name' => $parameter->name,
            ];

            $membershipMap[$inputKey] = [];
            foreach ($labels as $label) {
                $normLabel = $this->normalizeLabel($label);
                $category = $categories->get($normLabel);
                $membershipMap[$inputKey][$label] = $category
                    ? $this->membershipFromCategory(
                        $value,
                        $category
                    )
                    : 0.0;
            }
        }

        [$outputParameter, $outputCategories] = $this->resolveParameterByLabels(
            $parameters,
            (string) ($outputConfig['preferred_slug'] ?? ''),
            $outputConfig['labels'] ?? []
        );

        $outputConstants = [];
        foreach (($outputConfig['labels'] ?? []) as $label) {
            $category = $outputCategories->get($this->normalizeLabel($label));
            $outputConstants[$label] = $category ? $this->categoryMidpoint($category) : 0.0;
        }

        $firedRules = [];
        $sumAlpha = 0.0;
        $sumAlphaZ = 0.0;

        foreach ($rulebase as $rule) {
            $alpha = min(
                $membershipMap['suhu'][$rule['suhu']] ?? 0.0,
                $membershipMap['kelembapan_udara'][$rule['kelembapan_udara']] ?? 0.0,
                $membershipMap['kelembapan_tanah'][$rule['kelembapan_tanah']] ?? 0.0,
                $membershipMap['usia_tanaman'][$rule['usia_tanaman']] ?? 0.0
            );

            if ($alpha <= 0.0) {
                continue;
            }

            $z = (float) ($outputConstants[$rule['output']] ?? 0.0);
            $sumAlpha += $alpha;
            $sumAlphaZ += ($alpha * $z);

            $firedRules[] = [
                'id' => $rule['id'],
                'alpha' => round($alpha, 6),
                'output' => $rule['output'],
                'z' => round($z, 4),
                'alpha_z' => round($alpha * $z, 6),
            ];
        }

        $outputLiter = $sumAlpha > 0.0 ? ($sumAlphaZ / $sumAlpha) : 0.0;

        $outputMembership = [];
        foreach (($outputConfig['labels'] ?? []) as $label) {
            $category = $outputCategories->get($this->normalizeLabel($label));
            if (! $category) {
                $outputMembership[$label] = 0.0;
                continue;
            }

            $outputMembership[$label] = $this->trapmf(
                $outputLiter,
                (float) $category->titik_a_x,
                (float) $category->titik_a_y,
                (float) $category->titik_b_x,
                (float) $category->titik_b_y,
                (float) $category->titik_c_x,
                (float) $category->titik_c_y,
                (float) $category->titik_d_x,
                (float) $category->titik_d_y
            );
        }

        $kategoriLabel = $this->pickMaxLabel($outputMembership) ?? 'Mati';
        $kategori = Str::lower($kategoriLabel);

        $deskripsi = sprintf(
            'Fuzzy inference berbasis %d rule aktif, %s = %s L, kategori %s.',
            count($firedRules),
            $outputParameter->name,
            number_format($outputLiter, 2, '.', ''),
            $kategori
        );

        return [
            'output_liter' => round($outputLiter, 2),
            'kategori' => $kategori,
            'deskripsi' => $deskripsi,
            'debug_rules' => [
                'resolved_parameters' => $resolvedParameters,
                'membership_input' => $this->roundNested($membershipMap, 6),
                'output_midpoints' => $this->roundNested($outputConstants, 4),
                'fired_rules' => $firedRules,
                'sum_alpha' => round($sumAlpha, 6),
                'sum_alpha_z' => round($sumAlphaZ, 6),
                'output_membership' => $this->roundNested($outputMembership, 6),
            ],
        ];
    }

    /**
     * @param EloquentCollection<int, FuzzyParameter> $parameters
     * @param string[] $labels
     * @return array{0:FuzzyParameter,1:Collection<string,mixed>}
     */
    private function resolveParameterByLabels(
        EloquentCollection $parameters,
        string $preferredSlug,
        array $labels
    ): array {
        $preferred = $parameters->firstWhere('slug', $preferredSlug);

        if ($preferred) {
            $preferredMap = $this->categoryMap($preferred);
            if ($this->hasAllLabels($preferredMap, $labels)) {
                return [$preferred, $preferredMap];
            }
        }

        foreach ($parameters as $parameter) {
            $categoryMap = $this->categoryMap($parameter);
            if ($this->hasAllLabels($categoryMap, $labels)) {
                return [$parameter, $categoryMap];
            }
        }

        if ($preferred) {
            return [$preferred, $this->categoryMap($preferred)];
        }

        throw new RuntimeException("Parameter fuzzy untuk slug {$preferredSlug} tidak ditemukan.");
    }

    /**
     * @return Collection<string,mixed>
     */
    private function categoryMap(FuzzyParameter $parameter): Collection
    {
        return collect($parameter->categories)->mapWithKeys(function ($category) {
            return [$this->normalizeLabel((string) $category->name) => $category];
        });
    }

    /**
     * @param Collection<string,mixed> $categoryMap
     * @param string[] $labels
     */
    private function hasAllLabels(Collection $categoryMap, array $labels): bool
    {
        foreach ($labels as $label) {
            if (! $categoryMap->has($this->normalizeLabel($label))) {
                return false;
            }
        }

        return true;
    }

    private function normalizeLabel(string $label): string
    {
        return Str::of($label)
            ->squish()
            ->lower()
            ->value();
    }

    private function membershipFromCategory(float $x, object $category): float
    {
        return $this->trapmf(
            $x,
            (float) $category->titik_a_x,
            (float) $category->titik_a_y,
            (float) $category->titik_b_x,
            (float) $category->titik_b_y,
            (float) $category->titik_c_x,
            (float) $category->titik_c_y,
            (float) $category->titik_d_x,
            (float) $category->titik_d_y
        );
    }

    private function trapmf(
        float $x,
        float $ax,
        float $ay,
        float $bx,
        float $by,
        float $cx,
        float $cy,
        float $dx,
        float $dy
    ): float
    {
        if (! ($ax <= $bx && $bx <= $cx && $cx <= $dx)) {
            return 0.0;
        }

        if ($x < $ax || $x > $dx) {
            return 0.0;
        }

        $segments = [
            [$ax, $ay, $bx, $by],
            [$bx, $by, $cx, $cy],
            [$cx, $cy, $dx, $dy],
        ];

        foreach ($segments as [$x1, $y1, $x2, $y2]) {
            if ($x < $x1 || $x > $x2) {
                continue;
            }

            if ($x2 == $x1) {
                return $this->clamp01(max($y1, $y2));
            }

            $t = ($x - $x1) / ($x2 - $x1);
            $value = $y1 + ($t * ($y2 - $y1));
            return $this->clamp01($value);
        }

        if ($x == $dx) {
            return $this->clamp01($dy);
        }

        return 0.0;
    }

    private function categoryMidpoint(object $category): float
    {
        $xs = [
            (float) $category->titik_a_x,
            (float) $category->titik_b_x,
            (float) $category->titik_c_x,
            (float) $category->titik_d_x,
        ];

        return (min($xs) + max($xs)) / 2.0;
    }

    private function clamp01(float $value): float
    {
        return max(0.0, min(1.0, $value));
    }

    /**
     * @param array<string,float> $map
     */
    private function pickMaxLabel(array $map): ?string
    {
        if (empty($map)) {
            return null;
        }

        $maxLabel = null;
        $maxValue = -INF;

        foreach ($map as $label => $value) {
            if ($value > $maxValue) {
                $maxValue = $value;
                $maxLabel = $label;
            }
        }

        return $maxLabel;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    private function roundNested($value, int $precision)
    {
        if (is_array($value)) {
            $out = [];
            foreach ($value as $key => $item) {
                $out[$key] = $this->roundNested($item, $precision);
            }

            return $out;
        }

        if (is_float($value)) {
            return round($value, $precision);
        }

        return $value;
    }
}
