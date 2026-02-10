@extends('admin.layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
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
    <div class="card panel">
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
    <div class="card panel span-2">
        <div class="panel-title center">UJI TANAMAN</div>
        <div class="panel-body">
            <div class="line-box">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Uji umur dinamis --}}
    <div class="card panel">
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
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
        <div style="font-weight:900;">Riwayat Perhitungan Terbaru</div>
        <a href="{{ route('admin.riwayat.index') }}" style="font-weight:800; text-decoration:none;">Lihat semua →</a>
    </div>

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
                <td>{{ $row->suhu ?? '-' }}</td>
                <td>{{ $row->kelembapan_udara ?? '-' }}</td>
                <td>{{ $row->kelembapan_tanah ?? '-' }}</td>
                <td>{{ $row->umur_hari ?? '-' }}</td>
                <td>{{ $row->output_liter ?? '-' }}</td>
                <td>{{ $row->kategori ?? '-' }}</td>
                <td class="action">
                    <button class="icon-eye js-open-detail"
                        type="button"
                        data-ip="{{ $row->ip }}"
                        data-tanggal="{{ $row->created_at?->format('d/m/Y H:i') }}"
                        data-deskripsi="{{ e($row->deskripsi ?? '-') }}"
                        title="Detail">👁️</button>
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

{{-- Modal detail sederhana --}}
<div class="modal" id="detailModal" aria-hidden="true">
    <div class="modal-backdrop" id="modalClose"></div>
    <div class="modal-card">
        <div class="modal-head">
            <div>
                <div style="font-weight:900;">Deskripsi Perhitungan</div>
                <div id="modalSub" style="font-size:12px; opacity:.8;"></div>
            </div>
            <button class="modal-x" id="modalX" type="button">✕</button>
        </div>
        <div class="modal-body">
            <div class="desc-box" id="mDeskripsi"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ===== PIE dari PHP (aman walau kosong) =====
    const pieData = @json([$pie['mati'], $pie['sedikit'], $pie['banyak']]);


    const pieCtx = document.getElementById('pieChart');
    if (pieCtx) {
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Mati', 'Sedikit', 'Banyak'],
                datasets: [{ data: pieData }]
            },
            options: { plugins: { legend: { display: false } } }
        });
    }

    // ===== LINE (sementara contoh) =====
    const lineCtx = document.getElementById('lineChart');
    if (lineCtx) {
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['0','10','20','30','40','50','60','70','80','90','100'],
                datasets: [
                    { label: 'Muda', data: [0,20,40,70,70,70,70,60,30,10,0], tension: 0.3 },
                    { label: 'Dewasa', data: [0,0,10,30,60,60,60,40,20,0,0], tension: 0.3 },
                    { label: 'Tua', data: [0,0,0,5,10,10,10,20,40,70,90], tension: 0.3 }
                ]
            },
            options: { plugins: { legend: { position: 'top' } }, scales: { y: { beginAtZero: true } } }
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
        document.getElementById('outMuda').value = json.muda ?? '-';
        document.getElementById('outDewasa').value = json.dewasa ?? '-';
        document.getElementById('outTua').value = json.tua ?? '-';
    });

    // ===== Modal detail riwayat =====
    const modal = document.getElementById('detailModal');
    const closeBackdrop = document.getElementById('modalClose');
    const closeX = document.getElementById('modalX');
    const mDeskripsi = document.getElementById('mDeskripsi');
    const modalSub = document.getElementById('modalSub');

    document.querySelectorAll('.js-open-detail').forEach(btn => {
        btn.addEventListener('click', () => {
            modalSub.textContent = `${btn.dataset.ip || '-'} • ${btn.dataset.tanggal || '-'}`;
            mDeskripsi.textContent = btn.dataset.deskripsi || '-';
            modal.classList.add('open');
            modal.setAttribute('aria-hidden','false');
        });
    });

    const closeModal = () => {
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden','true');
    };
    closeBackdrop?.addEventListener('click', closeModal);
    closeX?.addEventListener('click', closeModal);
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
</script>
@endpush
