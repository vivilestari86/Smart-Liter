@extends('admin.layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="dashboard-page">
<div class="cards">
    <div class="card metric">
        <div class="metric-icon">🌡️</div>
        <div class="metric-title">Suhu Udara</div>
        <a class="btn-edit" href="{{ route('admin.fuzzy.suhu') }}">Edit</a>
    </div>

    <div class="card metric">
        <div class="metric-icon">💧</div>
        <div class="metric-title">Kelembapan Udara</div>
        <a class="btn-edit" href="{{ route('admin.fuzzy.k_udara') }}">Edit</a>
    </div>

    <div class="card metric">
        <div class="metric-icon">🌱</div>
        <div class="metric-title">Kelembapan Tanah</div>
        <a class="btn-edit" href="{{ route('admin.fuzzy.k_tanah') }}">Edit</a>
    </div>

    <div class="card metric">
        <div class="metric-icon">🪴</div>
        <div class="metric-title">Usia Tanaman</div>
        <a class="btn-edit" href="{{ route('admin.fuzzy.usia') }}">Edit</a>
    </div>
</div>

<div class="grid-3">
    {{-- Pie chart --}}
    <div class="card panel panel-output">
        <div class="panel-title">Distributor Output</div>
        <div class="panel-body pie-wrap">
            <div class="legend">
                <div class="legend-item"><span class="swatch swatch-a"></span> Mati</div>
                <div class="legend-item"><span class="swatch swatch-b"></span> Sedikit</div>
                <div class="legend-item"><span class="swatch swatch-c"></span> Banyak</div>
            </div>
            <div class="chart-box">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Line chart (contoh dulu) --}}
    <div class="card panel span-2 panel-line">
        <div class="panel-title center">UJI TANAMAN</div>
        <div class="panel-body">
            <div class="line-box">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Uji umur dinamis --}}
    <div class="card panel panel-uji">
        <div class="panel-title right">Uji Usia Tanaman</div>
        <div class="panel-body">
            <div class="uji">
                <div class="uji-row">
                    <input class="input" id="inpUmur" type="number" step="1" value="31" placeholder="Usia Tanaman(Hari)">
                    <button class="btn-test" id="btnTestUmur" type="button">Test</button>
                </div>

                <div class="uji-row small">
                    <div class="pill">Muda</div>
                    <input class="input mini" id="outMuda" type="text" value="-" readonly>
                </div>
                <div class="uji-row small">
                    <div class="pill">Dewasa</div>
                    <input class="input mini" id="outDewasa" type="text" value="-" readonly>
                </div>
                <div class="uji-row small">
                    <div class="pill">Tua</div>
                    <input class="input mini" id="outTua" type="text" value="-" readonly>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="dots">
    <span class="dot"></span>
    <span class="dot active"></span>
    <span class="dot"></span>
</div>

{{-- Riwayat terbaru (dinamis, sumber sama dengan halaman riwayat) --}}
<div class="card table-card">
    <div class="table-head">
        <div class="table-title">Riwayat Perhitungan Terbaru</div>
        <a href="{{ route('admin.riwayat.index') }}" class="table-more-link">Lihat semua →</a>
    </div>

    <div class="table-scroll">
    <table class="table">
        <thead>
            <tr>
                <th>IP Tamu</th>
                <th>Tanggal</th>
                <th>Suhu(°C)</th>
                <th>Kelembapan Udara (%)</th>
                <th>Kelembapan Tanah (%)</th>
                <th>Usia Tanaman(Hari)</th>
                <th>Output</th>
                <th>Kategori</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse($latest as $row)
            <tr>
                <td>{{ $row->ip ?? '-' }}</td>
    <td>{{ $row->created_at?->format('d/m/Y') ?? '-' }}</td>

    <td>
        {{ $row->suhu !== null
            ? rtrim(rtrim(number_format($row->suhu,2,'.',''), '0'), '.') . ' °C'
            : '-' }}
    </td>

    <td>
        {{ $row->kelembapan_udara !== null
            ? rtrim(rtrim(number_format($row->kelembapan_udara,2,'.',''), '0'), '.') . ' %'
            : '-' }}
    </td>

    <td>
        {{ $row->kelembapan_tanah !== null
            ? rtrim(rtrim(number_format($row->kelembapan_tanah,2,'.',''), '0'), '.') . ' %'
            : '-' }}
    </td>

    <td>{{ $row->usia_tanaman !== null ? $row->usia_tanaman.' Hari' : '-' }}</td>

    <td>
        {{ $row->output_liter !== null
            ? rtrim(rtrim(number_format($row->output_liter,2,'.',''), '0'), '.') . ' Liter'
            : '-' }}
    </td>

    <td>{{ $row->kategori ? ucfirst($row->kategori) : '-' }}</td>

                <td class="action">
                    <button class="icon-eye js-open-detail"
                        type="button"
                        data-ip="{{ $row->ip }}"
                        data-tanggal="{{ $row->created_at?->format('d/m/Y H:i') }}"
                        data-suhu="{{ $row->suhu }}"
                        data-ku="{{ $row->kelembapan_udara }}"
                        data-kt="{{ $row->kelembapan_tanah }}"
                        data-umur="{{ $row->usia_tanaman }}"
                        data-output="{{ $row->output_liter }}"
                        data-kategori="{{ $row->kategori }}"
                        data-deskripsi='@json($row->deskripsi ?? "-")'
                        title="Detail"
                    >👁️</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" style="text-align:center; padding:14px;">
                    Belum ada data riwayat.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>
 </div>

{{-- Modal detail (samakan seperti riwayat) --}}
<div class="modal" id="detailModal" aria-hidden="true">
  <div class="modal-backdrop" id="modalClose"></div>
  <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-head">
      <div>
        <div id="modalTitle" style="font-weight:900; font-size:16px;">Detail Riwayat Perhitungan</div>
        <div id="modalSub" style="font-size:12px; opacity:.8; margin-top:2px;"></div>
      </div>
      <button class="modal-x" id="modalX" type="button">✕</button>
    </div>

    <div class="modal-body">
      <div class="modal-grid">
        <div><b>Suhu:</b> <span id="mSuhu"></span></div>
        <div><b>Kelembapan Udara:</b> <span id="mKU"></span></div>
        <div><b>Kelembapan Tanah:</b> <span id="mKT"></span></div>
        <div><b>Usia Tanaman:</b> <span id="mUmur"></span></div>
        <div><b>Output:</b> <span id="mOutput"></span></div>
        <div><b>Kategori:</b> <span id="mKategori"></span></div>
      </div>

      <div style="margin-top:12px;">
        <div style="font-weight:800; margin-bottom:6px;">Deskripsi</div>
        <div class="desc-box" id="mDeskripsi"></div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ===== PIE dari PHP (aman walau kosong) =====
    const pieData = @json([$pie['mati'], $pie['sedikit'], $pie['banyak']]);
    const usiaChartData = @json($usiaChartData ?? []);


    const pieCtx = document.getElementById('pieChart');
    if (pieCtx) {
        const totalPie = pieData.reduce((sum, val) => sum + Number(val || 0), 0);
        const hasPieData = totalPie > 0;

        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: hasPieData ? ['Mati', 'Sedikit', 'Banyak'] : ['Belum ada data'],
                datasets: [{
                    data: hasPieData ? pieData : [1],
                    backgroundColor: hasPieData
                        ? ['#7a3b11', '#c67d46', '#7fd3ff']
                        : ['#d1d5db'],
                    borderColor: '#ffffff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '56%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: hasPieData,
                    },
                },
            }
        });
    }

    // ===== LINE (sinkron dengan konfigurasi fuzzy usia tanaman) =====
    const lineCtx = document.getElementById('lineChart');
    if (lineCtx) {
        const palette = ['#3498db', '#f45b85', '#f39c34', '#16a085', '#8e44ad'];
        const categories = Array.isArray(usiaChartData) ? usiaChartData : [];

        const lineDatasets = categories.map((cat, idx) => ({
            label: cat.name,
            data: [
                { x: Number(cat.titik_a_x), y: Number(cat.titik_a_y) },
                { x: Number(cat.titik_b_x), y: Number(cat.titik_b_y) },
                { x: Number(cat.titik_c_x), y: Number(cat.titik_c_y) },
                { x: Number(cat.titik_d_x), y: Number(cat.titik_d_y) },
            ],
            borderColor: palette[idx % palette.length],
            backgroundColor: palette[idx % palette.length],
            fill: false,
            tension: 0,
            borderWidth: 3,
            pointRadius: 2,
            pointHoverRadius: 4,
        }));

        const allX = categories.flatMap((cat) => [
            Number(cat.titik_a_x),
            Number(cat.titik_b_x),
            Number(cat.titik_c_x),
            Number(cat.titik_d_x),
        ]).filter((x) => Number.isFinite(x));

        const minXRaw = allX.length ? Math.min(...allX) : 0;
        const maxXRaw = allX.length ? Math.max(...allX) : 100;
        const span = Math.max(1, maxXRaw - minXRaw);
        const padding = span * 0.08;
        const minX = minXRaw - padding;
        const maxX = maxXRaw + padding;

        new Chart(lineCtx, {
            type: 'line',
            data: {
                datasets: lineDatasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                parsing: false,
                plugins: {
                    legend: {
                        position: window.matchMedia('(max-width: 768px)').matches ? 'bottom' : 'top'
                    }
                },
                scales: {
                    x: {
                        type: 'linear',
                        min: minX,
                        max: maxX,
                        title: {
                            display: true,
                            text: 'Usia Tanaman (Hari)'
                        },
                        ticks: {
                            maxTicksLimit: window.matchMedia('(max-width: 768px)').matches ? 6 : 11
                        }
                    },
                    y: {
                        beginAtZero: true,
                        min: 0,
                        max: 1,
                        ticks: {
                            stepSize: 0.1
                        },
                        title: {
                            display: true,
                            text: 'Derajat Keanggotaan'
                        }
                    }
                }
            }
        });
    }

    // ===== UJI UMUR dinamis (AJAX) =====
    const btnTest = document.getElementById('btnTestUmur');
    btnTest?.addEventListener('click', async () => {
    const umur_hari = document.getElementById('inpUmur').value;

    const res = await fetch("{{ route('admin.dashboard.testUmur') }}", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: JSON.stringify({ umur_hari })
    });

        const json = await res.json();
        const outMuda = document.getElementById('outMuda');
        const outDewasa = document.getElementById('outDewasa');
        const outTua = document.getElementById('outTua');

        outMuda.value = '-';
        outDewasa.value = '-';
        outTua.value = '-';

        const outputMap = {
            muda: outMuda,
            dewasa: outDewasa,
            tua: outTua,
        };

        if (Array.isArray(json.memberships)) {
            json.memberships.forEach((item) => {
                const key = String(item.name || '')
                    .trim()
                    .toLowerCase()
                    .replace(/\s+/g, '_');

                if (outputMap[key]) {
                    outputMap[key].value = item.value ?? '-';
                }
            });
        } else {
            outMuda.value = json.muda ?? '-';
            outDewasa.value = json.dewasa ?? '-';
            outTua.value = json.tua ?? '-';
        }
    });

    // ===== Modal detail (samakan seperti riwayat) =====
        const modal = document.getElementById('detailModal');
        const closeBackdrop = document.getElementById('modalClose');
        const closeX = document.getElementById('modalX');

        const modalSub = document.getElementById('modalSub');
        const mSuhu = document.getElementById('mSuhu');
        const mKU = document.getElementById('mKU');
        const mKT = document.getElementById('mKT');
        const mUmur = document.getElementById('mUmur');
        const mOutput = document.getElementById('mOutput');
        const mKategori = document.getElementById('mKategori');
        const mDeskripsi = document.getElementById('mDeskripsi');

        const openModal = (btn) => {
        modalSub.textContent = `${btn.dataset.ip || '-'} • ${btn.dataset.tanggal || '-'}`;

        mSuhu.textContent = btn.dataset.suhu ? `${btn.dataset.suhu} °C` : '-';
        mKU.textContent = btn.dataset.ku ? `${btn.dataset.ku} %` : '-';
        mKT.textContent = btn.dataset.kt ? `${btn.dataset.kt} %` : '-';
        mUmur.textContent = btn.dataset.umur ? `${btn.dataset.umur} Hari` : '-';
        mOutput.textContent = btn.dataset.output ? `${btn.dataset.output} Liter` : '-';
        mKategori.textContent = btn.dataset.kategori || '-';
        mDeskripsi.textContent = btn.dataset.deskripsi || '-';

        modal.classList.add('open');
        modal.setAttribute('aria-hidden','false');
        };

        const closeModal = () => {
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden','true');
        };

        // event delegation (lebih aman)
        document.addEventListener('click', (e) => {
        const btn = e.target.closest('.js-open-detail');
        if (btn) return openModal(btn);

        if (e.target === closeBackdrop || e.target === closeX) return closeModal();
        });

        document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
        });
        </script>

@endpush
