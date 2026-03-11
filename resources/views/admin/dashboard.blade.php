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
        <div class="panel-title center">Grafik Uji Usia Tanaman</div>
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
                    <input class="input" id="inpUmur" type="number" step="1" placeholder="Nilai Uji (Hari)">
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

                <td class="action action-group">
                        <!-- tombol lihat -->
                        <button
                            type="button"
                            class="icon-eye js-open-detail"
                            data-ip="{{ $row->ip }}"
                            data-tanggal="{{ $row->created_at?->format('d/m/Y H:i') }}"
                            data-suhu="{{ $row->suhu }}"
                            data-ku="{{ $row->kelembapan_udara }}"
                            data-kt="{{ $row->kelembapan_tanah }}"
                            data-umur="{{ $row->usia_tanaman }}"
                            data-output="{{ $row->output_liter }}"
                            data-kategori="{{ $row->kategori }}"
                            data-deskripsi="Sistem melakukan proses inferensi menggunakan metode fuzzy tsukamoto berdasarkan nilai suhu {{ $row->suhu }} °C, kelembapan udara {{ $row->kelembapan_udara }} %, kelembapan tanah {{ $row->kelembapan_tanah }} %, dan usia tanaman {{ $row->usia_tanaman }} hari sehingga menghasilkan output penyiraman sebesar {{ $row->output_liter }} liter dengan kategori {{ $row->kategori }}."
                            title="Lihat Deskripsi"
                            aria-label="Lihat deskripsi riwayat"
                        ><i class="fa-regular fa-eye"></i></button>

                        <!-- tombol hapus -->
                        <form action="{{ route('admin.riwayat.destroy',$row->id) }}" method="POST" class="js-delete-form action-form">
                            @csrf
                            @method('DELETE')
                            <button 
                            type="submit" class="icon-delete"
                            title="Hapus Riwayat"
                            aria-label="Hapus riwayat"
                            ><i class="fa-regular fa-trash-can"></i></button>
                        </form>

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
  <div class="modal-card modal-detail-card" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-head detail-head">
      <div class="detail-head-main">
        <div class="detail-kicker">
          <i class="fa-solid fa-circle-info"></i>
          <span>Riwayat Perhitungan</span>
        </div>
        <div id="modalTitle" class="detail-title">Detail Riwayat Perhitungan</div>
        <div id="modalSub" class="detail-sub"></div>
      </div>
      <button class="modal-x detail-close" id="modalX" type="button" aria-label="Tutup detail">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <div class="modal-body detail-body">
      <div class="detail-grid">
        <div class="detail-stat">
          <span class="detail-label">Suhu</span>
          <span class="detail-value" id="mSuhu"></span>
        </div>
        <div class="detail-stat">
          <span class="detail-label">Kelembapan Udara</span>
          <span class="detail-value" id="mKU"></span>
        </div>
        <div class="detail-stat">
          <span class="detail-label">Kelembapan Tanah</span>
          <span class="detail-value" id="mKT"></span>
        </div>
        <div class="detail-stat">
          <span class="detail-label">Usia Tanaman</span>
          <span class="detail-value" id="mUmur"></span>
        </div>
        <div class="detail-stat">
          <span class="detail-label">Output Penyiraman</span>
          <span class="detail-value" id="mOutput"></span>
        </div>
        <div class="detail-stat">
          <span class="detail-label">Kategori</span>
          <span class="detail-badge" id="mKategori">-</span>
        </div>
      </div>

      <div class="detail-desc-panel">
        <div class="detail-desc-title">
          <i class="fa-regular fa-file-lines"></i>
          <span>Deskripsi Perhitungan</span>
        </div>
        <div class="desc-box" id="mDeskripsi"></div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const swal = window.Swal;

    if (swal && @json(session('success'))) {
        swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('success')),
            confirmButtonColor: '#b8937d',
        });
    }

    // ===== PIE dari PHP (aman walau kosong) =====
    const pieData = @json([$pie['mati'], $pie['sedikit'], $pie['banyak']]);
    const usiaChartData = @json($usiaChartData ?? []);
    const normalizeKey = (value) => String(value || '')
        .trim()
        .toLowerCase()
        .replace(/\s+/g, '_');

    let usiaLineChart = null;
    let usiaMarkerDatasets = [];


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

        usiaMarkerDatasets = categories.map((cat, idx) => {
            const color = palette[idx % palette.length];
            return {
                label: `Uji ${cat.name}`,
                fuzzyKey: normalizeKey(cat.name),
                data: [],
                borderColor: color,
                backgroundColor: color,
                pointBackgroundColor: color,
                pointBorderColor: color,
                pointBorderWidth: 1,
                pointRadius: 6,
                pointHoverRadius: 7,
                pointStyle: 'circle',
                showLine: false,
                parsing: false,
            };
        });

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

        usiaLineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                datasets: [...lineDatasets, ...usiaMarkerDatasets]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                parsing: false,
                plugins: {
                    legend: {
                        position: window.matchMedia('(max-width: 768px)').matches ? 'bottom' : 'top',
                        labels: {
                            filter: (legendItem, chartData) => {
                                const ds = chartData.datasets[legendItem.datasetIndex];
                                return !String(ds?.label || '').startsWith('Uji ');
                            }
                        }
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
    const umurValue = Number(umur_hari);

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
        const membershipsMap = {};

        if (Array.isArray(json.memberships)) {
            json.memberships.forEach((item) => {
                const key = normalizeKey(item.name);
                const numericValue = Number(item.value);

                if (outputMap[key]) {
                    outputMap[key].value = item.value ?? '-';
                }
                membershipsMap[key] = Number.isFinite(numericValue) ? numericValue : 0;
            });
        } else {
            outMuda.value = json.muda ?? '-';
            outDewasa.value = json.dewasa ?? '-';
            outTua.value = json.tua ?? '-';
            membershipsMap.muda = Number(json.muda ?? 0) || 0;
            membershipsMap.dewasa = Number(json.dewasa ?? 0) || 0;
            membershipsMap.tua = Number(json.tua ?? 0) || 0;
        }

        if (usiaLineChart && Number.isFinite(umurValue) && Array.isArray(usiaMarkerDatasets)) {
            usiaMarkerDatasets.forEach((dataset) => {
                const yVal = Number(membershipsMap[dataset.fuzzyKey] ?? 0);
                dataset.data = [{ x: umurValue, y: Number.isFinite(yVal) ? yVal : 0 }];
            });
            usiaLineChart.update();
        }
    });

        // ===== Modal detail (samakan seperti riwayat) =====
        const modal = document.getElementById('detailModal');
        const closeBackdrop = document.getElementById('modalClose');

        const modalSub = document.getElementById('modalSub');
        const mSuhu = document.getElementById('mSuhu');
        const mKU = document.getElementById('mKU');
        const mKT = document.getElementById('mKT');
        const mUmur = document.getElementById('mUmur');
        const mOutput = document.getElementById('mOutput');
        const mKategori = document.getElementById('mKategori');
        const mDeskripsi = document.getElementById('mDeskripsi');
        const applyKategoriBadge = (value) => {
        const rawValue = String(value || '-').trim();
        const normalized = rawValue.toLowerCase();
        const formatted = rawValue === '-'
            ? '-'
            : rawValue.charAt(0).toUpperCase() + rawValue.slice(1);

        mKategori.textContent = formatted;
        mKategori.className = 'detail-badge';

        if (['mati', 'sedikit', 'banyak'].includes(normalized)) {
            mKategori.classList.add(`is-${normalized}`);
        }
        };

        const openModal = (btn) => {
        modalSub.textContent = `${btn.dataset.ip || '-'} • ${btn.dataset.tanggal || '-'}`;

        mSuhu.textContent = btn.dataset.suhu ? `${btn.dataset.suhu} °C` : '-';
        mKU.textContent = btn.dataset.ku ? `${btn.dataset.ku} %` : '-';
        mKT.textContent = btn.dataset.kt ? `${btn.dataset.kt} %` : '-';
        mUmur.textContent = btn.dataset.umur ? `${btn.dataset.umur} Hari` : '-';
        mOutput.textContent = btn.dataset.output ? `${btn.dataset.output} Liter` : '-';
        applyKategoriBadge(btn.dataset.kategori);
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

        if (e.target === closeBackdrop || e.target.closest('#modalX')) return closeModal();
        });

        document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
        });

        document.querySelectorAll('.js-delete-form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!swal) {
                const confirmed = window.confirm('Yakin ingin menghapus data ini?');
                if (!confirmed) {
                    event.preventDefault();
                }
                return;
            }

            event.preventDefault();

            swal.fire({
                title: 'Hapus data riwayat?',
                text: 'Data yang dihapus tidak bisa dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        });
        </script>

@endpush
