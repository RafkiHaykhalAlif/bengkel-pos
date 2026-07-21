<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<title>@yield('title', 'Sistem POS') — Bengkel Anton Motor</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
  :root {
    --primary:#1A56DB; --primary-dark:#1E429F; --header-bg:#1E2A4A;
    --footer-bg:#1E429F; --bg:#D6E0FF; --white:#FFFFFF;
    --text-main:#111827; --text-sub:#6B7280; --border:#C7D4F0;
    --success:#057A55; --success-light:#DEF7EC;
    --warning:#C27803; --warning-light:#FDF6B2;
    --danger:#DC2626; --danger-light:#FEF2F2;
  }
  body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); min-height:100vh; display:flex; flex-direction:column; overflow-x:hidden; }

  /* Topbar */
  .topbar { height:56px; background:var(--header-bg); display:flex; align-items:center; justify-content:space-between; padding:0 28px; position:sticky; top:0; z-index:100; box-shadow:0 2px 8px rgba(0,0,0,0.15); }
  .topbar-brand { display:flex; align-items:center; gap:10px; }
  .brand-logo-sm { width:32px; height:32px; border-radius:8px; object-fit:cover; border:1.5px solid rgba(255,255,255,0.2); }
  .topbar-title { color:#fff; font-size:15px; font-weight:700; letter-spacing:0.04em; text-transform:uppercase; }
  .topbar-right { display:flex; align-items:center; gap:16px; }
  .topbar-user { display:flex; align-items:center; gap:8px; color:rgba(255,255,255,0.85); font-size:13px; font-weight:500; }
  .topbar-avatar { width:30px; height:30px; background:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:13px; color:#fff; font-weight:700; }
  .btn-logout { padding:6px 14px; background:rgba(255,255,255,0.1); color:rgba(255,255,255,0.85); font-size:12.5px; font-weight:600; font-family:inherit; border:1px solid rgba(255,255,255,0.15); border-radius:6px; cursor:pointer; transition:background 0.2s; }
  .btn-logout:hover { background:rgba(255,255,255,0.18); }

  /* Layout */
  .layout { display:flex; flex:1; }

  /* Sidebar */
  .sidebar { width:220px; background:var(--header-bg); padding:24px 0; display:flex; flex-direction:column; gap:4px; position:sticky; top:56px; height:calc(100vh - 56px); overflow-y:auto; flex-shrink:0; }
  .sidebar-label { padding:0 20px; font-size:10.5px; font-weight:700; color:rgba(255,255,255,0.35); text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px; }
  .nav-item { display:flex; align-items:center; gap:10px; padding:10px 20px; color:rgba(255,255,255,0.65); font-size:13.5px; font-weight:500; text-decoration:none; border-left:3px solid transparent; transition:background 0.2s,color 0.2s; position:relative; }
  .nav-item:hover { background:rgba(255,255,255,0.06); color:rgba(255,255,255,0.9); }
  .nav-item.active { background:rgba(26,86,219,0.2); color:#fff; border-left-color:var(--primary); font-weight:600; }
  .nav-item.locked { opacity:0.4; cursor:not-allowed; pointer-events:none; }
  .nav-icon { font-size:15px; width:18px; text-align:center; }
  .nav-badge { position:absolute; right:14px; top:50%; transform:translateY(-50%); background:#EF4444; color:#fff; font-size:10px; font-weight:700; min-width:18px; height:18px; border-radius:99px; display:inline-flex; align-items:center; justify-content:center; padding:0 5px; }
  .nav-icon svg {
    opacity: 0.75;
    flex-shrink: 0;
  }
  .nav-item.active .nav-icon svg,
  .nav-item:hover .nav-icon svg {
    opacity: 1;
  }

  /* Main */
  .main { flex:1; padding:28px 32px; overflow-y:auto; min-width:0; }

  /* Footer */
  .footer { height:44px; background:var(--footer-bg); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.8); font-size:12.5px; font-weight:600; }
  .footer strong { color:#fff; }

  /* Hamburger */
  .btn-hamburger { display:none; background:none; border:none; cursor:pointer; padding:6px; color:#fff; flex-direction:column; gap:5px; }
  .btn-hamburger span { display:block; width:22px; height:2px; background:#fff; border-radius:2px; transition:all 0.3s; }

  /* Sidebar overlay */
  .sidebar-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:149; }
  .sidebar-overlay.show { display:block; }

  /* Responsive: tablet */
  @media (max-width:900px) {
    .topbar { padding:0 16px; }
    .topbar-title { font-size:13px; }
    .main { padding:20px 16px; }
    .sidebar { width:200px; }
  }

  /* Responsive: mobile */
  @media (max-width:640px) {
    .topbar { padding:0 14px; height:52px; }
    .topbar-title { font-size:12px; letter-spacing:0; }
    .btn-hamburger { display:flex; }
    .topbar-user span { display:none; }
    .btn-logout { padding:5px 10px; font-size:11.5px; }
    .sidebar {
      position:fixed;
      top:0; left:0;
      height:100vh;
      width:260px;
      z-index:150;
      transform:translateX(-100%);
      transition:transform 0.28s ease;
      padding-top:68px;
    }
    .sidebar.open { transform:translateX(0); }
    .main { padding:14px 12px; }
    .footer { font-size:11px; height:38px; }
  }

  @yield('styles')
</style>
@yield('head')
</head>
<body>

<!-- Topbar -->
<div class="topbar">
  <div class="topbar-brand">
    <button class="btn-hamburger" id="hamburgerBtn" onclick="toggleSidebar()" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-logo-sm" />
    <div class="topbar-title">Sistem Point of Sale</div>
  </div>
  <div class="topbar-right">
    <div class="topbar-user">
      <div class="topbar-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
      <span>{{ Auth::user()->name }}</span>
    </div>
    <form method="POST" action="{{ route('logout') }}" style="margin:0">
      @csrf
      <button type="submit" class="btn-logout">Logout</button>
    </form>
  </div>
</div>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<div class="layout">
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-label">Menu Navigasi</div>
      <a class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <span class="nav-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
        </span> Dashboard
      </a>
      <a class="nav-item {{ request()->routeIs('pos.eceran') ? 'active' : '' }}" href="{{ route('pos.eceran') }}">
        <span class="nav-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM5.82 6h13.18l-1.5 7H7.5L5.82 6zM1 1h3l.74 3.5M7.5 13H17"/></svg>
        </span> POS Eceran
      </a>
      <a class="nav-item {{ request()->routeIs('pos.grosir') ? 'active' : '' }}" href="{{ route('pos.grosir') }}">
        <span class="nav-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M20 7H4l1 10h14l1-10zM1 1h3l2.5 11.5M9 21a1 1 0 1 0 2 0 1 1 0 0 0-2 0zm7 0a1 1 0 1 0 2 0 1 1 0 0 0-2 0zM4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/></svg>
        </span> POS Grosir
      </a>
      <a class="nav-item {{ request()->routeIs('transaksi.*') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
        <span class="nav-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 7V3.5L18.5 9H13zM8 13h8v1H8zm0 3h8v1H8zm0-6h5v1H8z"/></svg>
        </span> Riwayat Transaksi
      </a>
      <a class="nav-item {{ request()->routeIs('inventaris') ? 'active' : '' }}" href="{{ route('inventaris') }}">
        <span class="nav-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M20 3H4v2h16V3zm1 5H3l1 13h16l1-13zM9 14H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2z"/></svg>
        </span> Inventaris
        @php $stokMenipis = \App\Models\Barang::whereColumn('stok', '<', 'min_stok')->count(); @endphp
        @if($stokMenipis > 0)
          <span class="nav-badge">{{ $stokMenipis }}</span>
        @endif
      </a>

      @if(Auth::user()->role === 'owner')
        <a class="nav-item {{ request()->routeIs('laporan.penjualan') ? 'active' : '' }}" href="{{ route('laporan.penjualan') }}">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3v18h18V3H3zm16 16H5V5h14v14zM7 14h2v3H7zm4-4h2v7h-2zm4-3h2v10h-2z"/></svg>
          </span> Laporan Penjualan
        </a>
        <a class="nav-item {{ request()->routeIs('laporan.keuangan') ? 'active' : '' }}" href="{{ route('laporan.keuangan') }}">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
          </span> Laporan Keuangan
        </a>
      @else
        <span class="nav-item locked">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3v18h18V3H3zm16 16H5V5h14v14zM7 14h2v3H7zm4-4h2v7h-2zm4-3h2v10h-2z"/></svg>
          </span> Laporan Penjualan 🔒
        </span>
        <span class="nav-item locked">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
          </span> Laporan Keuangan 🔒
        </span>
      @endif
  </div>

  <!-- Content -->
  <div class="main">
    @yield('content')
  </div>
</div>

<div class="footer"><strong>Bengkel Anton Motor</strong>&nbsp;|&nbsp;Lubuk Basung</div>

@yield('scripts')
<script>
// ── Toggle sidebar dan overlay untuk mobile view ──
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
  document.getElementById('sidebarOverlay').classList.toggle('show');
}

// ── Tutup sidebar saat klik di luar sidebar (overlay) ──
function closeSidebar() {
  document.getElementById('sidebar').classList.remove('open');
  document.getElementById('sidebarOverlay').classList.remove('show');
}

// ── Close sidebar when nav item clicked on mobile ──
document.querySelectorAll('.nav-item').forEach(function(el) {
  el.addEventListener('click', function() {
    if (window.innerWidth <= 640) closeSidebar();
  });
});
</script>
</body>
</html>