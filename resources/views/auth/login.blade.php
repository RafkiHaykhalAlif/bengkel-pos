<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Bengkel Anton Motor</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
  body { font-family:'Plus Jakarta Sans',sans-serif; background:#EEF2FF; min-height:100vh; display:flex; align-items:center; justify-content:center; }
  .card { display:flex; width:900px; min-height:500px; border-radius:20px; overflow:hidden; box-shadow:0 20px 60px rgba(30,66,159,0.18); }

  /* Left */
  .left { width:44%; background:linear-gradient(155deg,#1E2A4A 0%,#1E429F 55%,#2563EB 100%); padding:40px 36px; display:flex; flex-direction:column; position:relative; overflow:hidden; }
  .left::before { content:''; position:absolute; width:280px; height:280px; background:rgba(255,255,255,0.06); border-radius:50%; top:-80px; right:-80px; }
  .left::after  { content:''; position:absolute; width:200px; height:200px; background:rgba(255,255,255,0.05); border-radius:50%; bottom:-60px; left:-60px; }
  .brand { display:flex; align-items:center; gap:12px; position:relative; z-index:1; margin-bottom:auto; }
  .brand-logo { width:48px; height:48px; border-radius:12px; object-fit:cover; border:2px solid rgba(255,255,255,0.25); box-shadow:0 4px 14px rgba(0,0,0,0.25); }
  .brand-logo-placeholder { width:48px; height:48px; border-radius:12px; background:rgba(255,255,255,0.15); border:2px solid rgba(255,255,255,0.25); display:flex; align-items:center; justify-content:center; font-size:20px; }
  .brand-name { font-size:15px; font-weight:800; color:#fff; line-height:1.1; }
  .brand-sub  { font-size:11px; font-weight:600; color:rgba(255,255,255,0.55); letter-spacing:0.08em; text-transform:uppercase; }
  .left-body  { position:relative; z-index:1; margin:32px 0; }
  .left-title { font-size:28px; font-weight:800; color:#fff; line-height:1.2; margin-bottom:10px; }
  .left-desc  { font-size:13px; color:rgba(255,255,255,0.7); line-height:1.6; }
  .features   { position:relative; z-index:1; display:flex; flex-direction:column; gap:12px; margin-top:auto; }
  .feature-item { display:flex; align-items:center; gap:10px; font-size:13px; color:rgba(255,255,255,0.8); font-weight:500; }
  .feature-dot  { width:7px; height:7px; border-radius:50%; background:rgba(255,255,255,0.5); flex-shrink:0; }

  /* Right */
  .right { width:56%; background:#fff; padding:52px 48px; display:flex; flex-direction:column; justify-content:center; }
  .form-title    { font-size:28px; font-weight:800; color:#111827; margin-bottom:6px; }
  .form-subtitle { font-size:13.5px; color:#6B7280; margin-bottom:32px; }
  .form-group { display:flex; flex-direction:column; gap:6px; margin-bottom:18px; }
  .form-group label { font-size:13px; font-weight:700; color:#111827; }
  .input-wrap { position:relative; }
  .form-group input { width:100%; padding:12px 40px 12px 14px; border:1.5px solid #C7D4F0; border-radius:10px; font-size:14px; font-family:inherit; color:#111827; background:#F8FAFF; outline:none; transition:border-color 0.2s,box-shadow 0.2s; }
  .form-group input::placeholder { color:#9CA3AF; }
  .form-group input:focus { border-color:#1A56DB; background:#fff; box-shadow:0 0 0 3px rgba(26,86,219,0.1); }
  .form-group input.is-invalid { border-color:#DC2626; background:#FEF2F2; }
  .toggle-pw { position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9CA3AF; padding:0; display:flex; align-items:center; }
  .toggle-pw:hover { color:#1A56DB; }
  .error-msg { display:flex; align-items:center; gap:8px; padding:10px 14px; background:#FEF2F2; border:1px solid #FECACA; border-radius:8px; font-size:13px; font-weight:600; color:#DC2626; margin-bottom:18px; }
  .btn-login { width:100%; padding:13px; background:#1E429F; color:#fff; font-size:15px; font-weight:700; font-family:inherit; border:none; border-radius:10px; cursor:pointer; transition:background 0.2s,transform 0.15s; margin-bottom:20px; }
  .btn-login:hover { background:#1A56DB; transform:translateY(-1px); }
  .form-footer { text-align:center; font-size:12.5px; color:#9CA3AF; }
  .form-footer strong { color:#1E429F; font-weight:700; }

  /* Tablet */
  @media (max-width:800px) {
    body { padding:20px; align-items:flex-start; padding-top:40px; }
    .card { width:100%; max-width:600px; margin:0 auto; }
    .left { width:40%; padding:32px 24px; }
    .left-title { font-size:22px; }
    .right { width:60%; padding:36px 28px; }
  }

  /* Mobile */
  @media (max-width:560px) {
    body {
      padding:0;
      align-items:center;
      justify-content:center;
      background:linear-gradient(155deg,#1E2A4A 0%,#1E429F 55%,#2563EB 100%);
      min-height:100vh;
    }
    .card {
      flex-direction:column;
      width:calc(100% - 32px);
      max-width:400px;
      min-height:auto;
      border-radius:20px;
      box-shadow:0 20px 60px rgba(0,0,0,0.35);
      overflow:hidden;
    }

    /* Left: brand header compact */
    .left {
      width:100%;
      padding:24px 24px 20px;
      min-height:auto;
      background:linear-gradient(155deg,#1E2A4A 0%,#1E429F 60%,#2563EB 100%);
    }
    .left::before { width:160px; height:160px; top:-50px; right:-40px; }
    .left::after  { width:100px; height:100px; bottom:-30px; left:-30px; }
    .brand { margin-bottom:0; }
    .left-body { margin:14px 0 0; }
    .left-title { font-size:18px; margin-bottom:6px; }
    .left-desc { font-size:11.5px; }
    .features { display:none; }

    /* Right: form area */
    .right { width:100%; padding:24px 24px 28px; }
    .form-title { font-size:20px; }
    .form-subtitle { font-size:12.5px; margin-bottom:20px; }
    .form-group { margin-bottom:14px; }
    .form-group input { padding:11px 40px 11px 14px; font-size:14px; }
    .btn-login { padding:13px; font-size:14px; margin-bottom:16px; }
    .form-footer { font-size:11.5px; }
  }

</style>
</head>
<body>
<div class="card">
  <!-- Left -->
  <div class="left">
    <div class="brand">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-logo" />
      <div>
        <div class="brand-name">Anton Motor</div>
        <div class="brand-sub">Lubuk Basung</div>
      </div>
    </div>

    <div class="left-body">
      <div class="left-title">Sistem Point of Sale</div>
      <div class="left-desc">Kelola transaksi dan stok barang bengkel Anda secara digital, cepat, dan akurat.</div>
    </div>

    <div class="features">
      <div class="feature-item"><div class="feature-dot"></div>Pencatatan transaksi real-time</div>
      <div class="feature-item"><div class="feature-dot"></div>Monitoring stok otomatis</div>
      <div class="feature-item"><div class="feature-dot"></div>Laporan penjualan &amp; keuangan</div>
    </div>
  </div>

  <!-- Right -->
  <div class="right">
    <div class="form-title">Selamat Datang</div>
    <div class="form-subtitle">Masuk ke akun Anda untuk melanjutkan</div>

    @if($errors->any())
      <div class="error-msg">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf

      <div class="form-group">
        <label>Username</label>
        <div class="input-wrap">
          <input type="text" name="username" value="{{ old('username') }}"
            placeholder="Masukkan username" autocomplete="username"
            class="{{ $errors->has('username') ? 'is-invalid' : '' }}" />
        </div>
      </div>

      <div class="form-group">
        <label>Password</label>
        <div class="input-wrap">
          <input type="password" name="password" id="passwordInput"
            placeholder="Masukkan password" autocomplete="current-password"
            class="{{ $errors->has('password') ? 'is-invalid' : '' }}" />
          <button type="button" class="toggle-pw" onclick="togglePw()">
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
      </div>

      <button type="submit" class="btn-login">Masuk</button>
    </form>

    <div class="form-footer">
      Sistem Point of Sale — <strong>Bengkel Anton Motor</strong>
    </div>
  </div>
</div>

<script>
// ── Toggle visibility password ──
function togglePw() {
  const pw  = document.getElementById('passwordInput');
  const ico = document.getElementById('eyeIcon');
  const isHidden = pw.type === 'password';
  pw.type = isHidden ? 'text' : 'password';
  ico.innerHTML = isHidden
    ? '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>'
    : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
}
</script>
</body>
</html>