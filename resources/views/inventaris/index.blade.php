@extends('layouts.app')
@section('title', 'Inventaris')
@section('styles')
  .page-title{font-size:22px;font-weight:800;color:var(--text-main);margin-bottom:20px;}

  /* ── Alert Stok Menipis ── */
  .alert-box{background:#FFFBEB;border:1.5px solid #FCD34D;border-radius:12px;padding:14px 18px;margin-bottom:20px;}
  .alert-header{display:flex;align-items:center;gap:10px;cursor:pointer;user-select:none;}
  .alert-header-left{display:flex;align-items:center;gap:10px;flex:1;min-width:0;}
  .alert-icon{width:32px;height:32px;background:#FEF3C7;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}
  .alert-title{font-size:13.5px;font-weight:700;color:#92400E;}
  .alert-subtitle{font-size:12px;color:#B45309;font-weight:500;}
  .alert-toggle{display:flex;align-items:center;gap:5px;padding:4px 12px;background:#FEF3C7;border:1px solid #FCD34D;border-radius:6px;font-size:12px;font-weight:600;color:#92400E;flex-shrink:0;transition:background 0.2s;}
  .alert-toggle:hover{background:#FDE68A;}
  .alert-toggle .arrow{display:inline-block;transition:transform 0.25s;font-style:normal;}
  .alert-body{display:none;margin-top:12px;max-height:260px;overflow-y:auto;}
  .alert-body.open{display:block;}
  .alert-items{display:flex;flex-wrap:wrap;gap:8px;padding-bottom:2px;}
  .alert-item-chip{display:flex;align-items:center;gap:6px;background:#fff;border:1px solid #FCD34D;border-radius:20px;padding:4px 12px;font-size:12px;font-weight:600;color:#92400E;white-space:nowrap;}
  .alert-item-chip .stok-num{background:#FEF3C7;color:var(--warning);padding:1px 7px;border-radius:10px;font-size:11px;font-weight:700;}

  /* ── Top Row ── */
  .top-row{display:flex;gap:10px;align-items:center;margin-bottom:20px;flex-wrap:wrap;}
  .search-wrap{position:relative;flex:1;min-width:240px;max-width:380px;}
  .search-icon{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--text-sub);font-size:15px;pointer-events:none;}
  .search-input{width:100%;padding:10px 14px 10px 38px;border:1.5px solid var(--border);border-radius:8px;font-size:13.5px;font-family:inherit;color:var(--text-main);background:var(--white);outline:none;transition:border-color 0.2s;}
  .search-input:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(26,86,219,0.10);}
  .btn-cari{padding:10px 18px;background:var(--white);color:var(--text-main);font-size:13.5px;font-weight:600;font-family:inherit;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;transition:all 0.2s;}
  .btn-cari:hover{background:var(--primary-dark);color:#fff;border-color:var(--primary-dark);}
  .btn-import{padding:10px 18px;background:#ECFDF5;color:#065F46;font-size:13.5px;font-weight:700;font-family:inherit;border:1.5px solid #6EE7B7;border-radius:8px;cursor:pointer;display:flex;align-items:center;gap:6px;white-space:nowrap;transition:all 0.2s;}
  .btn-import:hover{background:#059669;color:#fff;border-color:#059669;}
  .btn-tambah{margin-left:auto;padding:10px 20px;background:var(--primary-dark);color:#fff;font-size:13.5px;font-weight:700;font-family:inherit;border:none;border-radius:8px;cursor:pointer;display:flex;align-items:center;gap:8px;box-shadow:0 4px 12px rgba(26,86,219,0.25);transition:background 0.2s,transform 0.15s;white-space:nowrap;}
  .btn-tambah:hover{background:var(--primary);transform:translateY(-1px);}

  /* ── Tabel ── */
  .table-card{background:var(--white);border-radius:12px;border:1px solid var(--border);overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,0.04);margin-bottom:16px;}
  .table-card-header{padding:16px 20px;border-bottom:1px solid #EEF2FF;display:flex;align-items:center;justify-content:space-between;}
  .table-card-title{font-size:14px;font-weight:700;color:var(--text-main);display:flex;align-items:center;gap:8px;}
  .table-card-title::before{content:'';width:3px;height:14px;background:var(--primary);border-radius:99px;display:inline-block;}
  .table-badge{font-size:11.5px;font-weight:600;background:var(--bg);color:var(--primary-dark);padding:3px 10px;border-radius:20px;border:1px solid var(--border);}
  table{width:100%;border-collapse:collapse;}
  thead tr{background:var(--header-bg);}
  thead th{padding:12px 14px;text-align:left;font-size:11px;font-weight:600;color:rgba(255,255,255,0.85);letter-spacing:0.05em;text-transform:uppercase;white-space:nowrap;}
  tbody tr{border-bottom:1px solid #EEF2FF;transition:background 0.15s;}
  tbody tr:last-child{border-bottom:none;}
  tbody tr:hover{background:#F5F8FF;}
  tbody tr.row-warning{background:#FFFDF0;}
  tbody tr.row-warning:hover{background:#FFF9E0;}
  tbody td{padding:11px 14px;font-size:13px;color:var(--text-main);vertical-align:middle;}
  .stok-wrap{display:flex;flex-direction:column;gap:4px;}
  .stok-num{font-size:13px;font-weight:700;}
  .stok-bar-bg{width:70px;height:5px;background:#E5E7EB;border-radius:99px;overflow:hidden;}
  .stok-bar{height:100%;border-radius:99px;}
  .stok-bar.ok{background:var(--success);}
  .stok-bar.warn{background:var(--warning);}
  .stok-bar.danger{background:var(--danger);}
  .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600;}
  .badge-success{background:var(--success-light);color:var(--success);}
  .badge-warning{background:var(--warning-light);color:var(--warning);}
  .badge-danger{background:var(--danger-light);color:var(--danger);}
  .aksi-wrap{display:flex;gap:6px;}
  .btn-edit{padding:5px 10px;background:var(--bg);color:var(--primary-dark);border:1.5px solid var(--border);border-radius:6px;font-size:11.5px;font-weight:600;font-family:inherit;cursor:pointer;transition:all 0.2s;white-space:nowrap;}
  .btn-edit:hover{background:var(--primary-dark);color:#fff;border-color:var(--primary-dark);}
  .btn-hapus-row{padding:5px 10px;background:var(--danger-light);color:var(--danger);border:1.5px solid #FECACA;border-radius:6px;font-size:11.5px;font-weight:600;font-family:inherit;cursor:pointer;transition:all 0.2s;white-space:nowrap;}
  .btn-hapus-row:hover{background:var(--danger);color:#fff;border-color:var(--danger);}

  /* ── Modal ── */
  .modal-overlay{position:fixed;inset:0;background:rgba(15,25,60,0.45);backdrop-filter:blur(3px);z-index:200;display:none;align-items:center;justify-content:center;padding:20px;}
  .modal-overlay.show{display:flex;animation:fadeIn 0.2s ease;}
  @keyframes fadeIn{from{opacity:0}to{opacity:1}}
  .modal{background:var(--white);border-radius:16px;width:580px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,0.2);animation:slideUp 0.25s ease;}
  @keyframes slideUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
  .modal-header{background:var(--header-bg);padding:18px 24px;display:flex;align-items:center;justify-content:space-between;}
  .modal-header-left{display:flex;align-items:center;gap:12px;}
  .modal-header-icon{width:34px;height:34px;background:rgba(255,255,255,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;}
  .modal-header-title{font-size:15px;font-weight:700;color:#fff;}
  .modal-close{padding:0 12px;height:34px;background:rgba(255,255,255,0.1);border:none;border-radius:8px;color:rgba(255,255,255,0.8);font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;transition:background 0.2s;}
  .modal-close:hover{background:rgba(255,255,255,0.2);}
  .modal-body{padding:24px;}
  .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px 20px;margin-bottom:20px;}
  .form-group{display:flex;flex-direction:column;gap:6px;}
  .form-group label{font-size:12px;font-weight:600;color:var(--text-main);text-transform:uppercase;letter-spacing:0.05em;}
  .label-req{color:var(--primary);}
  .form-group input{padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;font-size:13.5px;font-family:inherit;color:var(--text-main);background:#F8FAFF;outline:none;transition:border-color 0.2s;}
  .form-group input:focus{border-color:var(--primary);background:var(--white);box-shadow:0 0 0 3px rgba(26,86,219,0.10);}
  .form-hint{font-size:11px;color:var(--text-sub);}
  .harga-group{position:relative;}
  .harga-group input{padding-left:38px;}
  .harga-prefix{position:absolute;left:0;top:0;bottom:0;width:34px;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:var(--text-sub);border-right:1.5px solid var(--border);background:#F0F4FF;border-radius:8px 0 0 8px;pointer-events:none;}
  .divider{height:1px;background:#EEF2FF;margin-bottom:20px;}
  .modal-action{display:flex;gap:10px;}
  .btn-simpan{flex:1;padding:11px;background:var(--primary-dark);color:#fff;font-size:14px;font-weight:700;font-family:inherit;border:none;border-radius:8px;cursor:pointer;transition:background 0.2s;}
  .btn-simpan:hover{background:var(--primary);}
  .btn-batal{flex:1;padding:11px;background:var(--white);color:var(--text-main);font-size:14px;font-weight:600;font-family:inherit;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;}
  .modal-hapus{background:var(--white);border-radius:16px;width:400px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,0.2);animation:slideUp 0.25s ease;}
  .modal-hapus-header{background:var(--danger);padding:18px 24px;display:flex;align-items:center;gap:12px;}
  .modal-hapus-body{padding:24px;}
  .modal-hapus-body p{font-size:13.5px;color:var(--text-sub);line-height:1.7;margin-bottom:8px;}
  .item-name{font-size:14px;font-weight:700;color:var(--text-main);background:var(--danger-light);padding:10px 14px;border-radius:8px;border:1px solid #FECACA;margin-bottom:16px;}
  .modal-hapus-footer{display:flex;gap:10px;padding:0 24px 24px;}
  .btn-hapus-confirm{flex:1;padding:11px;background:var(--danger);color:#fff;font-size:14px;font-weight:700;font-family:inherit;border:none;border-radius:8px;cursor:pointer;}
  .btn-hapus-cancel{flex:1;padding:11px;background:var(--white);color:var(--text-main);font-size:14px;font-weight:600;font-family:inherit;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;}

  /* ── Modal Import ── */
  .modal-import{background:var(--white);border-radius:16px;width:560px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,0.2);animation:slideUp 0.25s ease;}
  .modal-import-header{background:#065F46;padding:18px 24px;display:flex;align-items:center;justify-content:space-between;}
  .modal-import-title{font-size:15px;font-weight:700;color:#fff;display:flex;align-items:center;gap:10px;}
  .drop-zone{border:2px dashed #6EE7B7;border-radius:12px;padding:32px 20px;text-align:center;background:#F0FDF4;cursor:pointer;margin-bottom:16px;transition:all 0.2s;}
  .drop-zone.drag-over{border-color:#059669;background:#DCFCE7;}
  .drop-zone-icon{font-size:36px;margin-bottom:10px;}
  .drop-zone-title{font-size:14px;font-weight:700;color:#065F46;margin-bottom:4px;}
  .drop-zone-sub{font-size:12px;color:#6B7280;}
  .drop-zone-sub strong{color:#059669;cursor:pointer;text-decoration:underline;}
  .import-preview{display:none;margin-bottom:16px;}
  .import-preview-title{font-size:13px;font-weight:700;color:var(--text-main);margin-bottom:8px;}
  .import-preview-wrap{max-height:200px;overflow-y:auto;border:1px solid var(--border);border-radius:8px;}
  .import-status{font-size:12.5px;font-weight:600;margin-bottom:12px;padding:10px 14px;border-radius:8px;display:none;}
  .import-status.ok{background:var(--success-light);color:var(--success);}
  .import-status.err{background:var(--danger-light);color:var(--danger);}
  .template-hint{background:#EFF6FF;border:1px solid #BFDBFE;border-radius:8px;padding:12px 16px;margin-bottom:16px;font-size:12.5px;color:var(--primary-dark);display:flex;align-items:center;gap:10px;}
  .btn-template{padding:5px 14px;background:var(--primary-dark);color:#fff;font-size:12px;font-weight:700;font-family:inherit;border:none;border-radius:6px;cursor:pointer;}
  .modal-import-footer{display:flex;gap:10px;padding:0 24px 24px;}
  .btn-import-confirm{flex:1;padding:11px;background:#059669;color:#fff;font-size:14px;font-weight:700;font-family:inherit;border:none;border-radius:8px;cursor:pointer;}
  .btn-import-confirm:disabled{background:#9CA3AF;cursor:not-allowed;}
  .btn-import-cancel{flex:1;padding:11px;background:var(--white);color:var(--text-main);font-size:14px;font-weight:600;font-family:inherit;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;}

  /* ── Toast ── */
  .toast-box{position:fixed;bottom:28px;right:28px;z-index:9999;}
  .toast{padding:13px 20px;border-radius:10px;font-size:13px;font-weight:700;color:#fff;box-shadow:0 4px 16px rgba(0,0,0,0.15);margin-top:8px;animation:toastIn 0.3s ease;}
  @keyframes toastIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}

  /* ── Tablet ── */
  @media(max-width:900px){
    .top-row{flex-wrap:wrap;}
    .search-wrap{max-width:100%;flex:1 1 200px;}
    .btn-tambah{margin-left:0;}
  }

  /* ── Mobile ── */
  @media(max-width:640px){
    .page-title{font-size:18px;margin-bottom:14px;}
    .alert-box{padding:12px 14px;}
    .alert-items{gap:6px;}
    .alert-item-chip{font-size:11px;padding:3px 10px;}
    .top-row{display:block;margin-bottom:14px;}
    .top-row>*{display:block;width:100%;margin-bottom:8px;box-sizing:border-box;}
    .top-row>*:last-child{margin-bottom:0;}
    .search-wrap{position:relative;max-width:100%;}
    .search-input{width:100%;}
    .btn-cari,.btn-import,.btn-tambah{width:100%;justify-content:center;margin-left:0;}
    .table-card{overflow-x:auto;}
    table{min-width:560px;}
    .table-card-header{padding:12px 14px;flex-wrap:wrap;gap:6px;}
    thead th{padding:10px;font-size:10px;}
    tbody td{padding:10px;font-size:12px;}
    .stok-bar-bg{width:50px;}
    .aksi-wrap{flex-direction:column;gap:4px;}
    .btn-edit,.btn-hapus-row{width:100%;text-align:center;justify-content:center;}
    .modal,.modal-hapus,.modal-import{width:calc(100vw - 24px);}
    .modal-body{padding:16px;}
    .form-grid{grid-template-columns:1fr;}
    .modal-action,.modal-hapus-footer,.modal-import-footer{flex-direction:column;}
    .btn-simpan,.btn-batal,.btn-hapus-confirm,.btn-hapus-cancel,.btn-import-confirm,.btn-import-cancel{width:100%;}
    .drop-zone{padding:24px 16px;}
    .toast-box{bottom:16px;right:12px;left:12px;}
    .toast{font-size:12.5px;}
  }
@endsection

@section('content')
<div class="toast-box" id="toastBox"></div>
<div class="page-title">Manajemen Inventaris</div>

{{-- Peringatan Stok Menipis --}}
@if(is_object($stokMenipis) && $stokMenipis->count() > 0)
<div class="alert-box">
  <div class="alert-header" onclick="toggleAlert()" id="alertHeader">
    <div class="alert-header-left">
      <div>
        <div class="alert-title">Peringatan Stok Menipis</div>
        <div class="alert-subtitle">{{ $stokMenipis->count() }} barang memiliki stok di bawah batas minimum</div>
      </div>
    </div>
    <div class="alert-toggle" id="alertToggle">
      <i class="arrow">▼</i> <span id="alertToggleLabel">Lihat</span>
    </div>
  </div>
  <div class="alert-body" id="alertBody">
    <div class="alert-items">
      @foreach($stokMenipis as $b)
        <div class="alert-item-chip">
          {{ $b->nama_barang }}
          <span class="stok-num">{{ $b->stok }}</span>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endif

{{-- Pencarian dan Tindakan --}}
<div class="top-row">
  <div class="search-wrap">
    <input class="search-input" type="text" id="searchInput" placeholder="Nama barang / Kode barang" oninput="filterTabel(this.value)" />
  </div>
  <button class="btn-cari" onclick="filterTabel(document.getElementById('searchInput').value)">Cari</button>
  <button class="btn-import" onclick="openImport()">Import CSV</button>
  <button class="btn-tambah" onclick="openTambah()">Tambah Barang</button>
</div>

{{-- Tabel Inventaris --}}
<div class="table-card">
  <div class="table-card-header">
    <div class="table-card-title">Daftar Inventaris Barang</div>
    <span class="table-badge" id="tabelBadge">{{ $barang->count() }} barang</span>
  </div>
  <table id="tabelBarang">
    <thead>
      <tr>
        <th>No</th><th>Kode Barang</th><th>Nama Barang</th>
        <th>Harga Beli</th><th>Harga Eceran</th><th>Harga Grosir</th>
        <th>Stok</th><th>Min</th><th>Status</th><th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($barang as $i => $b)
        @php
          $pct = $b->stok <= 0 ? 0 : min(100, round(($b->stok / ($b->min_stok * 4)) * 100));
          $bar = $b->stok < $b->min_stok ? 'danger' : ($b->stok < $b->min_stok*2 ? 'warn' : 'ok');
        @endphp
        <tr class="{{ $b->stok < $b->min_stok ? 'row-warning' : '' }}" data-no="{{ $i }}" data-nama="{{ strtolower($b->nama_barang) }}" data-kode="{{ strtolower($b->kode_barang) }}">
          <td>{{ $i+1 }}</td>
          <td>{{ $b->kode_barang }}</td>
          <td>{{ $b->nama_barang }}</td>
          <td>Rp {{ number_format($b->harga_beli,0,',','.') }}</td>
          <td>Rp {{ number_format($b->harga_eceran,0,',','.') }}</td>
          <td>Rp {{ number_format($b->harga_grosir,0,',','.') }}</td>
          <td>
            <div class="stok-wrap">
              <span class="stok-num">{{ $b->stok }}</span>
              <div class="stok-bar-bg"><div class="stok-bar {{ $bar }}" style="width:{{ $pct }}%"></div></div>
            </div>
          </td>
          <td>{{ $b->min_stok }}</td>
          <td>
            @if($b->stok <= 0)
              <span class="badge badge-danger">Habis</span>
            @elseif($b->stok < $b->min_stok)
              <span class="badge badge-danger">Menipis</span>
            @elseif($b->stok < $b->min_stok*2)
              <span class="badge badge-warning">Cukup</span>
            @else
              <span class="badge badge-success">Aman</span>
            @endif
          </td>
          <td>
            <div class="aksi-wrap">
              <button class="btn-edit" onclick="openEdit({{ $b->id }},'{{ $b->kode_barang }}','{{ addslashes($b->nama_barang) }}',{{ $b->harga_beli }},{{ $b->harga_eceran }},{{ $b->harga_grosir }},{{ $b->stok }},{{ $b->min_stok }})">Edit</button>
              <button class="btn-hapus-row" onclick="openHapus({{ $b->id }},'{{ addslashes($b->nama_barang) }}')">Hapus</button>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="10" style="padding:32px;text-align:center;color:var(--text-sub);">Belum ada data barang.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Modal Tambah/Edit --}}
<div class="modal-overlay" id="modalForm">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-header-left">
        <div class="modal-header-title" id="modalFormTitle">Tambah Barang</div>
      </div>
      <button class="modal-close" onclick="closeModal('modalForm')">Tutup</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group">
          <label>Kode Barang <span class="label-req">*</span></label>
          <input type="text" id="fKode" placeholder="Contoh: BRG-009" />
        </div>
        <div class="form-group">
          <label>Nama Barang <span class="label-req">*</span></label>
          <input type="text" id="fNama" placeholder="Nama barang" />
        </div>
        <div class="form-group">
          <label>Harga Beli <span class="label-req">*</span></label>
          <div class="harga-group"><span class="harga-prefix">Rp</span><input type="number" id="fHargaBeli" placeholder="0" min="0" /></div>
        </div>
        <div class="form-group">
          <label>Harga Eceran <span class="label-req">*</span></label>
          <div class="harga-group"><span class="harga-prefix">Rp</span><input type="number" id="fHargaEceran" placeholder="0" min="0" /></div>
        </div>
        <div class="form-group">
          <label>Harga Grosir <span class="label-req">*</span></label>
          <div class="harga-group"><span class="harga-prefix">Rp</span><input type="number" id="fHargaGrosir" placeholder="0" min="0" /></div>
          <span class="form-hint">Harga untuk pembelian partai besar</span>
        </div>
        <div class="form-group">
          <label>Stok <span class="label-req">*</span></label>
          <input type="number" id="fStok" placeholder="0" min="0" />
        </div>
        <div class="form-group">
          <label>Minimum Stok <span class="label-req">*</span></label>
          <input type="number" id="fMinStok" placeholder="5" min="0" />
          <span class="form-hint">Notifikasi jika stok di bawah nilai ini</span>
        </div>
      </div>
      <div class="divider"></div>
      <div class="modal-action">
        <button class="btn-batal" onclick="closeModal('modalForm')">Batal</button>
        <button class="btn-simpan" onclick="simpanBarang()">Simpan</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal Hapus --}}
<div class="modal-overlay" id="modalHapus">
  <div class="modal-hapus">
    <div class="modal-hapus-header">
      <div class="modal-header-title" style="color:#fff;font-size:15px;font-weight:700;">Hapus Barang</div>
    </div>
    <div class="modal-hapus-body">
      <p>Apakah kamu yakin ingin menghapus barang ini? Tindakan ini tidak dapat dibatalkan.</p>
      <div class="item-name" id="hapusItemName">—</div>
    </div>
    <div class="modal-hapus-footer">
      <button class="btn-hapus-cancel" onclick="closeModal('modalHapus')">Batal</button>
      <button class="btn-hapus-confirm" onclick="konfirmasiHapus()">Ya, Hapus</button>
    </div>
  </div>
</div>

{{-- Modal Import CSV --}}
<div class="modal-overlay" id="modalImport">
  <div class="modal-import">
    <div class="modal-import-header">
      <div class="modal-import-title">Import Data Barang (CSV)</div>
      <button class="modal-close" onclick="closeModal('modalImport')">Tutup</button>
    </div>
    <div class="modal-body">
      <div class="template-hint">
        Gunakan template CSV agar format sesuai.
        <button class="btn-template" onclick="downloadTemplate()">Download Template</button>
      </div>
      <div class="drop-zone" id="dropZone" onclick="document.getElementById('fileInput').click()"
        ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">
        <div class="drop-zone-icon"></div>
        <div class="drop-zone-title">Drag & Drop file CSV di sini</div>
        <div class="drop-zone-sub">atau <strong>klik untuk pilih file</strong></div>
      </div>
      <input type="file" id="fileInput" accept=".csv" onchange="handleFile(this.files[0])" style="display:none" />
      <div class="import-status" id="importStatus"></div>
      <div class="import-preview" id="importPreview">
        <div class="import-preview-title">Preview — <span id="previewCount">0</span> baris</div>
        <div class="import-preview-wrap">
          <table>
            <thead><tr>
              <th>Kode</th><th>Nama</th><th>H.Beli</th><th>H.Eceran</th><th>H.Grosir</th><th>Stok</th><th>Min</th>
            </tr></thead>
            <tbody id="previewBody"></tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="modal-import-footer">
      <button class="btn-import-cancel" onclick="closeModal('modalImport')">Batal</button>
      <button class="btn-import-confirm" id="btnImportConfirm" disabled onclick="konfirmasiImport()">Import Sekarang</button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
let editId = null, hapusId = null, parsedRows = [];

// ── Utility ──
function showToast(msg, color='#057A55') {
  const c = document.getElementById('toastBox');
  const t = document.createElement('div');
  t.className='toast'; t.style.background=color; t.innerHTML=msg;
  c.appendChild(t); setTimeout(()=>t.remove(),3500);
}

// ── Fungsi Utama ──
function filterTabel(q) {
  const keyword = q.toLowerCase().trim();
  const tbody   = document.querySelector('#tabelBarang tbody');
  const rows    = Array.from(tbody.querySelectorAll('tr[data-nama]'));

  if (!keyword) {
    // Kembalikan urutan asli (urutan dari server)
    rows.sort((a, b) => parseInt(a.dataset.no) - parseInt(b.dataset.no));
    rows.forEach(r => { r.style.display = ''; tbody.appendChild(r); });
    const emptyRow = tbody.querySelector('.empty-placeholder');
    if (emptyRow) emptyRow.style.display = 'none';
    document.getElementById('tabelBadge').textContent = rows.length + ' barang';
    return;
  }

  const cocok = rows.filter(r => {
    const nama = r.dataset.nama || '';
    const kode = r.dataset.kode || '';
    return nama.includes(keyword) || kode.includes(keyword);
  });

  const tidakCocok = rows.filter(r => {
    const nama = r.dataset.nama || '';
    const kode = r.dataset.kode || '';
    return !nama.includes(keyword) && !kode.includes(keyword);
  });

  // Sort: yang diawali keyword naik ke atas
  cocok.sort((a, b) => {
    const namaA = a.dataset.nama || '';
    const namaB = b.dataset.nama || '';
    const aAwalan = namaA.startsWith(keyword);
    const bAwalan = namaB.startsWith(keyword);
    if (aAwalan && !bAwalan) return -1;
    if (!aAwalan && bAwalan) return 1;
    return namaA.localeCompare(namaB, 'id');
  });

  // Render ulang: cocok dulu (terurut), lalu yang tidak cocok di-hide
  cocok.forEach(r => { r.style.display = ''; tbody.appendChild(r); });
  tidakCocok.forEach(r => { r.style.display = 'none'; });

  document.getElementById('tabelBadge').textContent = cocok.length + ' barang';
}

// ── Fungsi untuk toggle alert stok menipis ──
function toggleAlert() {
  const body  = document.getElementById('alertBody');
  const label = document.getElementById('alertToggleLabel');
  const arrow = document.querySelector('#alertToggle .arrow');
  const isOpen = body.classList.contains('open');
  body.classList.toggle('open');
  arrow.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
  label.textContent = isOpen ? 'Lihat' : 'Tutup';
}

// ── Fungsi untuk membuka modal tambah barang ──
function openTambah() {
  editId=null;
  document.getElementById('modalFormTitle').textContent='Tambah Barang';
  ['fKode','fNama','fHargaBeli','fHargaEceran','fHargaGrosir','fStok','fMinStok'].forEach(id=>document.getElementById(id).value='');
  document.getElementById('fKode').readOnly=false;
  document.getElementById('fKode').style.cssText='';
  document.getElementById('modalForm').classList.add('show');
}

// ── Fungsi untuk membuka modal edit barang dengan data terisi ──
function openEdit(id,kode,nama,hBeli,hEcer,hGros,stok,minStok) {
  editId=id;
  document.getElementById('modalFormTitle').textContent='Edit Barang';
  document.getElementById('fKode').value=kode;
  document.getElementById('fNama').value=nama;
  document.getElementById('fHargaBeli').value=hBeli;
  document.getElementById('fHargaEceran').value=hEcer;
  document.getElementById('fHargaGrosir').value=hGros;
  document.getElementById('fStok').value=stok;
  document.getElementById('fMinStok').value=minStok;
  document.getElementById('modalForm').classList.add('show');
}

// ── Fungsi untuk membuka modal konfirmasi hapus dengan nama barang yang akan dihapus ──
function openHapus(id,nama) {
  hapusId=id;
  document.getElementById('hapusItemName').textContent=nama;
  document.getElementById('modalHapus').classList.add('show');
}

// ── Fungsi untuk menutup modal dengan id tertentu ──
function closeModal(id) { document.getElementById(id).classList.remove('show'); }

// ── Fungsi untuk menyimpan data barang ──
function simpanBarang() {
  const kode=document.getElementById('fKode').value.trim();
  const nama=document.getElementById('fNama').value.trim();
  const hBeli=document.getElementById('fHargaBeli').value;
  const hEcer=document.getElementById('fHargaEceran').value;
  const hGros=document.getElementById('fHargaGrosir').value;
  const stok=document.getElementById('fStok').value;
  const minStok=document.getElementById('fMinStok').value;
  if(!nama||!hBeli||!hEcer||!hGros){showToast('Semua field wajib diisi!','#C27803');return;}
  const url=editId?`/barang/${editId}`:'/barang';
  const body={kode_barang:kode,nama_barang:nama,harga_beli:hBeli,harga_eceran:hEcer,harga_grosir:hGros,stok,min_stok:minStok,_token:CSRF};
  if(editId) body._method='PUT';
  fetch(url,{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},body:JSON.stringify(body)})
    .then(r=>r.json()).then(data=>{
      if(data.success){closeModal('modalForm');showToast(data.message);setTimeout(()=>location.reload(),1000);}
      else showToast(data.message||'Error','#DC2626');
    });
}

// ── Fungsi untuk mengkonfirmasi penghapusan barang ──
function konfirmasiHapus() {
  fetch(`/barang/${hapusId}`,{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},body:JSON.stringify({_method:'DELETE',_token:CSRF})})
    .then(r=>r.json()).then(data=>{
      if(data.success){closeModal('modalHapus');showToast(data.message);setTimeout(()=>location.reload(),1000);}
    });
}

// ── Fungsi untuk membuka modal import dan mereset state terkait ──
function openImport() {
  document.getElementById('dropZone').classList.remove('drag-over');
  document.getElementById('importPreview').style.display='none';
  document.getElementById('importStatus').style.display='none';
  document.getElementById('btnImportConfirm').disabled=true;
  document.getElementById('fileInput').value='';
  parsedRows=[];
  document.getElementById('modalImport').classList.add('show');
}
function handleDragOver(e){e.preventDefault();document.getElementById('dropZone').classList.add('drag-over');}
function handleDragLeave(){document.getElementById('dropZone').classList.remove('drag-over');}
function handleDrop(e){e.preventDefault();document.getElementById('dropZone').classList.remove('drag-over');if(e.dataTransfer.files[0])handleFile(e.dataTransfer.files[0]);}

// ── Fungsi untuk mem-parse satu baris CSV (handle quoted fields dengan benar) ──
function parseCSVLine(line) {
  const cols = [];
  let cur = '', inQuote = false;
  for (let i = 0; i < line.length; i++) {
    const ch = line[i];
    if (ch === '"') {
      if (inQuote && line[i+1] === '"') { cur += '"'; i++; }
      else inQuote = !inQuote;
    } else if (ch === ',' && !inQuote) {
      cols.push(cur.trim()); cur = '';
    } else {
      cur += ch;
    }
  }
  cols.push(cur.trim());
  return cols;
}

// ── Fungsi untuk memproses file CSV yang diupload ──
function handleFile(file) {
  if (!file) return;
  const sEl = document.getElementById('importStatus'), pEl = document.getElementById('importPreview');
  if (!file.name.endsWith('.csv')) {
    sEl.textContent = 'File harus berformat .csv';
    sEl.className = 'import-status err'; sEl.style.display = 'block'; return;
  }
  const reader = new FileReader();
  reader.onload = function(e) {
    const lines = e.target.result.trim().split(/\r?\n/).map(l => l.trim()).filter(Boolean);
    const dl = lines[0].toLowerCase().includes('kode') ? lines.slice(1) : lines;
    parsedRows = []; const errors = [];
    dl.forEach((line, i) => {
      const cols = parseCSVLine(line);
      if (cols.length < 7) { errors.push('Baris ' + (i+1) + ': kolom kurang (' + cols.length + ')'); return; }
      const [kode, nama, hB, hE, hG, stok, min] = cols;
      if (!nama) { errors.push('Baris ' + (i+1) + ': nama kosong'); return; }
      parsedRows.push({
        kode: kode || '',
        nama,
        hargaBeli:    parseInt(hB)   || 0,
        hargaEceran:  parseInt(hE)   || 0,
        hargaGrosir:  parseInt(hG)   || 0,
        stok:         parseInt(stok) || 0,
        minStok:      parseInt(min)  || 5,
      });
    });
    sEl.textContent = errors.length ? errors.length + ' baris dilewati' : parsedRows.length + ' barang siap diimport';
    sEl.className = 'import-status ' + (errors.length ? 'err' : 'ok'); sEl.style.display = 'block';
    document.getElementById('previewCount').textContent = parsedRows.length;
    document.getElementById('previewBody').innerHTML = parsedRows.slice(0, 5).map(r =>
      `<tr>${[r.kode, r.nama, r.hargaBeli.toLocaleString('id-ID'), r.hargaEceran.toLocaleString('id-ID'), r.hargaGrosir.toLocaleString('id-ID'), r.stok, r.minStok]
        .map(v => `<td style="padding:8px 12px;font-size:12px;border-bottom:1px solid #EEF2FF;">${v}</td>`).join('')}</tr>`
    ).join('');
    pEl.style.display = parsedRows.length ? 'block' : 'none';
    document.getElementById('btnImportConfirm').disabled = parsedRows.length === 0;
  };
  reader.readAsText(file);
}

// ── Fungsi untuk mengirim data barang yang sudah diparsing ke server untuk diimport ke database ──
async function konfirmasiImport() {
  if (!parsedRows.length) return;

  const btn = document.getElementById('btnImportConfirm');
  const batalBtn = document.querySelector('.btn-batal-import') || document.querySelector('[onclick="closeModal(\'modalImport\')"]');
  btn.disabled = true;
  btn.textContent = 'Mengimport...';
  if (batalBtn) batalBtn.disabled = true;

  const BATCH = 100; // kirim 100 baris per request
  let totalAdded = 0, totalUpdated = 0, totalErrors = [];

  const escape = v => {
    const s = String(v);
    return (s.includes(',') || s.includes('"') || s.includes('\n')) ? `"${s.replace(/"/g,'""')}"` : s;
  };

  for (let start = 0; start < parsedRows.length; start += BATCH) {
    const chunk = parsedRows.slice(start, start + BATCH);
    const csv = [
      'kode_barang,nama_barang,harga_beli,harga_eceran,harga_grosir,stok,min_stok',
      ...chunk.map(r => `${escape(r.kode)},${escape(r.nama)},${r.hargaBeli},${r.hargaEceran},${r.hargaGrosir},${r.stok},${r.minStok}`)
    ].join('\n');

    const form = new FormData();
    form.append('_token', CSRF);
    form.append('file', new Blob([csv], {type: 'text/csv'}), 'import.csv');

    try {
      const res  = await fetch('/barang/import', {method: 'POST', body: form});
      const data = await res.json();
      if (data.added)   totalAdded   += data.added;
      if (data.updated) totalUpdated += data.updated;
      if (data.errors)  totalErrors   = totalErrors.concat(data.errors);
    } catch (err) {
      console.error('Batch error di baris', start, err);
    }

    // update teks tombol supaya keliatan progress
    const done = Math.min(start + BATCH, parsedRows.length);
    btn.textContent = `Mengimport... (${done}/${parsedRows.length})`;
  }

  closeModal('modalImport');
  showToast(`Import selesai: ${totalAdded} ditambahkan, ${totalUpdated} diperbarui.`);
  setTimeout(() => location.reload(), 1500);
}

// ── Fungsi untuk mengunduh template import barang ──
function downloadTemplate() {
  const csv='kode_barang,nama_barang,harga_beli,harga_eceran,harga_grosir,stok,min_stok\nBRG-010,Oli Mesin Federal,35000,45000,38000,20,5\nBRG-011,Kampas Kopling Honda,55000,70000,60000,10,3';
  const a=document.createElement('a');a.href=URL.createObjectURL(new Blob([csv],{type:'text/csv'}));a.download='template_barang.csv';a.click();
}

// ── Menambahkan event listener untuk menutup modal saat mengklik di luar area modal ── 
document.querySelectorAll('.modal-overlay').forEach(el=>{
  el.addEventListener('click',function(e){if(e.target===this)this.classList.remove('show');});
});
</script>
@endsection