<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SmartLiter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --brand: #53B46A;
      --brand-2: #2F8F57;
      --brand-dark: #1E6A3E;
      --ink: #0f172a;
      --soft: #f3f4f6;
      --blue: #1c5a9a;
      --shadow: 0 20px 35px rgba(0,0,0,.12);
      --grad-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    * {
      font-family: 'Inter', sans-serif;
    }

    body {
      color: var(--ink);
      background: #fff;
      overflow-x: hidden;
    }

    /* NAVBAR UPDATED */
    .navbar {
      background: rgba(47, 143, 87, 0.95);
      backdrop-filter: blur(10px);
      padding: 1rem 0;
      box-shadow: 0 4px 20px rgba(0,0,0,.08);
    }

    .navbar-brand {
      font-weight: 900;
      letter-spacing: -0.5px;
      font-size: 1.5rem;
      background: linear-gradient(135deg, #fff, #e0ffe0);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-shadow: none;
    }

    .navbar .nav-link {
      font-weight: 600;
      color: #fff !important;
      position: relative;
      padding: 0.5rem 1rem !important;
    }

    .navbar .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 2px;
      background: #fff;
      transition: all 0.3s ease;
      transform: translateX(-50%);
    }

    .navbar .nav-link:hover::after {
      width: 70%;
    }

    /* HERO REDESIGN - MIRIP GAMBAR */
    .hero {
      position: relative;
      min-height: 600px;
      background: linear-gradient(115deg, #1a4f2e 0%, #2e7d5e 45%, #46987a 100%);
      overflow: hidden;
    }

    /* ANIMATED LEAVES BACKGROUND */
    .floating-leaves {
      position: absolute;
      inset: 0;
      pointer-events: none;
    }

    .leaf {
      position: absolute;
      color: rgba(255,255,255,.15);
      font-size: 2rem;
      animation: floatLeaf 20s infinite linear;
    }

    @keyframes floatLeaf {
      0% { transform: translateY(100vh) rotate(0deg) scale(0.8); opacity: 0; }
      10% { opacity: 0.5; }
      90% { opacity: 0.3; }
      100% { transform: translateY(-20vh) rotate(360deg) scale(1.2); opacity: 0; }
    }

    /* geometric pattern seperti gambar */
    .hero-pattern {
      position: absolute;
      inset: 0;
      background-image: 
        linear-gradient(45deg, rgba(255,255,255,.05) 25%, transparent 25%),
        linear-gradient(-45deg, rgba(255,255,255,.05) 25%, transparent 25%);
      background-size: 40px 40px;
      opacity: 0.4;
    }

    /* overlay miring yang ikonik */
    .hero-diagonal {
      position: absolute;
      inset: 0;
      background: linear-gradient(112deg, 
        rgba(32, 78, 58, 0.85) 0%,
        rgba(58, 121, 84, 0.65) 45%,
        transparent 70%
      );
      clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
    }

    .hero-text-wrap {
      position: relative;
      z-index: 10;
      padding: 100px 0;
    }

    .hero-text {
      color: #fff;
      font-weight: 900;
      line-height: 1.1;
      font-size: clamp(2.5rem, 5vw, 4rem);
      text-shadow: 0 15px 30px rgba(0,0,0,.25);
      letter-spacing: -0.02em;
      position: relative;
    }

    .hero-text span {
      display: inline-block;
      background: linear-gradient(145deg, #fff, #e0ffe0);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: glowText 3s ease-in-out infinite;
    }

    @keyframes glowText {
      0%, 100% { filter: drop-shadow(0 0 2px rgba(255,255,255,.5)); }
      50% { filter: drop-shadow(0 0 15px rgba(255,255,255,.8)); }
    }

    /* KALKULATOR SECTION - LEBIH ELEGAN */
    .section-soft {
      position: relative;
      padding: 80px 0;
      background: linear-gradient(145deg, #f8fafc, #eef2f5);
      overflow: hidden;
    }

    .card-soft {
      border: none;
      border-radius: 28px;
      box-shadow: 0 25px 50px -8px rgba(0,0,0,.12);
      background: rgba(255,255,255,.95);
      backdrop-filter: blur(10px);
      padding: 2rem;
      transition: transform 0.3s ease;
    }

    .card-soft:hover {
      transform: translateY(-5px);
    }

    .input-group-custom {
      border: 2px solid #e9eef4;
      border-radius: 18px;
      overflow: hidden;
      transition: all 0.3s ease;
      background: white;
    }

    .input-group-custom:focus-within {
      border-color: var(--brand);
      box-shadow: 0 0 0 4px rgba(83,180,106,.15);
    }

    .form-control-custom {
      border: none;
      padding: 1rem 1.2rem;
      font-size: 1.1rem;
      font-weight: 600;
    }

    .input-group-text-custom {
      border: none;
      background: white;
      color: var(--brand-dark);
      font-weight: 700;
      padding: 0 1.2rem;
    }

    .btn-brand {
      background: linear-gradient(145deg, var(--brand-dark), #0f4a2a);
      color: white;
      border: none;
      border-radius: 18px;
      padding: 1rem 2rem;
      font-weight: 800;
      letter-spacing: 1px;
      transition: all 0.2s ease;
      position: relative;
      overflow: hidden;
    }

    .btn-brand::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255,255,255,.3);
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }

    .btn-brand:hover::before {
      width: 300px;
      height: 300px;
    }

    .btn-brand:hover {
      background: linear-gradient(145deg, #1e6a3e, #165a34);
      transform: scale(0.98);
    }

    /* JURNAL SECTION REDESIGN - DENGAN PDF VIEWER */
    #jurnal {
      padding: 80px 0;
      background: linear-gradient(145deg, #b3ebfc, #bddc74);
      position: relative;
    }

    .journal-slider {
      display: flex;
      gap: 25px;
      overflow-x: auto;
      padding: 20px 0;
      scrollbar-width: none;
      position: relative;
      animation: slideJournals 25s infinite linear;
    }

    .journal-slider:hover {
      animation-play-state: paused;
    }

    @keyframes slideJournals {
      0% { transform: translateX(0); }
      50% { transform: translateX(calc(-100% + 900px)); }
      100% { transform: translateX(0); }
    }

    .journal-slider::-webkit-scrollbar {
      display: none;
    }

    .journal-card-modern {
      min-width: 350px;
      background: rgba(255,255,255,.97);
      border-radius: 24px;
      padding: 1.8rem;
      display: flex;
      gap: 20px;
      box-shadow: 0 20px 35px rgba(0,0,0,.2);
      border: 1px solid rgba(255,255,255,.2);
      transition: all 0.3s ease;
    }

    .journal-card-modern:hover {
      transform: scale(1.02) translateY(-5px);
      box-shadow: 0 30px 45px rgba(0,0,0,.3);
    }

    .journal-icon-modern {
      width: 70px;
      height: 70px;
      background: linear-gradient(145deg, #e6f7e6, #d0ecd0);
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .journal-icon-modern svg {
      width: 40px;
      height: 40px;
      color: var(--brand-dark);
    }

    .pdf-container {
      margin-top: 15px;
      border-radius: 16px;
      overflow: hidden;
      border: 3px solid rgba(255,255,255,.1);
      background: #f0f3f7;
      transition: all 0.3s ease;
    }

    .pdf-preview {
      width: 100%;
      height: 180px;
      border: none;
      background: white;
    }

    .badge-new {
      position: absolute;
      top: -8px;
      right: 15px;
      background: linear-gradient(145deg, #ff6b6b, #ee5253);
      color: white;
      padding: 5px 15px;
      border-radius: 30px;
      font-size: 0.8rem;
      font-weight: 800;
      box-shadow: 0 5px 15px rgba(238,82,83,.3);
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }

    /* PLANT ICON ANIMATION */
    .plant-icon {
      position: absolute;
      bottom: 20px;
      left: 20px;
      animation: sway 4s ease-in-out infinite;
      transform-origin: bottom center;
    }

    @keyframes sway {
      0%, 100% { transform: rotate(-3deg); }
      50% { transform: rotate(3deg); }
    }

    .footer {
      background: #1f8d78;
      color: #1a1e1f;
      padding: 30px 0;
      text-align: center;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .hero-text {
        font-size: 2.2rem;
      }
      .journal-slider {
        animation: none;
      }
      .journal-card-modern {
        min-width: 280px;
      }
    }
  </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">🌿 SmartLiter</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto gap-2">
        <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="#kalkulator">Kalkulator Rekomendasi Air</a></li>
        <li class="nav-item"><a class="nav-link" href="#jurnal">Jurnal</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- HERO DENGAN ANIMASI DAN BACKGROUND DINAMIS -->
<section id="beranda" class="hero d-flex align-items-center">
  <!-- Floating Leaves Animation -->
  <div class="floating-leaves">
    <div class="leaf" style="left: 10%; animation-delay: 0s;">🌱</div>
    <div class="leaf" style="left: 30%; animation-delay: 3s;">🌿</div>
    <div class="leaf" style="left: 50%; animation-delay: 1s;">🍃</div>
    <div class="leaf" style="left: 70%; animation-delay: 5s;">🌾</div>
    <div class="leaf" style="left: 90%; animation-delay: 2s;">🌻</div>
    <div class="leaf" style="left: 20%; animation-delay: 7s;">🌺</div>
  </div>
  
  <div class="hero-pattern"></div>
  <div class="hero-diagonal"></div>
  
  <!-- Plant animation at bottom -->
  <div class="plant-icon">
    <span style="font-size: 3rem; filter: drop-shadow(0 10px 15px rgba(0,0,0,.3));">🌳</span>
  </div>
  
  <div class="container hero-text-wrap">
    <div class="row">
      <div class="col-lg-7 offset-lg-5">
        <div class="hero-text">
          <span>Sebuah Tempat</span><br>
          <span>Informasi Kesehatan</span><br>
          <span>Tanaman</span>
        </div>
        <div class="mt-4 text-white opacity-75" style="animation: fadeInUp 1s ease;">
          <span style="display: inline-block; animation: bounce 2s infinite;">✨</span> Smart Farming Solution
        </div>
      </div>
    </div>
  </div>
</section>

<!-- KALKULATOR DENGAN INTERAKTIF -->
<section id="kalkulator" class="section-soft">
  <div class="container">
    <div class="row g-5 align-items-stretch">
      <div class="col-lg-7">
        <div class="card-soft">
          <h2 class="fw-bold mb-4" style="color: var(--brand-dark);">💧 Hitung Kebutuhan Air</h2>
          
          <form method="POST" action="{{ route('kalkulator.hitung') }}">
            @csrf
            
            <div class="row g-4">
              <!-- Suhu -->
              <div class="col-12">
                <label class="form-label fw-bold">🌡️ Suhu Udara</label>
                <div class="input-group input-group-custom">
                  <input type="number" step="0.1" name="suhu" class="form-control form-control-custom" 
                         value="{{ old('suhu', 20) }}" placeholder="20">
                  <span class="input-group-text input-group-text-custom">°C</span>
                </div>
              </div>
              
              <!-- Kelembapan Udara -->
              <div class="col-12">
                <label class="form-label fw-bold">💨 Kelembapan Udara</label>
                <div class="input-group input-group-custom">
                  <input type="number" step="0.1" name="kelembapan_udara" class="form-control form-control-custom"
                         value="{{ old('kelembapan_udara', 20) }}" placeholder="20">
                  <span class="input-group-text input-group-text-custom">%</span>
                </div>
              </div>
              
              <!-- Kelembapan Tanah -->
              <div class="col-12">
                <label class="form-label fw-bold">🌱 Kelembapan Tanah</label>
                <div class="input-group input-group-custom">
                  <input type="number" step="0.1" name="kelembapan_tanah" class="form-control form-control-custom"
                         value="{{ old('kelembapan_tanah', 20) }}" placeholder="20">
                  <span class="input-group-text input-group-text-custom">%</span>
                </div>
              </div>
              
              <!-- Umur Tanaman -->
              <div class="col-12">
                <label class="form-label fw-bold">📅 Umur Tanaman</label>
                <div class="input-group input-group-custom">
                  <input type="number" step="1" name="umur" class="form-control form-control-custom"
                         value="{{ old('umur', 20) }}" placeholder="20">
                  <span class="input-group-text input-group-text-custom">Hari</span>
                </div>
              </div>
            </div>
            
            <div class="mt-5">
              <button class="btn btn-brand w-100">HITUNG REKOMENDASI AIR →</button>
            </div>
          </form>
          
          @if(session('hasil') !== null)
            <div class="mt-5 p-4 bg-light rounded-4" style="border-left: 5px solid var(--brand);">
              <div class="d-flex align-items-center gap-3">
                <span style="font-size: 2rem;">💦</span>
                <div>
                  <div class="text-muted small">REKOMENDASI AIR</div>
                  <div class="fw-bold" style="font-size: 2.2rem; color: var(--brand-dark);">
                    {{ session('hasil') }} <small style="font-size: 1rem;">ml</small>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
      
      <div class="col-lg-5 d-flex align-items-center">
        <div class="kalkulator-desc text-center p-5 rounded-4" style="background: rgba(83,180,106,.1); backdrop-filter: blur(5px); border: 1px solid rgba(83,180,106,.3);">
          <span style="font-size: 3rem; display: block; animation: pulse 2s infinite;">🤖</span>
          <h4 class="fw-bold mt-3" style="color: var(--brand-dark);">Fuzzy Logic Smart Calculator</h4>
          <p class="mb-0 text-muted">Kalkulator pintar yang menggunakan logika fuzzy untuk menentukan jumlah air yang dibutuhkan tanaman agar tumbuh sehat.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- JURNAL DENGAN PDF PREVIEW LANGSUNG -->
<section id="jurnal">
  <div class="container position-relative">
    <div class="d-flex align-items-center justify-content-between mb-5">
      <div>
        <h2 class="text-white fw-bold mb-1" style="font-size: 2.5rem;">📚 Jurnal & Publikasi</h2>
        <p class="text-white-50 mb-0">Koleksi jurnal agrikultur dan penelitian tanaman</p>
      </div>
      <span class="badge-new">+3 Update</span>
    </div>
    
    <!-- JOURNAL SLIDER DENGAN ANIMASI -->
    <div class="journal-slider">
      @forelse($journals ?? [] as $index => $j)
        <div class="journal-card-modern position-relative">
          <div class="journal-icon-modern">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
              <path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 0 4 19.5z" />
              <path d="M8 6h8M8 10h8M8 14h6" />
            </svg>
          </div>
          <div class="flex-grow-1">
            <h4 class="fw-bold" style="color: var(--brand-dark);">{{ $j->title ?? 'Smart Farming Vol. '.($index+1) }}</h4>
            <p class="text-muted small mb-2">{{ $j->summary ?? 'Penelitian terkait optimasi irigasi menggunakan fuzzy logic untuk tanaman hidroponik.' }}</p>
            
            <!-- PDF PREVIEW LANGSUNG -->
            <div class="pdf-container">
              <iframe src="{{ asset('pdfs/journal-'.($index+1).'.pdf') }}" 
                      class="pdf-preview"
                      title="PDF Preview">
              </iframe>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-3">
              <span class="badge bg-success">PDF Tersedia</span>
              <a href="{{ route('jurnal.download', $j->id ?? 1) }}" class="btn btn-sm btn-outline-success fw-bold">
                📥 Unduh PDF
              </a>
            </div>
          </div>
        </div>
      @empty
        <!-- SAMPLE PDF JIKA TIDAK ADA DATA -->
        @php
          $sampleJournals = [
            ['title' => 'Evaluasi Sistem Irigasi', 'summary' => 'Analisis efisiensi irigasi tetes pada tanaman cabai.', 'pdf' => 'sample1.pdf'],
            ['title' => 'Pertahanan Tanah', 'summary' => 'Studi kasus pengaruh kelembaban tanah terhadap pertumbuhan akar.', 'pdf' => 'sample2.pdf'],
            ['title' => 'Pengaruh Kuantitas Air', 'summary' => 'Optimalisasi pemberian air menggunakan fuzzy logic.', 'pdf' => 'sample3.pdf'],
            ['title' => 'Smart Greenhouse', 'summary' => 'Implementasi IoT pada greenhouse modern.', 'pdf' => 'sample4.pdf']
          ];
        @endphp
        
        @foreach($sampleJournals as $j)
          <div class="journal-card-modern">
            <div class="journal-icon-modern">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                <path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 0 4 19.5z" />
              </svg>
            </div>
            <div>
              <h4 class="fw-bold" style="color: var(--brand-dark);">{{ $j['title'] }}</h4>
              <p class="text-muted small">{{ $j['summary'] }}</p>
              
              <!-- PDF Preview dengan dummy PDF - bisa diganti dengan actual PDF -->
              <div class="pdf-container">
                <div style="background: #e9ecef; height: 180px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                  <span style="font-size: 3rem;">📄</span>
                  <span class="text-muted mt-2">Preview PDF: {{ $j['pdf'] }}</span>
                </div>
              </div>
              
              <div class="mt-3">
                <a href="#" class="btn btn-sm btn-success fw-bold w-100" onclick="alert('Demo: PDF akan didownload')">
                  📥 Download PDF
                </a>
              </div>
            </div>
          </div>
        @endforeach
      @endforelse
    </div>
    
    <!-- Navigation dots -->
    <div class="dots-wrap mt-5">
      <span class="dot active"></span>
      <span class="dot"></span>
      <span class="dot"></span>
      <span class="dot"></span>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-6 text-md-start">
        <span class="fw-bold text-white">🌿 SmartLiter</span> © {{ date('Y') }}
      </div>
      <div class="col-md-6 text-md-end">
        <span class="text-white-50">Dikembangkan dengan 💚 untuk petani Indonesia</span>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Auto-animate untuk floating leaves
  document.addEventListener('DOMContentLoaded', function() {
    // Add more dynamic leaves
    setInterval(() => {
      const leaves = document.querySelectorAll('.leaf');
      leaves.forEach(leaf => {
        leaf.style.animation = 'none';
        leaf.offsetHeight;
        leaf.style.animation = 'floatLeaf 20s infinite linear';
      });
    }, 30000); // reset animation every 30 seconds
  });
  
  // Navbar scroll effect
  window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
      navbar.style.background = 'rgba(26, 71, 42, 0.98)';
      navbar.style.backdropFilter = 'blur(15px)';
    } else {
      navbar.style.background = 'rgba(47, 143, 87, 0.95)';
    }
  });
</script>

</body>
</html>