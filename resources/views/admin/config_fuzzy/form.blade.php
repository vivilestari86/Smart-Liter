<style>
  :root{
    --green-900:#2f7a3f;
    --green-700:#3f9a57;
    --mint-100:#e9f7f3;
    --panel:#f4f6f8;
    --card:#ffffff;
    --stroke:#cfd6dd;
    --shadow: 0 10px 24px rgba(0,0,0,.10);
    --danger:#dc2626;
  }

  .sl-page{
    background: linear-gradient(180deg, #e6f7f4 0%, #eaf4ff 100%);
    border-radius: 14px;
    padding: 18px;
  }

  .sl-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap: 12px;
    margin-bottom: 14px;
  }

  .sl-title{
    font-weight: 800;
    font-size: 22px;
    margin: 0;
    color: #1f2937;
  }

  .sl-subtitle{
    margin: 4px 0 0;
    color:#6b7280;
    font-size: 13px;
  }

  .sl-actions{
    display:flex;
    align-items:center;
    gap:10px;
  }

  .sl-btn-save{
    height: 38px;
    padding: 0 16px;
    border: 0;
    border-radius: 10px;
    background:#166534;
    color:#fff;
    font-weight:800;
    box-shadow: 0 10px 18px rgba(22,101,52,.25);
    cursor:pointer;
  }

  .sl-btn-save:disabled{
    opacity:.65;
    cursor:not-allowed;
  }

  .sl-alert{
    display:none;
    margin-bottom: 12px;
    padding: 10px 12px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
  }

  .sl-alert.ok{
    display:block;
    color:#166534;
    background:#dcfce7;
    border:1px solid #86efac;
  }

  .sl-alert.err{
    display:block;
    color:#991b1b;
    background:#fee2e2;
    border:1px solid #fca5a5;
  }

  .sl-panel{
    background: rgba(255,255,255,.55);
    border: 1px solid rgba(255,255,255,.65);
    border-radius: 14px;
    padding: 18px;
  }

  .sl-card{
    background: var(--card);
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: var(--shadow);
    padding: 16px;
  }

  .sl-card + .sl-card{ margin-top: 18px; }

  .sl-card-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom: 12px;
  }

  .sl-card-head h4{
    margin:0;
    font-weight: 800;
    color:#2563eb;
    letter-spacing:.2px;
  }

  .sl-grid-head{
    display:grid;
    grid-template-columns: 120px repeat(8, minmax(54px, 1fr));
    gap: 12px;
    margin-bottom: 10px;
    align-items:center;
  }

  .sl-grid-head div{
    font-size: 11px;
    font-weight: 800;
    color:#64748b;
    text-align:center;
  }

  .sl-grid-row{
    display:grid;
    grid-template-columns: 120px repeat(8, minmax(54px, 1fr));
    gap: 12px;
    align-items:start;
    margin-bottom: 10px;
  }

  .sl-tag{
    display:flex;
    align-items:center;
    justify-content:center;
    height: 44px;
    border-radius: 12px;
    font-weight: 700;
    color:#fff;
    box-shadow: 0 8px 18px rgba(0,0,0,.12);
  }
  .sl-tag.dingin{ background:#1f6a34; }
  .sl-tag.normal{ background:#7a1d4f; }
  .sl-tag.panas { background:#2b57b8; }

  .sl-field{
    display:flex;
    flex-direction:column;
    gap:4px;
  }

  .sl-input{
    height: 44px;
    border-radius: 10px;
    border: 1px solid var(--stroke);
    background:#fff;
    text-align:center;
    font-weight:700;
    font-size:16px;
    color:#111827;
    outline:none;
  }
  .sl-input:focus{
    border-color:#60a5fa;
    box-shadow: 0 0 0 4px rgba(96,165,250,.25);
  }

  .sl-input.is-error{
    border-color: var(--danger);
    box-shadow: 0 0 0 3px rgba(220,38,38,.15);
  }

  .sl-err{
    min-height: 14px;
    font-size: 11px;
    color: var(--danger);
    line-height: 1.2;
    text-align: center;
    display:block;
  }

  .sl-bottom{
    display:grid;
    grid-template-columns: minmax(0, 1fr) minmax(300px, 360px);
    gap: 18px;
    align-items:start;
  }

  .sl-chart-wrap{
    background:#f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 14px;
    min-width: 0;
  }

  .sl-suhu{
    background:#f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 14px;
    width: 100%;
    max-width: 360px;
    justify-self: end;
    display:flex;
    flex-direction:column;
    gap: 10px;
  }

  .sl-suhu h4{
    margin:0 0 10px;
    font-weight: 900;
    color:#15803d;
    font-size: 20px;
  }

  .sl-test-row{
    display:flex;
    gap: 10px;
    align-items:center;
    margin-bottom: 6px;
  }

  .sl-pill{
    flex:1;
    height: 36px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    background:#fff;
    font-weight:700;
    text-align:center;
    padding: 0 10px;
  }

  .sl-btn-test{
    height: 36px;
    padding: 0 18px;
    border: 0;
    border-radius: 10px;
    background:#c07b39;
    color:#fff;
    font-weight:800;
    box-shadow: 0 10px 18px rgba(192,123,57,.25);
    cursor:pointer;
  }

  .sl-btn-test:disabled{
    opacity:.65;
    cursor:not-allowed;
  }

  .sl-chart-canvas-wrap{
    background:#fff;
    border:1px solid #eef2f7;
    border-radius:12px;
    height:320px;
    padding:10px;
  }

  .sl-chart-canvas-wrap canvas{
    width:100% !important;
    height:100% !important;
    display:block;
  }

  .sl-result-list{
    display:grid;
    gap: 10px;
    margin-top: 2px;
  }

  .sl-result{
    display:grid;
    grid-template-columns: 1fr 70px;
    gap: 10px;
    align-items:center;
  }

  .sl-result .name{
    height: 34px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    background:#fff;
    display:flex;
    align-items:center;
    padding: 0 12px;
    font-weight:700;
    color:#374151;
    box-shadow: 0 6px 12px rgba(0,0,0,.06);
  }

  .sl-result .val{
    height: 34px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:800;
    color:#111827;
    box-shadow: 0 6px 12px rgba(0,0,0,.06);
  }

  @media (max-width: 1100px){
    .sl-grid-head,
    .sl-grid-row{
      grid-template-columns: 120px repeat(4, minmax(54px, 1fr));
    }
  }

  @media (max-width: 1300px){
    .sl-bottom{
      grid-template-columns: minmax(0, 1fr) minmax(270px, 320px);
    }
    .sl-suhu{
      max-width: 320px;
    }
  }

  @media (max-width: 1100px){
    .sl-bottom{ grid-template-columns: 1fr; }
    .sl-suhu{
      max-width: none;
      justify-self: stretch;
    }
    .sl-chart-canvas-wrap{
      height: 300px;
    }
  }

  @media (max-width: 640px){
    .sl-test-row{
      flex-direction: column;
      align-items: stretch;
    }
    .sl-btn-test{
      width: 100%;
    }
  }
</style>

<div class="sl-page" data-save-url="{{ route('admin.fuzzy.save', $parameter->slug) }}" data-test-url="{{ route('admin.fuzzy.test', $parameter->slug) }}">
  <div class="sl-top">
    <div>
      <h2 class="sl-title">Konfig {{ $parameter->name }}</h2>
      <p class="sl-subtitle">Form konfigurasi fuzzy untuk {{ strtolower($parameter->name) }}.</p>
    </div>

    <div class="sl-actions">
      <button class="sl-btn-save" type="button" id="btnSaveConfig">Simpan</button>
    </div>
  </div>

  <div class="sl-alert" id="saveAlert"></div>

  <div class="sl-panel">
    <div class="sl-card" id="fuzzyForm">
      <div class="sl-card-head">
        <h4>Parameter Titik {{ $parameter->name }}</h4>
      </div>

      <div class="sl-grid-head">
        <div></div>
        <div>A_X</div>
        <div>A_Y</div>
        <div>B_X</div>
        <div>B_Y</div>
        <div>C_X</div>
        <div>C_Y</div>
        <div>D_X</div>
        <div>D_Y</div>
      </div>

      @foreach($categories as $index => $category)
        @php
          $tagClass = ['dingin', 'normal', 'panas'][$loop->index % 3];
        @endphp

        <div class="sl-grid-row js-category-row" data-category-id="{{ $category->id }}" data-index="{{ $index }}">
          <div class="sl-tag {{ $tagClass }}">{{ $category->name }}</div>

          <div class="sl-field">
            <input class="sl-input js-point" type="number" step="0.01" data-point="titik_a_x" data-error-key="categories.{{ $index }}.titik_a_x" value="{{ $category->titik_a_x }}">
            <small class="sl-err" data-error-for="categories.{{ $index }}.titik_a_x"></small>
          </div>
          <div class="sl-field">
            <input class="sl-input js-point" type="number" step="0.01" data-point="titik_a_y" data-error-key="categories.{{ $index }}.titik_a_y" value="{{ $category->titik_a_y }}">
            <small class="sl-err" data-error-for="categories.{{ $index }}.titik_a_y"></small>
          </div>
          <div class="sl-field">
            <input class="sl-input js-point" type="number" step="0.01" data-point="titik_b_x" data-error-key="categories.{{ $index }}.titik_b_x" value="{{ $category->titik_b_x }}">
            <small class="sl-err" data-error-for="categories.{{ $index }}.titik_b_x"></small>
          </div>
          <div class="sl-field">
            <input class="sl-input js-point" type="number" step="0.01" data-point="titik_b_y" data-error-key="categories.{{ $index }}.titik_b_y" value="{{ $category->titik_b_y }}">
            <small class="sl-err" data-error-for="categories.{{ $index }}.titik_b_y"></small>
          </div>
          <div class="sl-field">
            <input class="sl-input js-point" type="number" step="0.01" data-point="titik_c_x" data-error-key="categories.{{ $index }}.titik_c_x" value="{{ $category->titik_c_x }}">
            <small class="sl-err" data-error-for="categories.{{ $index }}.titik_c_x"></small>
          </div>
          <div class="sl-field">
            <input class="sl-input js-point" type="number" step="0.01" data-point="titik_c_y" data-error-key="categories.{{ $index }}.titik_c_y" value="{{ $category->titik_c_y }}">
            <small class="sl-err" data-error-for="categories.{{ $index }}.titik_c_y"></small>
          </div>
          <div class="sl-field">
            <input class="sl-input js-point" type="number" step="0.01" data-point="titik_d_x" data-error-key="categories.{{ $index }}.titik_d_x" value="{{ $category->titik_d_x }}">
            <small class="sl-err" data-error-for="categories.{{ $index }}.titik_d_x"></small>
          </div>
          <div class="sl-field">
            <input class="sl-input js-point" type="number" step="0.01" data-point="titik_d_y" data-error-key="categories.{{ $index }}.titik_d_y" value="{{ $category->titik_d_y }}">
            <small class="sl-err" data-error-for="categories.{{ $index }}.titik_d_y"></small>
          </div>
        </div>
      @endforeach
    </div>

    <div class="sl-card">
      <div class="sl-bottom">
        <div class="sl-chart-wrap">
          <div class="sl-chart-canvas-wrap">
            <canvas id="fuzzyLineChart"></canvas>
          </div>
        </div>

        <div class="sl-suhu">
          <h4>Uji {{ $parameter->name }}</h4>
          <div class="sl-test-row">
            <input class="sl-pill" id="nilaiUjiInput" type="number" step="0.01" placeholder="Nilai uji {{ $parameter->unit ? '(' . $parameter->unit . ')' : '' }}">
            <button class="sl-btn-test" id="btnTestFuzzy" type="button">Test</button>
          </div>

          <div id="testError" class="sl-err" style="text-align:left;"></div>

          <div class="sl-result-list">
            @foreach($categories as $category)
              <div class="sl-result">
                <div class="name">{{ $category->name }}</div>
                <div class="val" data-result-id="{{ $category->id }}">-</div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  (() => {
    const root = document.querySelector('.sl-page');
    if (!root) return;

    const saveUrl = root.dataset.saveUrl;
    const testUrl = root.dataset.testUrl;
    const csrfToken = "{{ csrf_token() }}";

    const saveBtn = document.getElementById('btnSaveConfig');
    const saveAlert = document.getElementById('saveAlert');
    const testBtn = document.getElementById('btnTestFuzzy');
    const testInput = document.getElementById('nilaiUjiInput');
    const testError = document.getElementById('testError');
    const chartCanvas = document.getElementById('fuzzyLineChart');
    let fuzzyChart = null;

    const errorFor = new Map();
    const inputFor = new Map();

    document.querySelectorAll('[data-error-for]').forEach((el) => {
      errorFor.set(el.dataset.errorFor, el);
    });

    document.querySelectorAll('[data-error-key]').forEach((el) => {
      inputFor.set(el.dataset.errorKey, el);
    });

    const clearErrors = () => {
      errorFor.forEach((el) => { el.textContent = ''; });
      inputFor.forEach((el) => { el.classList.remove('is-error'); });
    };

    const showAlert = (message, type) => {
      saveAlert.textContent = message;
      saveAlert.className = `sl-alert ${type}`;
    };

    const buildPayload = () => {
      const categories = [];
      document.querySelectorAll('.js-category-row').forEach((row) => {
        const category = { id: Number(row.dataset.categoryId) };
        row.querySelectorAll('.js-point').forEach((input) => {
          category[input.dataset.point] = input.value;
        });
        categories.push(category);
      });

      return { categories };
    };

    const palette = ['#1f6a34', '#7a1d4f', '#2b57b8', '#ea580c', '#0f766e', '#9333ea'];

    const buildChartDataset = (category, idx) => ({
      label: category.name,
      data: [
        { x: category.titik_a_x, y: category.titik_a_y },
        { x: category.titik_b_x, y: category.titik_b_y },
        { x: category.titik_c_x, y: category.titik_c_y },
        { x: category.titik_d_x, y: category.titik_d_y },
      ],
      borderColor: palette[idx % palette.length],
      backgroundColor: palette[idx % palette.length],
      fill: false,
      tension: 0,
      pointRadius: 3,
      pointHoverRadius: 4,
    });

    const readChartCategories = () => {
      const list = [];
      document.querySelectorAll('.js-category-row').forEach((row) => {
        const nameEl = row.querySelector('.sl-tag');
        const val = (pointName) => {
          const input = row.querySelector(`[data-point="${pointName}"]`);
          const num = Number(input?.value);
          return Number.isFinite(num) ? num : 0;
        };

        list.push({
          name: nameEl ? nameEl.textContent.trim() : `Kategori ${list.length + 1}`,
          titik_a_x: val('titik_a_x'),
          titik_a_y: val('titik_a_y'),
          titik_b_x: val('titik_b_x'),
          titik_b_y: val('titik_b_y'),
          titik_c_x: val('titik_c_x'),
          titik_c_y: val('titik_c_y'),
          titik_d_x: val('titik_d_x'),
          titik_d_y: val('titik_d_y'),
        });
      });

      return list;
    };

    const computeDomain = (categories) => {
      const xs = categories.flatMap((category) => [
        category.titik_a_x,
        category.titik_b_x,
        category.titik_c_x,
        category.titik_d_x,
      ]).filter((x) => Number.isFinite(x));

      if (!xs.length) {
        return { min: 0, max: 100 };
      }

      const min = Math.min(...xs);
      const max = Math.max(...xs);
      const span = Math.max(1, max - min);
      const pad = span * 0.08;

      return { min: min - pad, max: max + pad };
    };

    const renderChart = () => {
      if (!chartCanvas || typeof Chart === 'undefined') return;

      const categories = readChartCategories();
      const datasets = categories.map((category, idx) => buildChartDataset(category, idx));
      const domain = computeDomain(categories);

      if (!fuzzyChart) {
        fuzzyChart = new Chart(chartCanvas, {
          type: 'line',
          data: { datasets },
          options: {
            animation: false,
            responsive: true,
            maintainAspectRatio: false,
            parsing: false,
            plugins: {
              legend: { position: 'top' },
              title: {
                display: true,
                text: 'Grafik Membership Function',
              },
            },
            scales: {
              x: {
                type: 'linear',
                min: domain.min,
                max: domain.max,
                title: {
                  display: true,
                  text: '{{ $parameter->name }}{{ $parameter->unit ? " ({$parameter->unit})" : "" }}',
                },
              },
              y: {
                min: 0,
                max: 1,
                ticks: { stepSize: 0.1 },
                title: {
                  display: true,
                  text: 'Derajat Keanggotaan',
                },
              },
            },
          },
        });

        return;
      }

      fuzzyChart.data.datasets = datasets;
      fuzzyChart.options.scales.x.min = domain.min;
      fuzzyChart.options.scales.x.max = domain.max;
      fuzzyChart.update();
    };

    document.querySelectorAll('.js-point').forEach((input) => {
      input.addEventListener('input', renderChart);
    });

    renderChart();

    saveBtn?.addEventListener('click', async () => {
      clearErrors();
      showAlert('', '');
      saveBtn.disabled = true;

      try {
        const response = await fetch(saveUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
          },
          body: JSON.stringify(buildPayload()),
        });

        const json = await response.json();

        if (!response.ok) {
          if (response.status === 422 && json.errors) {
            Object.entries(json.errors).forEach(([key, messages]) => {
              const message = Array.isArray(messages) ? messages[0] : String(messages);
              const errEl = errorFor.get(key);
              const inputEl = inputFor.get(key);
              if (errEl) errEl.textContent = message;
              if (inputEl) inputEl.classList.add('is-error');
            });
            showAlert('Periksa kembali data yang ditandai merah.', 'err');
          } else {
            showAlert(json.message || 'Gagal menyimpan konfigurasi.', 'err');
          }
          return;
        }

        showAlert(json.message || 'Konfigurasi berhasil disimpan.', 'ok');
        renderChart();
      } catch (error) {
        showAlert('Terjadi kesalahan jaringan saat menyimpan.', 'err');
      } finally {
        saveBtn.disabled = false;
      }
    });

    testBtn?.addEventListener('click', async () => {
      testError.textContent = '';
      testBtn.disabled = true;

      try {
        const response = await fetch(testUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
          },
          body: JSON.stringify({ nilai_uji: testInput.value }),
        });

        const json = await response.json();

        if (!response.ok) {
          if (response.status === 422) {
            const msg = json.errors?.nilai_uji?.[0] || json.message || 'Input nilai uji tidak valid.';
            testError.textContent = msg;
          } else {
            testError.textContent = json.message || 'Gagal melakukan test.';
          }
          return;
        }

        (json.hasil || []).forEach((item) => {
          const target = document.querySelector(`[data-result-id=\"${item.id}\"]`);
          if (target) target.textContent = item.nilai;
        });
      } catch (error) {
        testError.textContent = 'Terjadi kesalahan jaringan saat test.';
      } finally {
        testBtn.disabled = false;
      }
    });
  })();
</script>
@endpush
