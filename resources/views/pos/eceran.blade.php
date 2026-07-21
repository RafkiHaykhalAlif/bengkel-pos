@extends('layouts.app')
@section('title', 'POS Eceran')
@section('head')
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
@endsection
@section('styles')
  .page-title{font-size:22px;font-weight:800;color:var(--text-main);margin-bottom:20px;}
  .section-label{font-size:13.5px;font-weight:700;color:var(--text-main);margin-bottom:10px;display:flex;align-items:center;gap:8px;}
  .section-label::before{content:'';width:3px;height:14px;background:var(--primary);border-radius:99px;}
  .jenis-row{display:flex;gap:12px;margin-bottom:20px;}
  .jenis-option{flex:1;display:flex;align-items:center;gap:12px;padding:14px 18px;background:var(--white);border:2px solid var(--border);border-radius:10px;cursor:pointer;transition:all 0.2s;max-width:240px;}
  .jenis-option:has(input:checked){border-color:var(--primary);background:#EBF2FF;}
  .jenis-option input[type="radio"]{display:none;}
  .jenis-title{font-size:13.5px;font-weight:700;color:var(--text-main);}
  .jenis-desc{font-size:11.5px;color:var(--text-sub);margin-top:2px;}
  .jenis-option:has(input:checked) .jenis-title{color:var(--primary-dark);}
  .biaya-jasa-wrap{background:#FFFBEB;border:1.5px solid #FCD34D;border-radius:10px;padding:16px 20px;margin-bottom:20px;display:none;animation:fadeSlide 0.25s ease;}
  .biaya-jasa-wrap.show{display:block;}
  @keyframes fadeSlide{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}
  .biaya-jasa-header{display:flex;align-items:center;gap:8px;margin-bottom:12px;}
  .biaya-jasa-header span{font-size:13px;font-weight:700;color:#92400E;}
  .biaya-jasa-row{display:flex;flex-direction:column;gap:8px;}
  .jasa-item-row{display:grid;grid-template-columns:1fr 160px auto;gap:8px;align-items:center;}
  .jasa-item-row input{padding:8px 12px;border:1.5px solid #FCD34D;border-radius:8px;font-size:13px;font-family:inherit;background:#fff;outline:none;}
  .jasa-item-row input:focus{border-color:#D97706;box-shadow:0 0 0 3px rgba(217,119,6,0.1);}
  .btn-hapus-jasa{padding:6px 10px;background:#FEF2F2;color:#DC2626;border:1.5px solid #FECACA;border-radius:6px;cursor:pointer;font-size:13px;}
  .btn-hapus-jasa:hover{background:#DC2626;color:#fff;}
  .btn-tambah-jasa{padding:7px 14px;background:#FCD34D;color:#78350F;border:none;border-radius:7px;font-size:12.5px;font-weight:700;font-family:inherit;cursor:pointer;margin-top:4px;display:inline-flex;align-items:center;}
  .btn-tambah-jasa:hover{background:#F59E0B;}
  .biaya-group{display:flex;flex-direction:column;gap:5px;}
  .biaya-group label{font-size:11.5px;font-weight:600;color:#92400E;text-transform:uppercase;letter-spacing:0.05em;}
  .biaya-group input{padding:10px 14px;border:1.5px solid #FCD34D;border-radius:8px;font-size:13.5px;font-family:inherit;color:var(--text-main);background:var(--white);outline:none;}
  .biaya-group input:focus{border-color:var(--warning);box-shadow:0 0 0 3px rgba(194,120,3,0.12);}
  .input-row{display:grid;grid-template-columns:1.4fr 1.4fr 0.5fr auto;gap:10px;margin-bottom:20px;align-items:flex-end;}
  .input-group{display:flex;flex-direction:column;gap:5px;}
  .input-group label{font-size:11.5px;font-weight:600;color:var(--text-sub);text-transform:uppercase;letter-spacing:0.05em;}
  .input-field{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;font-size:13.5px;font-family:inherit;color:var(--text-main);background:var(--white);outline:none;transition:border-color 0.2s;}
  .input-field:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(26,86,219,0.10);}
  .autocomplete-wrap{position:relative;}
  .dropdown-list{display:none;position:absolute;top:calc(100% + 4px);left:0;right:0;background:var(--white);border:1.5px solid var(--border);border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.12);z-index:999;overflow:hidden;max-height:220px;overflow-y:auto;}
  .dropdown-list.show{display:block;}
  .dropdown-item{display:flex;align-items:center;justify-content:space-between;padding:10px 14px;cursor:pointer;transition:background 0.15s;border-bottom:1px solid #F3F4F6;}
  .dropdown-item:last-child{border-bottom:none;}
  .dropdown-item:hover,.dropdown-item.focused{background:#EBF2FF;}
  .dropdown-item-left{display:flex;flex-direction:column;gap:2px;}
  .dropdown-item-nama{font-size:13px;font-weight:600;color:var(--text-main);}
  .dropdown-item-kode{font-size:11px;color:var(--text-sub);}
  .dropdown-item-harga{font-size:12.5px;font-weight:700;color:var(--primary-dark);}
  .btn-tambah-item{padding:10px 18px;background:var(--success);color:#fff;font-size:13px;font-weight:700;font-family:inherit;border:none;border-radius:8px;cursor:pointer;display:flex;align-items:center;gap:6px;box-shadow:0 4px 10px rgba(5,122,85,0.25);transition:background 0.2s;white-space:nowrap;}
  .btn-tambah-item:hover{background:#046c4e;}
  .transaksi-row{display:grid;grid-template-columns:1fr 290px;gap:16px;margin-bottom:20px;align-items:start;}
  .table-wrap{background:var(--white);border-radius:10px;border:1px solid var(--border);overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,0.04);}
  .table-header{padding:13px 18px;border-bottom:1px solid #EEF2FF;display:flex;align-items:center;justify-content:space-between;}
  .table-title{font-size:13.5px;font-weight:700;color:var(--text-main);}
  .table-count{font-size:12px;font-weight:600;background:var(--bg);color:var(--primary-dark);padding:3px 10px;border-radius:20px;border:1px solid var(--border);}
  table{width:100%;border-collapse:collapse;}
  thead tr{background:var(--header-bg);}
  thead th{padding:11px 14px;text-align:left;font-size:11px;font-weight:600;color:rgba(255,255,255,0.85);letter-spacing:0.05em;text-transform:uppercase;}
  thead th.center{text-align:center;}
  tbody tr{border-bottom:1px solid #EEF2FF;transition:background 0.15s;}
  tbody tr:last-child{border-bottom:none;}
  tbody tr:hover{background:#F5F8FF;}
  tbody td{padding:11px 14px;font-size:13.5px;color:var(--text-main);}
  tbody td.center{text-align:center;}
  .empty-row td{text-align:center;color:var(--text-sub);padding:28px;font-size:13px;}
  .qty-control{display:flex;align-items:center;border:1.5px solid var(--border);border-radius:7px;overflow:hidden;width:fit-content;margin:0 auto;}
  .qty-btn{width:28px;height:28px;background:#F3F6FF;border:none;font-size:16px;font-weight:700;color:var(--primary-dark);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background 0.15s;}
  .qty-btn:hover{background:var(--primary-dark);color:#fff;}
  .qty-input{width:36px;height:28px;border:none;border-left:1.5px solid var(--border);border-right:1.5px solid var(--border);text-align:center;font-size:13px;font-weight:700;font-family:inherit;color:var(--text-main);background:var(--white);outline:none;}
  .btn-hapus-item{padding:4px 10px;background:var(--danger-light);color:var(--danger);border:1.5px solid #FECACA;border-radius:6px;font-size:12px;font-weight:600;font-family:inherit;cursor:pointer;transition:all 0.2s;}
  .btn-hapus-item:hover{background:var(--danger);color:#fff;border-color:var(--danger);}
  .ringkasan{background:var(--white);border-radius:10px;border:1px solid var(--border);overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,0.04);}
  .ringkasan-header{background:var(--primary-dark);padding:13px 16px;color:#fff;font-size:13px;font-weight:700;}
  .ringkasan-body{padding:16px;display:flex;flex-direction:column;gap:10px;}
  .ringkasan-row{display:flex;justify-content:space-between;align-items:center;}
  .ringkasan-key{font-size:12px;color:var(--text-sub);font-weight:500;}
  .ringkasan-val{font-size:13px;font-weight:600;color:var(--text-main);}
  .ringkasan-divider{height:1px;background:#EEF2FF;}
  .ringkasan-row.jasa .ringkasan-key{color:var(--warning);font-weight:600;}
  .ringkasan-row.jasa .ringkasan-val{color:var(--warning);}
  .ringkasan-row.jasa{display:none;}
  .ringkasan-row.jasa.show{display:flex;}
  .ringkasan-total{display:flex;justify-content:space-between;align-items:center;}
  .ringkasan-total-key{font-size:13.5px;font-weight:700;color:var(--text-main);}
  .ringkasan-total-val{font-size:17px;font-weight:800;color:var(--primary-dark);}
  .metode-wrap{display:flex;gap:12px;margin-bottom:20px;}
  .metode-option{display:flex;align-items:center;gap:8px;padding:10px 20px;background:var(--white);border:1.5px solid var(--border);border-radius:8px;cursor:pointer;font-size:13.5px;font-weight:600;color:var(--text-main);transition:all 0.2s;}
  .metode-option input[type="radio"]{accent-color:var(--primary);width:15px;height:15px;}
  .metode-option:has(input:checked){border-color:var(--primary);background:#EBF2FF;color:var(--primary-dark);}
  .action-row{display:flex;gap:12px;}
  .btn-simpan{padding:12px 28px;background:var(--primary-dark);color:#fff;font-size:14px;font-weight:700;font-family:inherit;border:none;border-radius:8px;cursor:pointer;display:flex;align-items:center;box-shadow:0 4px 12px rgba(26,86,219,0.28);transition:background 0.2s,transform 0.15s;}
  .btn-simpan:hover{background:var(--primary);transform:translateY(-1px);}
  .btn-batal{padding:12px 28px;background:var(--white);color:var(--text-main);font-size:14px;font-weight:600;font-family:inherit;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;}
  .modal-overlay{position:fixed;inset:0;background:rgba(15,25,60,0.45);backdrop-filter:blur(3px);z-index:200;display:none;align-items:center;justify-content:center;}
  .modal-overlay.show{display:flex;animation:fadeIn 0.2s ease;}
  @keyframes fadeIn{from{opacity:0}to{opacity:1}}
  .modal{background:var(--white);border-radius:16px;width:420px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,0.25);animation:slideUp 0.25s ease;}
  @keyframes slideUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
  .modal-header{background:var(--header-bg);padding:18px 24px;display:flex;align-items:center;gap:12px;}
  .modal-header-title{font-size:15px;font-weight:700;color:#fff;}
  .modal-body{padding:24px;}
  .modal-body p{font-size:13.5px;color:var(--text-sub);line-height:1.7;margin-bottom:16px;}
  .modal-summary{background:#F8FAFF;border:1px solid var(--border);border-radius:10px;padding:14px 16px;margin-bottom:20px;display:flex;flex-direction:column;gap:8px;}
  .modal-summary-row{display:flex;justify-content:space-between;font-size:13px;}
  .modal-summary-row span:first-child{color:var(--text-sub);font-weight:500;}
  .modal-summary-row span:last-child{font-weight:700;color:var(--text-main);}
  .modal-summary-row.total span:last-child{color:var(--primary-dark);font-size:15px;}
  .modal-footer{display:flex;gap:10px;padding:0 24px 24px;}
  .btn-modal-confirm{flex:1;padding:11px;background:var(--primary-dark);color:#fff;font-size:14px;font-weight:700;font-family:inherit;border:none;border-radius:8px;cursor:pointer;transition:background 0.2s;}
  .btn-modal-confirm:hover{background:var(--primary);}
  .btn-modal-cancel{flex:1;padding:11px;background:var(--white);color:var(--text-main);font-size:14px;font-weight:600;font-family:inherit;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;}
  /* Struk */
  .struk-overlay{display:none;position:fixed;inset:0;background:rgba(15,25,60,0.55);backdrop-filter:blur(4px);z-index:300;align-items:center;justify-content:center;padding:24px;}
  .struk-overlay.show{display:flex;}
  .struk-modal-wrap{display:flex;flex-direction:column;align-items:center;animation:strukanim 0.3s ease both;}
  @keyframes strukanim{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
  /* Struk preview: mirip hasil print thermal */
  .struk-wrap{width:240px;background:#fff;border-radius:2px;box-shadow:0 16px 48px rgba(0,0,0,0.22);font-family:'Courier New',Courier,monospace;}
  .struk-top{width:100%;height:10px;background:radial-gradient(circle at 10px -1px,#F0F4FF 10px,transparent 11px);background-size:20px 10px;background-color:#fff;}
  .struk-bottom{width:100%;height:10px;background:radial-gradient(circle at 10px 11px,#F0F4FF 10px,transparent 11px);background-size:20px 10px;background-color:#fff;}
  .struk-body{padding:6px 10px 14px;}
  .struk-header{text-align:center;margin-bottom:8px;padding-bottom:8px;border-bottom:1px dashed #999;}
  .struk-shop-name{font-size:11px;font-weight:bold;color:#000;margin-bottom:2px;letter-spacing:0.5px;}
  .struk-shop-sub{font-size:7.5px;color:#444;margin-bottom:1px;}
  .struk-info{margin-bottom:8px;padding-bottom:8px;border-bottom:1px dashed #999;}
  .struk-info-row{overflow:hidden;font-size:8px;color:#555;margin-bottom:2px;}
  .struk-info-row span:first-child{float:left;}
  .struk-info-row span:last-child{float:right;color:#000;font-weight:bold;}
  .struk-info-row::after{content:'';display:block;clear:both;}
  .struk-items{margin-bottom:8px;padding-bottom:8px;border-bottom:1px dashed #999;}
  .struk-item{margin-bottom:5px;}
  .struk-item-name{font-size:8.5px;font-weight:bold;color:#000;margin-bottom:1px;}
  .struk-item-detail{overflow:hidden;font-size:8px;color:#555;}
  .struk-item-detail span:first-child{float:left;}
  .struk-item-detail span:last-child{float:right;font-weight:bold;color:#000;}
  .struk-item-detail::after{content:'';display:block;clear:both;}
  .struk-total{margin-bottom:8px;}
  .struk-total-row{overflow:hidden;font-size:8px;margin-bottom:2px;color:#555;}
  .struk-total-row span:first-child{float:left;}
  .struk-total-row span:last-child{float:right;color:#000;font-weight:bold;}
  .struk-total-row::after{content:'';display:block;clear:both;}
  .struk-total-main{overflow:hidden;border-top:1.5px solid #000;border-bottom:1.5px solid #000;padding:5px 0;margin-top:4px;}
  .struk-total-main-label{float:left;font-size:10px;font-weight:bold;color:#000;}
  .struk-total-main-value{float:right;font-size:10px;font-weight:bold;color:#000;}
  .struk-total-main::after{content:'';display:block;clear:both;}
  .struk-footer{text-align:center;margin-top:6px;padding-bottom:40px;}
  .struk-footer .simpan-note{font-size:7.5px;color:#555;line-height:1.5;margin-bottom:3px;}
  .struk-footer .terima-kasih{font-size:9px;font-weight:bold;color:#000;margin-bottom:16px;display:block;}
  .struk-action-row{display:flex;gap:10px;margin-top:10px;width:240px;}
  .btn-struk-print{flex:1;padding:11px;background:#1E429F;color:#fff;font-size:13px;font-weight:700;font-family:inherit;border:none;border-radius:8px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;transition:background 0.2s;}
  .btn-struk-print:hover{background:#1A56DB;}
  .btn-struk-close{flex:1;padding:11px;background:#fff;color:#111827;font-size:13px;font-weight:600;font-family:inherit;border:1.5px solid #C7D4F0;border-radius:8px;cursor:pointer;}
  @media print{
    body > *:not(#strukPrintContainer) { display:none !important; }
    #strukPrintContainer { display:block !important; font-family:Arial,Helvetica,sans-serif; font-size:9pt; color:#000; padding-bottom:8px; width:52mm; }
    @page { margin:4mm 3mm 6mm; }
  }

  /* ── Tablet (≤900px) ── */
  @media(max-width:900px){
    .transaksi-row{grid-template-columns:1fr;}
    .input-row{grid-template-columns:1fr 1fr;}
    .ringkasan{margin-top:0;}
  }

  /* ── Mobile (≤640px) ── */
  @media(max-width:640px){
    .page-title{font-size:18px;margin-bottom:14px;}
    .jenis-row{flex-direction:column;gap:8px;}
    .jenis-option{max-width:100%;}
    .input-row{grid-template-columns:1fr;gap:8px;margin-bottom:14px;}
    .btn-tambah-item{width:100%;justify-content:center;}
    .transaksi-row{grid-template-columns:1fr;gap:12px;}
    .table-wrap{overflow-x:auto;}
    table{min-width:480px;}
    .metode-wrap{flex-wrap:wrap;gap:8px;}
    .metode-option{flex:1;min-width:120px;padding:10px 12px;font-size:13px;}
    .action-row{flex-direction:column;}
    .btn-simpan,.btn-batal{width:100%;justify-content:center;}
    .modal{width:calc(100vw - 32px);margin:0 16px;}
    .struk-action-row{width:calc(100vw - 48px);max-width:320px;}
    .struk-wrap{width:calc(100vw - 64px);max-width:280px;}
    .ringkasan-total-val{font-size:15px;}
    .biaya-jasa-row{gap:6px;}
    .jasa-item-row{grid-template-columns:1fr auto;}
    .jasa-item-row input:first-child{grid-column:1/-1;}
  }
@endsection

@section('content')
<div id="strukPrintContainer" style="display:none;"></div>

{{-- Pencatatan Transaksi Eceran --}}
<div class="page-title">Pencatatan Transaksi (POS Eceran)</div>
<div class="section-label">Jenis Transaksi</div>
<div class="jenis-row">
  <label class="jenis-option">
    <input type="radio" name="jenis" value="eceran" checked onchange="toggleJenis(this)" />
    <div>
      <div class="jenis-title">Pembelian Sparepart</div>
      <div class="jenis-desc">Penjualan suku cadang saja</div>
    </div>
  </label>
  <label class="jenis-option">
    <input type="radio" name="jenis" value="servis" onchange="toggleJenis(this)" />
    <div>
      <div class="jenis-title">Servis</div>
      <div class="jenis-desc">Sparepart + biaya jasa servis</div>
    </div>
  </label>
</div>

{{-- Detail Biaya Jasa Servis --}}
<div class="biaya-jasa-wrap" id="biayaJasaWrap">
  <div class="biaya-jasa-header"></span><span>Detail Biaya Jasa Servis</span></div>
  <div class="biaya-jasa-row" id="jasaList">
    <div class="jasa-item-row">
      <input type="text" placeholder="Keterangan jasa (contoh: Ganti oli)" oninput="updateRingkasan()" />
      <input type="number" placeholder="Harga (Rp)" min="0" oninput="updateRingkasan()" />
      <button type="button" class="btn-hapus-jasa" onclick="hapusJasa(this)">Hapus</button>
    </div>
  </div>
  <button type="button" class="btn-tambah-jasa" onclick="tambahJasa()">Tambah Jasa</button>
</div>

{{-- Input Data Transaksi --}}
<div class="section-label">Input Data Transaksi</div>
<div class="input-row">
  <div class="input-group">
    <label>Scan Barcode / Kode</label>
    <input class="input-field" id="inputKode" type="text" placeholder="Scan barcode atau ketik kode" />
  </div>
  <div class="input-group">
    <label>Cari Barang</label>
    <div class="autocomplete-wrap">
      <input class="input-field" id="inputNama" type="text" placeholder="Ketik nama barang..." autocomplete="off"
        oninput="showDropdown()" onkeydown="handleDropdownKey(event)" />
      <div class="dropdown-list" id="dropdownList"></div>
    </div>
  </div>
  <div class="input-group">
    <label>Jumlah</label>
    <input class="input-field" id="inputQty" type="number" placeholder="1" min="1" value="1" />
  </div>
  <button class="btn-tambah-item" onclick="tambahBarang()">Tambah</button>
</div>

{{-- Item Transaksi --}}
<div class="section-label">Item Transaksi</div>
<div class="transaksi-row">
  <div class="table-wrap">
    <div class="table-header">
      <span class="table-title">Daftar Item</span>
      <span class="table-count" id="itemCount">0 item</span>
    </div>
    <table>
      <thead><tr>
        <th>No</th><th>Kode</th><th>Nama Barang</th><th>Harga</th>
        <th class="center">Jumlah</th><th>Total</th><th class="center">Hapus</th>
      </tr></thead>
      <tbody id="cartBody">
        <tr class="empty-row"><td colspan="7">Belum ada barang ditambahkan</td></tr>
      </tbody>
    </table>
  </div>

  {{-- Ringkasan Pembayaran --}}
  <div class="ringkasan">
    <div class="ringkasan-header">Ringkasan Pembayaran</div>
    <div class="ringkasan-body">
      <div class="ringkasan-row">
        <span class="ringkasan-key">Jenis Transaksi</span>
        <span class="ringkasan-val" id="ringkasanJenis">Pembelian Sparepart</span>
      </div>
      <div class="ringkasan-row">
        <span class="ringkasan-key">Tanggal</span>
        <span class="ringkasan-val" id="tgl">—</span>
      </div>
      <div class="ringkasan-row">
        <span class="ringkasan-key">Jumlah Item</span>
        <span class="ringkasan-val" id="jumlahItem">0 item</span>
      </div>
      <div class="ringkasan-divider"></div>
      <div class="ringkasan-row">
        <span class="ringkasan-key">Subtotal Sparepart</span>
        <span class="ringkasan-val" id="ringkasanSubtotal">Rp 0</span>
      </div>
      <div class="ringkasan-row jasa" id="rowBiayaJasa">
        <span class="ringkasan-key">Subtotal Jasa</span>
        <span class="ringkasan-val" id="ringkasanJasa">Rp 0</span>
      </div>
      <div class="ringkasan-divider"></div>
      <div class="ringkasan-total">
        <span class="ringkasan-total-key">Total</span>
        <span class="ringkasan-total-val" id="ringkasanTotal">Rp 0</span>
      </div>
    </div>
  </div>
</div>

{{-- Metode Pembayaran --}}
<div class="section-label">Metode Pembayaran</div>
<div class="metode-wrap">
  <label class="metode-option"><input type="radio" name="metode" value="Cash" checked />Cash</label>
  <label class="metode-option"><input type="radio" name="metode" value="QRIS" />QRIS</label>
</div>

{{-- Tindakan --}}
<div class="action-row">
  <button class="btn-simpan" onclick="showKonfirmasi()">Simpan &amp; Cetak Struk</button>
  <button class="btn-batal" onclick="batalTransaksi()">Batal</button>
</div>

{{-- Modal Konfirmasi --}}
<div class="modal-overlay" id="modalOverlay">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-header-title">Konfirmasi Transaksi</div>
    </div>
    <div class="modal-body">
      <p>Pastikan data transaksi sudah benar sebelum disimpan.</p>
      <div class="modal-summary">
        <div class="modal-summary-row"><span>Jenis Transaksi</span><span id="modalJenis">—</span></div>
        <div class="modal-summary-row"><span>Jumlah Item</span><span id="modalItem">—</span></div>
        <div class="modal-summary-row"><span>Metode</span><span id="modalMetode">—</span></div>
        <div class="modal-summary-row" id="modalRowJasa" style="display:none"><span>Biaya Jasa</span><span id="modalJasaVal">Rp 0</span></div>
        <div class="modal-summary-row total"><span>Total</span><span id="modalTotal">Rp 0</span></div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-modal-cancel" onclick="hideKonfirmasi()">Periksa Lagi</button>
      <button class="btn-modal-confirm" onclick="simpan()">Ya, Simpan</button>
    </div>
  </div>
</div>

{{-- Struk Overlay --}}
<div class="struk-overlay" id="strukOverlay">
  <div class="struk-modal-wrap">
    <div class="struk-wrap" id="printArea">
      <div class="struk-top"></div>
      <div class="struk-body">
        <div class="struk-header">
          <div class="struk-shop-name">BENGKEL ANTON MOTOR</div>
          <div class="struk-shop-sub">Jl. Tuanku Nan Renceh, Lubuk Basung</div>
          <div class="struk-shop-sub">Kab. Agam, Sumatera Barat</div>
          <div class="struk-shop-sub">Telp: 0813-6324-2276</div>
        </div>
        <div class="struk-info" id="strukInfo"></div>
        <div class="struk-items" id="strukItems"></div>
        <div class="struk-total" id="strukTotal"></div>
        <div class="struk-footer">
          <div class="simpan-note">Simpan struk ini sebagai<br>bukti pembelian</div>
          <div class="terima-kasih">Terima Kasih!</div>
        </div>
      </div>
      <div class="struk-bottom"></div>
    </div>
    <div class="struk-action-row">
      <button class="btn-struk-print" onclick="cetakStruk()">Cetak Struk</button>
      <button class="btn-struk-close" onclick="tutupStruk()">Kembali ke POS</button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
// ── Variabel Global ──
const CSRF   = document.querySelector('meta[name="csrf-token"]').content;
const BARANG = @json($barang);
const JENIS_POS = 'eceran'; 
let cart = [], focusIdx = -1, selectedBarangId = null, strukData = {};

// ── Format Rupiah ──
const rp = n => 'Rp ' + parseInt(n).toLocaleString('id-ID');
const now = () => { const d=new Date(); return d.toLocaleDateString('id-ID',{day:'2-digit',month:'long',year:'numeric'})+' '+d.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'}); };

// ── Inisialisasi tanggal ──
document.getElementById('tgl').textContent = now();

// ── Set fokus ke input kode saat halaman dimuat ──
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('inputKode').focus();
});

// ── Shortcut Keyboard: Enter untuk tambah barang atau simpan ──
document.addEventListener('keydown', e => {
  if (e.key !== 'Enter') return;

  const modalVisible = document.getElementById('modalOverlay').classList.contains('show');
  const strukVisible = document.getElementById('strukOverlay').classList.contains('show');
  const dropdownVisible = document.getElementById('dropdownList').classList.contains('show');

  if (strukVisible)  { e.preventDefault(); cetakStruk(); return; }
  if (modalVisible)  { e.preventDefault(); simpan(); return; }
  if (dropdownVisible) return; 

  // ── Cek fokus ada di inputKode atau tidak ──
  const activeEl = document.activeElement;
  if (activeEl && activeEl.id === 'inputKode') {
    const kode = activeEl.value.trim();
    if (kode) {
      e.preventDefault();
      tambahBarang();
    } else {
      e.preventDefault();
      const _jasa=Array.from(document.querySelectorAll('#jasaList .jasa-item-row')).reduce((s,r)=>s+(parseInt(r.querySelectorAll('input')[1]?.value)||0),0);
      if(cart.length > 0 || _jasa > 0) showKonfirmasi();
    }
  }
});

// ── Toggle Jenis Transaksi ──
function toggleJenis(el) {
  const isServis = el.value === 'servis';
  document.getElementById('biayaJasaWrap').classList.toggle('show', isServis);
  document.getElementById('rowBiayaJasa').classList.toggle('show', isServis);
  document.getElementById('ringkasanJenis').textContent = isServis ? 'Servis' : 'Pembelian Sparepart';
  if (!isServis) document.querySelectorAll('#jasaList .jasa-item-row input').forEach(i=>i.value='');
  updateRingkasan();
}

// ── Dropdown autocomplete ──
function showDropdown() {
  const q = document.getElementById('inputNama').value.toLowerCase();
  const dd = document.getElementById('dropdownList');
  if (!q) { dd.classList.remove('show'); return; }
  const hasil = BARANG.filter(b => {
    const nama = (b.nama_barang || '').toLowerCase();
    const kode = (b.kode_barang || '').toLowerCase();
    return nama.includes(q) || kode.includes(q);
  })
  .sort((a, b) => {
    const namaA = (a.nama_barang || '').toLowerCase();
    const namaB = (b.nama_barang || '').toLowerCase();
    const aAwalan = namaA.startsWith(q);
    const bAwalan = namaB.startsWith(q);
    if (aAwalan && !bAwalan) return -1;
    if (!aAwalan && bAwalan) return 1;
    return namaA.localeCompare(namaB, 'id');
  })
  .slice(0, 100);
  if (!hasil.length) { dd.classList.remove('show'); return; }
  focusIdx = -1;
  dd.innerHTML = hasil.map((b,i) => `
    <div class="dropdown-item" data-idx="${i}" data-id="${b.id}" data-kode="${b.kode_barang || ''}" data-nama="${b.nama_barang}" data-harga="${JENIS_POS==='grosir'?b.harga_grosir:b.harga_eceran}" data-stok="${b.stok}"
      onclick="pilihDariDropdown(this)">
      <div class="dropdown-item-left">
        <span class="dropdown-item-nama">${b.nama_barang}</span>
        <span class="dropdown-item-kode">${b.kode_barang || '-'} — Stok: ${b.stok}</span>
      </div>
      <span class="dropdown-item-harga">${rp(JENIS_POS==='grosir'?b.harga_grosir:b.harga_eceran)}</span>
    </div>`).join('');
  dd.classList.add('show');
}

// ── Navigasi dropdown dengan keyboard ──
function handleDropdownKey(e) {
  const items = document.querySelectorAll('.dropdown-item');
  if (e.key==='ArrowDown') { focusIdx=Math.min(focusIdx+1,items.length-1); highlightItem(items); e.preventDefault(); }
  else if (e.key==='ArrowUp') { focusIdx=Math.max(focusIdx-1,0); highlightItem(items); e.preventDefault(); }
  else if (e.key==='Enter' && focusIdx>=0) { pilihDariDropdown(items[focusIdx]); e.preventDefault(); }
  else if (e.key==='Escape') { document.getElementById('dropdownList').classList.remove('show'); }
}

// ── Highlight item yang difokus dengan keyboard ──
function highlightItem(items) { items.forEach((el,i)=>el.classList.toggle('focused',i===focusIdx)); }

// ── Pilih item dari dropdown ──
function pilihDariDropdown(el) {
  document.getElementById('inputKode').value = el.dataset.kode;
  document.getElementById('inputNama').value = el.dataset.nama;
  selectedBarangId = parseInt(el.dataset.id);
  document.getElementById('dropdownList').classList.remove('show');
}

document.addEventListener('click', e => {
  if (!e.target.closest('.autocomplete-wrap')) document.getElementById('dropdownList').classList.remove('show');
});

// ── Tambah ke cart ──
function tambahBarang() {
  const kode = document.getElementById('inputKode').value.trim();
  const nama = document.getElementById('inputNama').value.trim();
  const qty  = parseInt(document.getElementById('inputQty').value) || 1;
  let barang = null;
  if (selectedBarangId) barang = BARANG.find(b => b.id === selectedBarangId);
  if (!barang && kode) barang = BARANG.find(b => b.kode_barang && b.kode_barang.toLowerCase()===kode.toLowerCase());
  if (!barang && nama) barang = BARANG.find(b => b.nama_barang.toLowerCase()===nama.toLowerCase());
  if (!barang) { alert('Barang tidak ditemukan!'); return; }
  const harga = JENIS_POS==='grosir' ? barang.harga_grosir : barang.harga_eceran;
  const existing = cart.find(c => c.id===barang.id);
  if (existing) {
    if (existing.qty+qty > barang.stok) { alert('Stok tidak mencukupi!'); return; }
    existing.qty += qty; existing.subtotal = existing.qty*existing.harga;
  } else {
    if (qty > barang.stok) { alert('Stok tidak mencukupi!'); return; }
    cart.push({id:barang.id, kode:barang.kode_barang, nama:barang.nama_barang, harga, qty, subtotal:qty*harga, stok:barang.stok});
  }
  document.getElementById('inputKode').value='';
  document.getElementById('inputNama').value='';
  document.getElementById('inputQty').value=1;
  selectedBarangId = null;
  document.getElementById('inputKode').focus();
  renderCart(); updateRingkasan();
}

// ── Render cart ke tabel ──
function renderCart() {
  const tbody = document.getElementById('cartBody');
  if (!cart.length) {
    tbody.innerHTML='<tr class="empty-row"><td colspan="7">Belum ada barang ditambahkan</td></tr>';
    document.getElementById('itemCount').textContent='0 item'; return;
  }
  tbody.innerHTML = cart.map((item,i) => `
    <tr>
      <td>${i+1}</td><td>${item.kode}</td><td>${item.nama}</td><td>${rp(item.harga)}</td>
      <td class="center">
        <div class="qty-control">
          <button class="qty-btn" onclick="changeQty(${i},-1)">-</button>
          <input class="qty-input" type="number" value="${item.qty}" min="1" onchange="setQty(${i},this.value)" />
          <button class="qty-btn" onclick="changeQty(${i},1)">+</button>
        </div>
      </td>
      <td><strong>${rp(item.subtotal)}</strong></td>
      <td class="center"><button class="btn-hapus-item" onclick="hapusItem(${i})">Hapus</button></td>
    </tr>`).join('');
  document.getElementById('itemCount').textContent = cart.reduce((s,c)=>s+c.qty,0)+' item';
}

// ── Ubah jumlah dengan tombol atau input langsung ──
function changeQty(idx,delta) {
  const item=cart[idx], newQty=item.qty+delta;
  if(newQty<1)return; if(newQty>item.stok){alert('Stok tidak mencukupi!');return;}
  item.qty=newQty; item.subtotal=item.qty*item.harga; renderCart(); updateRingkasan();
}

// ── Set jumlah langsung dari inputan ──
function setQty(idx,val) {
  const q=parseInt(val)||1, item=cart[idx];
  if(q>item.stok){alert('Stok tidak mencukupi!');return;}
  item.qty=q; item.subtotal=q*item.harga; renderCart(); updateRingkasan();
}

// ── Hapus item dari cart ──
function hapusItem(idx) { cart.splice(idx,1); renderCart(); updateRingkasan(); }
function batalTransaksi() { if(confirm('Reset semua item?')){ cart=[]; renderCart(); updateRingkasan(); } }

// ── Update ringkasan pembayaran ──
function updateRingkasan() {
  const subtotal = cart.reduce((s,c)=>s+c.subtotal,0);
  const jasa = Array.from(document.querySelectorAll('#jasaList .jasa-item-row')).reduce((s,r)=>s+(parseInt(r.querySelectorAll('input')[1]?.value)||0),0);
  const total = subtotal+jasa;
  document.getElementById('ringkasanSubtotal').textContent = rp(subtotal);
  document.getElementById('ringkasanJasa').textContent     = rp(jasa);
  document.getElementById('ringkasanTotal').textContent    = rp(total);
  document.getElementById('jumlahItem').textContent        = cart.reduce((s,c)=>s+c.qty,0)+' item';
}

// ── Konfirmasi & Simpan ──
function getJenis() { return document.querySelector('input[name="jenis"]:checked').value; }
function getMetode() { return document.querySelector('input[name="metode"]:checked').value; }

// Tampilkan modal konfirmasi dengan detail transaksi
function showKonfirmasi() {
  const _jasaTotal=Array.from(document.querySelectorAll('#jasaList .jasa-item-row')).reduce((s,r)=>s+(parseInt(r.querySelectorAll('input')[1]?.value)||0),0);
  if(!cart.length && _jasaTotal <= 0){alert('Tambahkan barang atau isi biaya jasa terlebih dahulu!');return;}
  const subtotal=cart.reduce((s,c)=>s+c.subtotal,0);
  const jasa=Array.from(document.querySelectorAll('#jasaList .jasa-item-row')).reduce((s,r)=>s+(parseInt(r.querySelectorAll('input')[1]?.value)||0),0);
  const total=subtotal+jasa;
  const jenis=getJenis();
  document.getElementById('modalJenis').textContent   = jenis==='servis'?'Servis':'Pembelian Sparepart';
  document.getElementById('modalItem').textContent    = cart.reduce((s,c)=>s+c.qty,0)+' item';
  document.getElementById('modalMetode').textContent  = getMetode();
  document.getElementById('modalTotal').textContent   = rp(total);
  document.getElementById('modalRowJasa').style.display = jenis==='servis'?'flex':'none';
  document.getElementById('modalJasaVal').textContent = rp(jasa);
  document.getElementById('modalOverlay').classList.add('show');
}
function hideKonfirmasi() { document.getElementById('modalOverlay').classList.remove('show'); }

// ── Simpan transaksi ke server dan tampilkan struk jika berhasil ──
function simpan() {
  const jenis  = getJenis();
  const metode = getMetode();
  const jasa   = parseInt(document.getElementById('biayaJasaInput')?.value)||0;
  const items  = cart.map(c=>({barang_id:c.id, qty:c.qty, harga_satuan:c.harga}));
  const detailJasa = Array.from(document.querySelectorAll('#jasaList .jasa-item-row'))
    .map(r=>({keterangan:r.querySelectorAll('input')[0]?.value?.trim()||'Jasa Servis',harga:parseInt(r.querySelectorAll('input')[1]?.value)||0}))
    .filter(j=>j.harga>0);
  const payload = { jenis, metode_bayar:metode, items, detail_jasa:detailJasa };

  fetch('/pos/simpan',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},body:JSON.stringify(payload)})
    .then(r=>r.json()).then(data=>{
      if(data.success){ hideKonfirmasi(); tampilStruk(data, jasa, detailJasa); }
      else alert('Error: '+data.message);
    });
}

//  ── Tampilkan overlay struk dengan data transaksi yang diterima dari server ──
function tampilStruk(data, biayaJasa, detailJasaArr) {
  const d = new Date();
  const tgl = d.toLocaleDateString('id-ID',{day:'2-digit',month:'long',year:'numeric'});
  const jam = d.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});
  const metode = getMetode();
  const jenis  = getJenis();
  strukData = { no_transaksi: data.no_transaksi, total: data.total, tgl, jam, metode, jenis, biayaJasa, detailJasaArr: detailJasaArr || [] };
  document.getElementById('strukInfo').innerHTML=`
    <div class="struk-info-row"><span>No. Transaksi</span><span>${data.no_transaksi}</span></div>
    <div class="struk-info-row"><span>Tanggal</span><span>${tgl}</span></div>
    <div class="struk-info-row"><span>Jam</span><span>${jam}</span></div>
    <div class="struk-info-row"><span>Kasir</span><span>{{ Auth::user()->name }}</span></div>
    <div class="struk-info-row"><span>Metode</span><span>${metode}</span></div>`;
  let itemsHtml = '<div style="font-size:8.5px;font-weight:bold;margin-bottom:4px;color:#000;">SPAREPART:</div>' +
    cart.map(c=>`
      <div class="struk-item">
        <div class="struk-item-name">${c.nama}</div>
        <div class="struk-item-detail"><span>${c.qty} x ${rp(c.harga)}</span><span>${rp(c.subtotal)}</span></div>
      </div>`).join('');
  
  let jasaHtml = '';
  if (detailJasaArr && detailJasaArr.length > 0) {
    jasaHtml = '<div style="margin-top:8px;padding-top:8px;border-top:1px dashed #999;"><div style="font-size:8.5px;font-weight:bold;margin-bottom:4px;color:#555;">BIAYA JASA:</div>' +
      detailJasaArr.map(j=>`
        <div class="struk-item" style="display:flex;justify-content:space-between;align-items:center;">
          <div class="struk-item-name" style="font-size:8px;margin-bottom:0;">${j.keterangan}</div>
          <div style="font-size:8px;font-weight:bold;">${rp(j.harga)}</div>
        </div>`).join('') + '</div>';
  }
  
  document.getElementById('strukItems').innerHTML = itemsHtml + jasaHtml;
  const subtotal=cart.reduce((s,c)=>s+c.subtotal,0);
  const jasaTotal = (detailJasaArr || []).reduce((s,j)=>s+j.harga,0);
  document.getElementById('strukTotal').innerHTML=`
    ${jasaTotal > 0 ? `<div class="struk-total-row"><span>Subtotal Sparepart</span><span>${rp(subtotal)}</span></div>
    <div class="struk-total-row"><span>Subtotal Jasa</span><span>${rp(jasaTotal)}</span></div>` : ``}
    <div class="struk-total-main">
      <span class="struk-total-main-label">TOTAL</span>
      <span class="struk-total-main-value">${rp(data.total)}</span>
    </div>`;
  document.getElementById('strukOverlay').classList.add('show');
}

// ── Cetak struk menggunakan window.print() dan sembunyikan overlay setelah selesai mencetak ──
function cetakStruk() {
  const { no_transaksi, total, tgl, jam, metode, biayaJasa, detailJasaArr } = strukData;
  const subtotal = cart.reduce((s,c)=>s+c.subtotal,0);
  const kasir = '{{ Auth::user()->name }}';

  let itemsHtml = '<div style="font-size:9pt;font-weight:bold;margin-bottom:3px;">SPAREPART:</div>' +
    cart.map(c => `
    <div style="font-size:9pt;font-weight:bold;margin-top:6px;">${c.nama}</div>
    <div style="overflow:hidden;margin-top:2px;">
      <span style="float:left;font-size:8.5pt;">${c.qty} x ${rp(c.harga)}</span>
      <span style="float:right;font-size:9pt;font-weight:bold;">${rp(c.subtotal)}</span>
    </div>
    <div style="clear:both;"></div>`).join('');

  let jasaHtml = '';
  const jasaTotal = (detailJasaArr || []).reduce((s,j)=>s+j.harga,0);
  if (detailJasaArr && detailJasaArr.length > 0) {
    jasaHtml = `<hr style="border:none;border-top:1px dashed #000;margin:5px 0;">
      <div style="overflow:hidden;margin-bottom:2px;margin-top:3px;">
        <span style="float:left;font-size:8.5pt;font-weight:bold;">BIAYA JASA:</span>
      </div><div style="clear:both;"></div>` +
      detailJasaArr.map(j => `
        <div style="overflow:hidden;margin-bottom:2px;">
          <span style="float:left;font-size:8pt;">${j.keterangan}</span>
          <span style="float:right;font-size:8.5pt;font-weight:bold;">${rp(j.harga)}</span>
        </div><div style="clear:both;"></div>`).join('');
  }

  let subtotalHtml = jasaTotal > 0 ? `
    <hr style="border:none;border-top:1px dashed #000;margin:5px 0;">
    <div style="overflow:hidden;margin-bottom:3px;">
      <span style="float:left;font-size:8.5pt;">Subtotal Sparepart</span>
      <span style="float:right;font-size:8.5pt;">${rp(subtotal)}</span>
    </div><div style="clear:both;"></div>
    <div style="overflow:hidden;margin-bottom:3px;">
      <span style="float:left;font-size:8.5pt;">Subtotal Jasa</span>
      <span style="float:right;font-size:8.5pt;">${rp(jasaTotal)}</span>
    </div><div style="clear:both;"></div>` : '';

  const container = document.getElementById('strukPrintContainer');
  container.innerHTML = `
    <p style="font-size:12pt;font-weight:bold;text-align:center;letter-spacing:1px;margin-bottom:3px;">BENGKEL ANTON MOTOR</p>
    <p style="font-size:8pt;text-align:center;margin-bottom:2px;">Jl. Tuanku Nan Renceh, Lubuk Basung</p>
    <p style="font-size:8pt;text-align:center;margin-bottom:2px;">Kab. Agam, Sumatera Barat</p>
    <p style="font-size:8pt;text-align:center;margin-bottom:5px;">Telp: 0813-6324-2276</p>
    <hr style="border:none;border-top:1px dashed #000;margin:5px 0;">
    <div style="overflow:hidden;margin-bottom:3px;"><span style="float:left;font-size:8.5pt;">No. Transaksi</span><span style="float:right;font-size:8.5pt;font-weight:bold;">${no_transaksi}</span></div><div style="clear:both;"></div>
    <div style="overflow:hidden;margin-bottom:3px;"><span style="float:left;font-size:8.5pt;">Tanggal</span><span style="float:right;font-size:8.5pt;font-weight:bold;">${tgl}</span></div><div style="clear:both;"></div>
    <div style="overflow:hidden;margin-bottom:3px;"><span style="float:left;font-size:8.5pt;">Jam</span><span style="float:right;font-size:8.5pt;font-weight:bold;">${jam}</span></div><div style="clear:both;"></div>
    <div style="overflow:hidden;margin-bottom:3px;"><span style="float:left;font-size:8.5pt;">Kasir</span><span style="float:right;font-size:8.5pt;font-weight:bold;">${kasir}</span></div><div style="clear:both;"></div>
    <div style="overflow:hidden;margin-bottom:3px;"><span style="float:left;font-size:8.5pt;">Metode</span><span style="float:right;font-size:8.5pt;font-weight:bold;">${metode}</span></div><div style="clear:both;"></div>
    <hr style="border:none;border-top:1px dashed #000;margin:5px 0;">
    ${itemsHtml}
    ${jasaHtml}
    ${subtotalHtml}
    <div style="border-top:1.5px solid #000;border-bottom:1.5px solid #000;padding:6px 0;margin-top:5px;overflow:hidden;">
      <span style="float:left;font-size:11pt;font-weight:bold;">TOTAL</span>
      <span style="float:right;font-size:11pt;font-weight:bold;">${rp(total)}</span>
    </div>
    <div style="clear:both;"></div>
    <div style="text-align:center;font-size:8pt;margin-top:10px;line-height:1.6;">Simpan struk ini sebagai<br>bukti pembelian</div>
    <p style="text-align:center;font-size:10pt;font-weight:bold;margin-top:5px;margin-bottom:4px;">Terima Kasih!</p>
    <div style="height:6px;"></div>`;

  container.style.display = 'block';
  document.body.appendChild(container);
  window.onafterprint = function() {
    container.style.display = 'none';
    container.innerHTML = '';
    tutupStruk();
  };
  window.print();
}

// ── Tutup overlay struk dan reset data untuk transaksi baru ──
function tutupStruk() {
  document.getElementById('strukOverlay').classList.remove('show');
  cart=[]; renderCart(); updateRingkasan();
  document.querySelectorAll('#jasaList .jasa-item-row input').forEach(i=>i.value='');
  document.querySelector('input[name="jenis"][value="eceran"]').checked=true;
  toggleJenis({value:'eceran'});
  document.getElementById('inputKode').focus();
}
function tambahJasa() {
  const list = document.getElementById('jasaList');
  const row = document.createElement('div');
  row.className = 'jasa-item-row';
  row.innerHTML = `
    <input type="text" placeholder="Keterangan jasa" oninput="updateRingkasan()" />
    <input type="number" placeholder="Harga (Rp)" min="0" oninput="updateRingkasan()" />
    <button type="button" class="btn-hapus-jasa" onclick="hapusJasa(this)">Hapus</button>`;
  list.appendChild(row);
}

function hapusJasa(btn) {
  const rows = document.querySelectorAll('#jasaList .jasa-item-row');
  if (rows.length <= 1) {
    // Kosongkan saja kalau hanya 1 baris
    btn.closest('.jasa-item-row').querySelectorAll('input').forEach(i=>i.value='');
  } else {
    btn.closest('.jasa-item-row').remove();
  }
  updateRingkasan();
}
</script>
@endsection