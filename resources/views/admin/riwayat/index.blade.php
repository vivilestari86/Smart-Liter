@extends('admin.layouts.app')
@section('title','Riwayat Perhitungan')

@section('content')
<div class="card panel" style="padding:16px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h3 style="margin:0;">Riwayat Perhitungan</h3>
    </div>

        {{-- SUMMARY CARDS --}}
    <div class="riw-top">
        <div class="riw-card">
            <div>
                <div class="riw-label">Total Perhitungan Hari Ini</div>
                <div class="riw-value">{{ $totalHariIni ?? 0 }}</div>
            </div>
            <div class="riw-icon">🧾</div>
        </div>

        <div class="riw-card">
            <div>
                <div class="riw-label">Tamu Unik</div>
                <div class="riw-value">{{ $tamuUnik ?? 0 }}</div>
            </div>
            <div class="riw-icon">👤</div>
        </div>

        <div class="riw-card">
            <div>
                <div class="riw-label">Rata-rata Output</div>
                <div class="riw-value">{{ $rataOutput ?? 0 }} Liter</div>
            </div>
            <div class="riw-icon">📈</div>
        </div>
    </div>

    {{-- CHARTS --}}
    <div class="riw-charts">
        <div class="riw-panel">
            <div class="riw-panel-title">Distributor Output</div>
            <div class="riw-panel-body riw-pie-wrap">
                <div class="legend">
                    <div class="legend-item"><span class="swatch swatch-a"></span> Mati</div>
                    <div class="legend-item"><span class="swatch swatch-b"></span> Sedikit</div>
                    <div class="legend-item"><span class="swatch swatch-c"></span> Banyak</div>
                </div>
                <div class="chart-box riw-pie-chart-box">
                    <canvas id="pieRiwayat"></canvas>
                </div>
            </div>
        </div>

        <div class="riw-panel">
            <div class="riw-panel-title">Perhitungan Per Jam</div>
            <div class="riw-panel-body">
                <div class="chart-box">
                    <canvas id="lineRiwayat"></canvas>
                </div>
            </div>
        </div>
    </div>


    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('admin.riwayat.index') }}" class="filter-bar">
        <div class="filter-group">
            <label>Tahun :</label>
            <select name="year" class="select">
                <option value="all">Semua</option>
                @foreach($years as $y)
                    <option value="{{ $y }}" {{ (string)$year === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label>Bulan :</label>
            <select name="month" class="select">
                <option value="all" {{ $month === 'all' || !$month ? 'selected' : '' }}>Per Bulan</option>
                @for($m=1;$m<=12;$m++)
                    <option value="{{ $m }}" {{ (string)$month === (string)$m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="filter-group">
            <label>Kategori :</label>
            <select name="kategori" class="select">
                <option value="all">Semua Kategori</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k }}" {{ (string)$kategori === (string)$k ? 'selected' : '' }}>{{ ucfirst($k) }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-apply">Terapkan</button>

        <a class="btn-reset" href="{{ route('admin.riwayat.index') }}" title="Reset">↻</a>
    </form>

    {{-- Table --}}
    <div class="table-wrap">
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
            @forelse($histories as $row)
                <tr>
                    <td>{{ $row->ip ?? '-' }}</td>
                    <td>{{ $row->created_at?->format('d/m/Y') }}</td>
                    <td>{{ $row->suhu !== null ? rtrim(rtrim(number_format($row->suhu,2,'.',''), '0'), '.') . ' °C' : '-' }}</td>
                    <td>{{ $row->kelembapan_udara !== null ? rtrim(rtrim(number_format($row->kelembapan_udara,2,'.',''), '0'), '.') . ' %' : '-' }}</td>
                    <td>{{ $row->kelembapan_tanah !== null ? rtrim(rtrim(number_format($row->kelembapan_tanah,2,'.',''), '0'), '.') . ' %' : '-' }}</td>
                    <td>{{ $row->usia_tanaman !== null ? $row->usia_tanaman.' Hari' : '-' }}</td>
                    <td>{{ $row->output_liter !== null ? rtrim(rtrim(number_format($row->output_liter,2,'.',''), '0'), '.') . ' Liter' : '-' }}</td>
                    <td>{{ $row->kategori ? ucfirst($row->kategori) : '-' }}</td>
                    <td class="action">
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
                            data-deskripsi='@json($row->deskripsi ?? "-")'
                            title="Lihat Deskripsi"
                        >👁</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:18px;">Data tidak ditemukan.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:12px;">
        {{ $histories->links() }}
    </div>
</div>

{{-- Modal --}}
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

{{-- Styles khusus riwayat (biar cepat) --}}
<style>
.filter-bar{
    display:flex;
    gap:12px;
    align-items:center;
    flex-wrap: wrap;
    background: #f6fbff;
    border: 1px solid rgba(0,0,0,.08);
    border-radius: 12px;
    padding: 10px 12px;
    margin-bottom: 12px;
}
.filter-group{ display:flex; align-items:center; gap:8px; }
.filter-group label{ font-weight:800; font-size:13px; }
.select{
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 10px;
    padding: 8px 10px;
    background:#fff;
    min-width: 160px;
}
.btn-apply{
    border:0;
    background:#b8937d;
    color:#fff;
    font-weight:900;
    padding: 9px 14px;
    border-radius: 10px;
    cursor:pointer;
}
.btn-reset{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    border: 1px solid rgba(0,0,0,.15);
    background:#fff;
    text-decoration:none;
}

.table-wrap{ overflow:auto; border-radius:12px; }
.icon-eye{ border:0; background:transparent; cursor:pointer; font-size:16px; }

.riw-pie-wrap{
    display:grid;
    grid-template-columns: minmax(120px, 1fr) minmax(0, 1fr);
    gap: 12px;
    align-items: center;
    min-width: 0;
}

.riw-pie-chart-box{
    width: min(100%, 240px);
    max-width: 100%;
    aspect-ratio: 1 / 1;
    height: auto !important;
    margin-inline: auto;
    position: relative;
    overflow: hidden;
    display:flex;
    align-items:center;
    justify-content:center;
}

.riw-pie-chart-box canvas{
    width: 100% !important;
    height: 100% !important;
    display: block;
}

@media (max-width: 980px){
    .riw-pie-wrap{
        grid-template-columns: 1fr;
        justify-items: center;
        text-align: center;
    }

    .riw-pie-wrap .legend{
        min-width: auto;
        display:flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .riw-pie-wrap .legend-item{
        margin: 0;
    }
}

/* modal */
.modal{ display:none; }
.modal.open{ display:block; }
.modal-backdrop{
    position:fixed; inset:0;
    background: rgba(0,0,0,.35);
    z-index: 9998;
}
.modal-card{
    position:fixed;
    z-index: 9999;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: min(680px, 92vw);
    background:#fff;
    border-radius: 16px;
    box-shadow: 0 18px 60px rgba(0,0,0,.25);
    overflow:hidden;
}
.modal-head{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding: 12px 14px;
    background:#f6fbff;
    border-bottom: 1px solid rgba(0,0,0,.08);
}
.modal-x{
    border:0;
    background:transparent;
    cursor:pointer;
    font-size:16px;
}
.modal-body{ padding: 14px; }
.modal-grid{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px 14px;
    font-size: 13px;
}
.desc-box{
    background:#f7f7fb;
    border: 1px solid rgba(0,0,0,.08);
    border-radius: 12px;
    padding: 12px;
    white-space: pre-wrap;
    font-size: 13px;
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // PIE (samakan dengan dashboard)
    const pieData = @json([
      $pie['mati'] ?? 0,
      $pie['sedikit'] ?? 0,
      $pie['banyak'] ?? 0
    ]);

    const pieCtx = document.getElementById('pieRiwayat');
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

    // LINE per jam
    const perJamRaw = @json($perJam ?? []);
    const perJam = Array.from({ length: 24 }, (_, i) => Number(perJamRaw[i] ?? 0));
    const maxPerJam = Math.max(0, ...perJam);
    const lineCtx = document.getElementById('lineRiwayat');
    if (lineCtx) {
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: Array.from({ length: 24 }, (_, i) => String(i).padStart(2, '0')),
                datasets: [{
                    label: 'Jumlah Perhitungan',
                    data: perJam,
                    tension: 0.25,
                    borderColor: '#3498db',
                    backgroundColor: '#3498db',
                    borderWidth: 3,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: Math.max(3, maxPerJam + 1),
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                        }
                    }
                }
            }
        });
    }

    // Modal detail
    const modal = document.getElementById('detailModal');
    const closeBackdrop = document.getElementById('modalClose');
    const closeX = document.getElementById('modalX');
    const el = (id) => document.getElementById(id);

    function openModalFromButton(btn) {
        el('modalSub').textContent = `${btn.dataset.ip || '-'} • ${btn.dataset.tanggal || '-'}`;
        el('mSuhu').textContent = btn.dataset.suhu ? `${btn.dataset.suhu} °C` : '-';
        el('mKU').textContent = btn.dataset.ku ? `${btn.dataset.ku} %` : '-';
        el('mKT').textContent = btn.dataset.kt ? `${btn.dataset.kt} %` : '-';
        el('mUmur').textContent = btn.dataset.umur ? `${btn.dataset.umur} Hari` : '-';
        el('mOutput').textContent = btn.dataset.output ? `${btn.dataset.output} Liter` : '-';
        el('mKategori').textContent = btn.dataset.kategori || '-';
        el('mDeskripsi').textContent = btn.dataset.deskripsi || '-';

        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeModal() {
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden', 'true');
    }

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.js-open-detail');
        if (btn) return openModalFromButton(btn);

        if (e.target === closeBackdrop || e.target === closeX) return closeModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });
});
</script>
@endpush
