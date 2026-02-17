@extends('admin.layouts.app')
@section('title','Konfigurasi Fuzzy - Suhu Udara')

@section('content')
<style>
  :root{
    --green-900:#2f7a3f;
    --green-700:#3f9a57;
    --mint-100:#e9f7f3;
    --panel:#f4f6f8;
    --card:#ffffff;
    --stroke:#cfd6dd;
    --shadow: 0 10px 24px rgba(0,0,0,.10);
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
    color:#2563eb; /* biru seperti judul di gambar */
    letter-spacing:.2px;
  }

  .sl-grid-params{
    display:grid;
    grid-template-columns: 120px repeat(8, minmax(54px, 1fr));
    gap: 12px;
    align-items:center;
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

  .sl-input{
    height: 44px;
    border-radius: 10px;
    border: 1px solid var(--stroke);
    background:#fff;
    text-align:center;
    font-weight:700;
    font-size:18px;
    color:#111827;
    outline:none;
  }
  .sl-input:focus{
    border-color:#60a5fa;
    box-shadow: 0 0 0 4px rgba(96,165,250,.25);
  }
  .sl-input.is-disabled{
    background:#e5e7eb;
    color:#9ca3af;
    border-color:#d1d5db;
  }

  .sl-bottom{
    display:grid;
    grid-template-columns: 1.35fr .65fr;
    gap: 18px;
    align-items:stretch;
  }

  .sl-chart-wrap{
    background:#f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 14px;
    height: 100%;
  }

  .sl-suhu{
    background:#f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 14px;
    height: 100%;
  }

  .sl-suhu h4{
    margin:0 0 10px;
    font-weight: 900;
    color:#15803d; /* hijau "Suhu Uji" */
    font-size: 20px;
  }

  .sl-test-row{
    display:flex;
    gap: 10px;
    align-items:center;
    margin-bottom: 14px;
  }

  .sl-pill{
    flex:1;
    height: 36px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    background:#fff;
    font-weight:700;
    text-align:center;
  }

  .sl-btn-test{
    height: 36px;
    padding: 0 18px;
    border: 0;
    border-radius: 10px;
    background:#c07b39; /* coklat tombol */
    color:#fff;
    font-weight:800;
    box-shadow: 0 10px 18px rgba(192,123,57,.25);
    cursor:pointer;
  }

  .sl-result{
    display:grid;
    grid-template-columns: 1fr 70px;
    gap: 10px;
    align-items:center;
    margin-top: 10px;
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
    .sl-grid-params{ grid-template-columns: 120px repeat(4, minmax(54px, 1fr)); }
  }
  @media (max-width: 900px){
    .sl-bottom{ grid-template-columns: 1fr; }
  }
</style>

<div class="sl-page">
  <div class="sl-top">
    <div>
      <h2 class="sl-title">Konfig Suhu Udara</h2>
      <p class="sl-subtitle">Form konfigurasi fuzzy untuk Suhu Udara.</p>
    </div>

    
  </div>

  <div class="sl-panel">

    {{-- Kartu Parameter --}}
    <div class="sl-card">
      <div class="sl-card-head">
        <h4>Parameter Titik Suhu Udara</h4>
      </div>

      {{-- Grid: label + 8 input (sesuai gambar) --}}
      <div class="sl-grid-params">
        {{-- DINGIN --}}
        <div class="sl-tag dingin">Dingin</div>
        <input class="sl-input is-disabled" value="" disabled>
        <input class="sl-input is-disabled" value="" disabled>
        <input class="sl-input is-disabled" value="" disabled>
        <input class="sl-input is-disabled" value="" disabled>
        <input class="sl-input" name="dingin_a" value="20">
        <input class="sl-input" name="dingin_b" value="1">
        <input class="sl-input" name="dingin_c" value="30">
        <input class="sl-input" name="dingin_d" value="0">

        {{-- NORMAL --}}
        <div class="sl-tag normal">Normal</div>
        <input class="sl-input" name="normal_a" value="25">
        <input class="sl-input" name="normal_b" value="0">
        <input class="sl-input" name="normal_c" value="30">
        <input class="sl-input" name="normal_d" value="1">
        <input class="sl-input" name="normal_e" value="35">
        <input class="sl-input" name="normal_f" value="1">
        <input class="sl-input" name="normal_g" value="40">
        <input class="sl-input" name="normal_h" value="0">

        {{-- PANAS --}}
        <div class="sl-tag panas">Panas</div>
        <input class="sl-input" name="panas_a" value="30">
        <input class="sl-input" name="panas_b" value="0">
        <input class="sl-input" name="panas_c" value="40">
        <input class="sl-input" name="panas_d" value="1">
        <input class="sl-input is-disabled" value="" disabled>
        <input class="sl-input is-disabled" value="" disabled>
        <input class="sl-input is-disabled" value="" disabled>
        <input class="sl-input is-disabled" value="" disabled>
      </div>
    </div>

    {{-- Kartu bawah: Chart + Suhu Uji --}}
    <div class="sl-card">
      <div class="sl-bottom">

        {{-- Chart --}}
        <div class="sl-chart-wrap">
          {{-- ganti dengan chart kamu (canvas/chartjs/apexcharts), atau img --}}
          <div style="background:#fff;border:1px solid #eef2f7;border-radius:12px;height:320px;display:flex;align-items:center;justify-content:center;">
            <span style="color:#6b7280;font-weight:700;">(Area Grafik Suhu Udara)</span>
          </div>
        </div>

        {{-- Suhu Uji --}}
        <div class="sl-suhu">
          <h4>UjiUsia</h4>

          <div class="sl-test-row">
            <input class="sl-pill" name="suhu_uji" value="31 °C" />
            <button class="sl-btn-test" type="button">Test</button>
          </div>

          <div class="sl-result">
            <div class="name">Dingin</div>
            <div class="val">0</div>

            <div class="name">Normal</div>
            <div class="val">1</div>

            <div class="name">Panas</div>
            <div class="val">0,1</div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
@endsection
