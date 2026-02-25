<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="page">
        {{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-top">
        <button class="icon-btn" id="btnToggle" title="Menu" type="button">☰</button>
    </div>

    <nav class="sidebar-nav">

        @php
  $admin = auth('admin')->user();
  $avatarUrl = $admin && $admin->avatar
    ? asset('storage/'.$admin->avatar)
    : asset('images/default-avatar.png'); 
@endphp

<div class="profile-box">
  <form method="POST" action="{{ route('admin.profile.avatar') }}" enctype="multipart/form-data">
    @csrf

    <label class="avatar-wrap" title="Ganti Foto">
      <img src="{{ $avatarUrl }}" alt="Avatar" class="avatar-img">
      <input type="file" name="avatar" accept="image/*" class="avatar-input" onchange="this.form.submit()">
    </label>

    <div class="profile-name">{{ $admin?->name ?? 'Admin' }}</div>
    <div class="profile-email">{{ $admin?->email ?? '' }}</div>
  </form>
</div>


    <a class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
     href="{{ route('admin.dashboard') }}">
      <span class="mi">🏠</span>
      <span class="mt">Dashboard</span>
  </a>

  @php $isFuzzy = request()->routeIs('admin.fuzzy.*'); @endphp

  <button type="button"
          class="side-link side-link-btn {{ $isFuzzy ? 'active' : '' }}"
          id="btnFuzzy">
      <span class="mi">⚙️</span>
      <span class="mt">Konfigurasi Fuzzy</span>
      <span class="chev" id="chevFuzzy">▾</span>
  </button>

  <div class="submenu {{ $isFuzzy ? 'open' : '' }}" id="submenuFuzzy">
      <a class="sub-link {{ request()->routeIs('admin.fuzzy.suhu') ? 'active' : '' }}"
         href="{{ route('admin.fuzzy.suhu') }}">
          <span class="si">🌡️</span>
          <span class="st">Suhu Udara</span>
      </a>

      <a class="sub-link {{ request()->routeIs('admin.fuzzy.k_udara') ? 'active' : '' }}"
         href="{{ route('admin.fuzzy.k_udara') }}">
          <span class="si">💧</span>
          <span class="st">Kelembapan Udara</span>
      </a>

      <a class="sub-link {{ request()->routeIs('admin.fuzzy.k_tanah') ? 'active' : '' }}"
         href="{{ route('admin.fuzzy.k_tanah') }}">
          <span class="si">🌱</span>
          <span class="st">Kelembapan Tanah</span>
      </a>

      <a class="sub-link {{ request()->routeIs('admin.fuzzy.usia') ? 'active' : '' }}"
         href="{{ route('admin.fuzzy.usia') }}">
          <span class="si">🪴</span>
          <span class="st">Usia Tanaman</span>
      </a>
  </div>

  <a class="side-link {{ request()->routeIs('admin.riwayat.*') ? 'active' : '' }}"
     href="{{ route('admin.riwayat.index') }}">
      <span class="mi">🕘</span>
      <span class="mt">Riwayat Perhitungan</span>
  </a>

  <a class="side-link {{ request()->routeIs('admin.artikel.*') ? 'active' : '' }}"
   href="{{ route('admin.jurnal.index') }}">
    <span class="mi">📰</span>
    <span class="mt">Kelola Jurnal</span>
</a>
</nav>

            <div class="sidebar-bottom">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="sidebar-login" type="submit">Keluar</button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <main class="main">
            {{-- Topbar --}}
            <header class="topbar">
                <div class="brand">SmartLiter</div>
            </header>

            {{-- Subbar --}}
            <div class="subbar">
                <div class="welcome">Selamat Datang Admin!</div>
            </div>

            <section class="content">
                @yield('content')
            </section>
        </main>
    </div>

    @stack('scripts')

    <script>
  const sidebar = document.getElementById('sidebar');
  const btnToggle = document.getElementById('btnToggle');

  const btnFuzzy = document.getElementById('btnFuzzy');
  const submenuFuzzy = document.getElementById('submenuFuzzy');
  const chevFuzzy = document.getElementById('chevFuzzy');

  // Restore sidebar state
  const savedSidebar = localStorage.getItem('adminSidebarOpen');
  if (savedSidebar === '1') sidebar.classList.add('open');

  // Restore submenu state (only if not already opened by current route)
  const savedFuzzy = localStorage.getItem('adminFuzzyOpen');
  if (!submenuFuzzy.classList.contains('open') && savedFuzzy === '1') {
    submenuFuzzy.classList.add('open');
  }

  const syncChev = () => {
  const isOpen = submenuFuzzy.classList.contains('open');
  chevFuzzy.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
  chevFuzzy.textContent = isOpen ? '▴' : '▾';
};
  syncChev();

  btnToggle.addEventListener('click', () => {
    sidebar.classList.toggle('open');
    localStorage.setItem('adminSidebarOpen', sidebar.classList.contains('open') ? '1' : '0');
  });

  btnFuzzy.addEventListener('click', () => {
    // kalau sidebar lagi kecil, buka dulu biar submenu kelihatan
    if (!sidebar.classList.contains('open')) {
      sidebar.classList.add('open');
      localStorage.setItem('adminSidebarOpen', '1');
    }

    submenuFuzzy.classList.toggle('open');
    localStorage.setItem('adminFuzzyOpen', submenuFuzzy.classList.contains('open') ? '1' : '0');
    syncChev();
    
  });
</script>
</body>
</html>
