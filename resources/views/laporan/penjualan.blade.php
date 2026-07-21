@extends('layouts.app')
@section('title', 'Laporan Penjualan')
@section('head')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
@endsection
@section('styles')
  .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;}
  .page-title{font-size:22px;font-weight:800;color:var(--text-main);}
  .page-period-badge{font-size:13px;font-weight:600;background:var(--white);color:var(--primary-dark);padding:6px 14px;border-radius:20px;border:1.5px solid var(--border);}
  .ringkasan-card{background:linear-gradient(135deg,var(--primary-dark) 0%,var(--primary) 100%);border-radius:12px;padding:22px 28px;margin-bottom:20px;box-shadow:0 4px 16px rgba(26,86,219,0.25);}
  .ringkasan-title{font-size:12px;font-weight:700;color:rgba(255,255,255,0.65);margin-bottom:18px;text-transform:uppercase;letter-spacing:0.08em;}
  .ringkasan-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:0;}
  .ringkasan-stat{padding:0 24px;border-right:1px solid rgba(255,255,255,0.15);}
  .ringkasan-stat:first-child{padding-left:0;}
  .ringkasan-stat:last-child{border-right:none;}
  .ringkasan-stat-label{font-size:11.5px;color:rgba(255,255,255,0.65);font-weight:500;margin-bottom:6px;}
  .ringkasan-stat-value{font-size:22px;font-weight:800;color:#fff;line-height:1.1;}
  .ringkasan-stat-value.small{font-size:17px;}
  .ringkasan-stat-sub{font-size:11px;color:rgba(255,255,255,0.5);margin-top:4px;}
  .filter-card{background:var(--white);border-radius:12px;border:1px solid var(--border);padding:20px 24px;margin-bottom:20px;box-shadow:0 2px 6px rgba(0,0,0,0.04);}
  .filter-title{font-size:13.5px;font-weight:700;color:var(--text-main);margin-bottom:16px;display:flex;align-items:center;gap:8px;}
  .filter-title::before{content:'';width:3px;height:14px;background:var(--primary);border-radius:99px;display:inline-block;}
  .shortcut-row{display:flex;align-items:center;gap:8px;margin-bottom:14px;flex-wrap:wrap;}
  .shortcut-label{font-size:12px;font-weight:600;color:var(--text-sub);text-transform:uppercase;letter-spacing:0.05em;margin-right:4px;white-space:nowrap;}
  .shortcut-btn{padding:6px 14px;background:#F8FAFF;color:var(--text-sub);font-size:12.5px;font-weight:600;font-family:inherit;border:1.5px solid var(--border);border-radius:20px;cursor:pointer;transition:all 0.18s;white-space:nowrap;}
  .shortcut-btn:hover{background:#EBF2FF;color:var(--primary-dark);border-color:var(--primary);}
  .shortcut-btn.active{background:var(--primary-dark);color:#fff;border-color:var(--primary-dark);}
  .shortcut-divider{width:1px;height:18px;background:var(--border);margin:0 4px;}
  .filter-row{display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto auto;gap:10px;align-items:end;}
  .filter-group{display:flex;flex-direction:column;gap:6px;}
  .filter-group label{font-size:11.5px;font-weight:600;color:var(--text-sub);text-transform:uppercase;letter-spacing:0.05em;}
  .filter-group input,.filter-group select{padding:9px 13px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit;color:var(--text-main);background:#F8FAFF;outline:none;transition:border-color 0.2s;width:100%;}
  .filter-group input:focus,.filter-group select:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(26,86,219,0.10);background:var(--white);}
  .btn-filter{padding:9px 22px;background:var(--primary-dark);color:#fff;font-size:13.5px;font-weight:700;font-family:inherit;border:none;border-radius:8px;cursor:pointer;box-shadow:0 4px 12px rgba(26,86,219,0.2);transition:background 0.2s;white-space:nowrap;}
  .btn-filter:hover{background:var(--primary);}
  .btn-reset{padding:9px 16px;background:var(--white);color:var(--text-sub);font-size:13px;font-weight:600;font-family:inherit;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;white-space:nowrap;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;}
  .btn-reset:hover{background:#F3F4F6;color:var(--text-main);}
  .table-card{background:var(--white);border-radius:12px;border:1px solid var(--border);overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,0.04);margin-bottom:16px;}
  .table-card-header{padding:16px 20px;border-bottom:1px solid #EEF2FF;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
  .table-card-title{font-size:14px;font-weight:700;color:var(--text-main);display:flex;align-items:center;gap:8px;}
  .table-card-title::before{content:'';width:3px;height:14px;background:var(--primary);border-radius:99px;display:inline-block;}
  .table-badge{font-size:11.5px;font-weight:600;background:var(--bg);color:var(--primary-dark);padding:3px 10px;border-radius:20px;border:1px solid var(--border);}
  table{width:100%;border-collapse:collapse;}
  thead tr{background:var(--header-bg);}
  thead th{padding:12px 14px;text-align:left;font-size:11px;font-weight:600;color:rgba(255,255,255,0.85);letter-spacing:0.05em;text-transform:uppercase;white-space:nowrap;}
  tbody tr{border-bottom:1px solid #EEF2FF;transition:background 0.15s;}
  tbody tr:last-child{border-bottom:none;}
  tbody tr:hover{background:#F5F8FF;}
  tbody td{padding:11px 14px;font-size:13px;color:var(--text-main);}
  tfoot td{padding:12px 14px;font-size:13px;font-weight:700;color:var(--text-main);background:#F5F8FF;border-top:2px solid var(--border);}
  .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600;white-space:nowrap;}
  .badge-cash{background:var(--success-light);color:var(--success);}
  .badge-qris{background:#EDE9FE;color:#6D28D9;}
  .badge-eceran{background:#DBEAFE;color:#1D4ED8;}
  .badge-grosir{background:#E0F2FE;color:#0369A1;}
  .badge-servis{background:var(--warning-light);color:var(--warning);}
  .bottom-row{display:flex;align-items:center;justify-content:space-between;gap:12px;}
  .pagination-wrap{display:flex;align-items:center;}
  .action-row{display:flex;gap:8px;flex-wrap:wrap;}
  .btn-pdf{padding:10px 18px;background:var(--danger);color:#fff;font-size:13px;font-weight:700;font-family:inherit;border:none;border-radius:8px;cursor:pointer;display:flex;align-items:center;gap:7px;box-shadow:0 4px 12px rgba(220,38,38,0.2);transition:background 0.2s;white-space:nowrap;}
  .btn-pdf:hover{background:#B91C1C;}
  .btn-csv{padding:10px 18px;background:#ECFDF5;color:#065F46;font-size:13px;font-weight:700;font-family:inherit;border:1.5px solid #6EE7B7;border-radius:8px;cursor:pointer;display:flex;align-items:center;gap:7px;transition:all 0.2s;white-space:nowrap;}
  .btn-csv:hover{background:#059669;color:#fff;border-color:#059669;}
  .btn-print{padding:10px 18px;background:var(--white);color:var(--text-main);font-size:13px;font-weight:600;font-family:inherit;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;display:flex;align-items:center;gap:7px;white-space:nowrap;}
  .btn-print:hover{background:#F3F4F6;}
  .toast-box{position:fixed;bottom:28px;right:28px;z-index:9999;}
  .toast{padding:13px 20px;border-radius:10px;font-size:13px;font-weight:700;color:#fff;box-shadow:0 4px 16px rgba(0,0,0,0.15);margin-top:8px;animation:toastIn 0.3s ease;}
  @keyframes toastIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
  .print-header{display:none;text-align:center;margin-bottom:16px;}
  .print-header h2{font-size:16px;font-weight:800;}
  .print-header p{font-size:12px;color:#555;}
  @media print{
    body{background:#fff!important;}
    .topbar,.sidebar,.filter-card,.bottom-row,.footer,.nav-badge{display:none!important;}
    .layout{display:block!important;}
    .main{padding:0!important;}
    .ringkasan-card{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
    .print-header{display:block!important;}
    thead tr{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
  }

  /* ── Tablet (≤900px) ── */
  @media(max-width:900px){
    .ringkasan-stats{grid-template-columns:1fr 1fr;}
    .ringkasan-stat:nth-child(2){border-right:none;}
    .ringkasan-stat:nth-child(3){padding-left:0;border-top:1px solid rgba(255,255,255,0.15);padding-top:14px;}
    .ringkasan-stat:last-child{padding-top:14px;}
    .filter-row{grid-template-columns:1fr 1fr;}


  }

  /* ── Mobile (≤640px) ── */
  @media(max-width:640px){
    .page-header{flex-direction:column;align-items:flex-start;gap:6px;margin-bottom:12px;}
    .page-title{font-size:18px;}
    .page-period-badge{font-size:12px;padding:4px 10px;}
    .ringkasan-card{padding:16px 14px;margin-bottom:14px;border-radius:10px;}
    .ringkasan-title{margin-bottom:12px;font-size:11px;}
    .ringkasan-stats{grid-template-columns:1fr 1fr;gap:12px 0;}
    .ringkasan-stat{padding:0 12px;border-right:1px solid rgba(255,255,255,0.15);}
    .ringkasan-stat:first-child{padding-left:0;}
    .ringkasan-stat:nth-child(2){border-right:none;}
    .ringkasan-stat:nth-child(3){padding-left:0;border-top:1px solid rgba(255,255,255,0.15);padding-top:12px;border-right:1px solid rgba(255,255,255,0.15);}
    .ringkasan-stat:last-child{padding-top:12px;border-right:none;}
    .ringkasan-stat-value{font-size:17px;}
    .ringkasan-stat-value.small{font-size:14px;}
    .ringkasan-stat-label{font-size:10.5px;}
    .filter-card{padding:14px;margin-bottom:14px;}
    .filter-title{font-size:13px;margin-bottom:12px;}
    .shortcut-row{flex-wrap:wrap;gap:6px;margin-bottom:10px;}
    .shortcut-label{width:100%;margin-right:0;}
    .shortcut-btn{padding:5px 10px;font-size:11.5px;}
    .shortcut-divider{display:none;}
    .filter-row{flex-direction:column;gap:8px;align-items:stretch;}
    .filter-group{width:100%;flex:none;}
    .filter-group input,.filter-group select{width:100%;min-width:0;}
    .btn-filter{width:100%;justify-content:center;align-self:auto;}
    .btn-reset{width:100%;align-self:auto;text-align:center;}
    .table-card{border-radius:8px;}
    .table-card-header{padding:11px 14px;}
    .table-scroll-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch;width:100%;}
    table{min-width:480px;}
    thead th{padding:9px 10px;font-size:10px;}
    tbody td{padding:9px 10px;font-size:11.5px;}
    tfoot td{padding:9px 10px;font-size:11.5px;}
    .bottom-row{flex-direction:column;gap:8px;align-items:stretch;}
    .bottom-row > div{display:flex;justify-content:flex-start;}
    .pagination-wrap{display:flex;justify-content:flex-start;}
    .action-row{flex-direction:column;gap:6px;}
    .btn-pdf,.btn-csv,.btn-print{width:100%;justify-content:center;}
    .toast-box{bottom:16px;right:12px;left:12px;}
    .toast{font-size:12px;}
  }
@endsection

@section('content')
<div class="toast-box" id="toastBox"></div>

{{-- Header untuk cetak laporan --}}
<div class="print-header">
  <h2>BENGKEL ANTON MOTOR — Laporan Penjualan</h2>
  <p>Periode: {{ request('dari') ? request('dari').' s/d '.request('hingga') : 'Semua Periode' }}</p>
</div>
<div class="page-header">
  <div class="page-title">Laporan Penjualan</div>
  <span class="page-period-badge">
    {{ request('dari') ? \Carbon\Carbon::parse(request('dari'))->format('d M Y').' — '.\Carbon\Carbon::parse(request('hingga'))->format('d M Y') : 'Semua Periode' }}
  </span>
</div>

{{-- Ringkasan Hero --}}
<div class="ringkasan-card">
  <div class="ringkasan-title">Ringkasan Penjualan</div>
  <div class="ringkasan-stats">
    <div class="ringkasan-stat">
      <div class="ringkasan-stat-label">Total Transaksi</div>
      <div class="ringkasan-stat-value">{{ $ringkasan['total_trx'] }}</div>
      <div class="ringkasan-stat-sub">transaksi</div>
    </div>
    <div class="ringkasan-stat">
      <div class="ringkasan-stat-label">Total Penjualan</div>
      <div class="ringkasan-stat-value small">Rp {{ number_format($ringkasan['total_jual'],0,',','.') }}</div>
    </div>
    <div class="ringkasan-stat">
      <div class="ringkasan-stat-label">Rata-Rata / Transaksi</div>
      <div class="ringkasan-stat-value small">Rp {{ number_format($ringkasan['rata_rata'],0,',','.') }}</div>
    </div>
    <div class="ringkasan-stat">
      <div class="ringkasan-stat-label">Transaksi Servis</div>
      <div class="ringkasan-stat-value">{{ $ringkasan['total_servis'] }}</div>
      <div class="ringkasan-stat-sub">dari {{ $ringkasan['total_trx'] }} transaksi</div>
    </div>
  </div>
</div>

{{-- Filter --}}
<div class="filter-card">
  <div class="filter-title">Filter Periode &amp; Jenis</div>
  <div class="shortcut-row">
    <span class="shortcut-label">Cepat:</span>
    <button class="shortcut-btn" onclick="setShortcut('hari-ini',this)">Hari Ini</button>
    <button class="shortcut-btn" onclick="setShortcut('kemarin',this)">Kemarin</button>
    <div class="shortcut-divider"></div>
    <button class="shortcut-btn" onclick="setShortcut('minggu-ini',this)">Minggu Ini</button>
    <button class="shortcut-btn" onclick="setShortcut('minggu-lalu',this)">Minggu Lalu</button>
    <div class="shortcut-divider"></div>
    <button class="shortcut-btn" onclick="setShortcut('bulan-ini',this)">Bulan Ini</button>
    <button class="shortcut-btn" onclick="setShortcut('bulan-lalu',this)">Bulan Lalu</button>
    <button class="shortcut-btn" onclick="setShortcut('3-bulan',this)">3 Bulan</button>
  </div>
  <form method="GET" action="{{ route('laporan.penjualan') }}" id="filterForm">
    <div class="filter-row">
      <div class="filter-group">
        <label>Dari Tanggal</label>
        <input type="date" name="dari" id="fDari" value="{{ request('dari') }}" onchange="clearShortcut()" />
      </div>
      <div class="filter-group">
        <label>Hingga Tanggal</label>
        <input type="date" name="hingga" id="fHingga" value="{{ request('hingga') }}" onchange="clearShortcut()" />
      </div>
      <div class="filter-group">
        <label>Jenis Transaksi</label>
        <select name="jenis" id="fJenis">
          <option value="">Semua Jenis</option>
          <option value="eceran"  {{ request('jenis')==='eceran'  ? 'selected':'' }}>Sparepart Eceran</option>
          <option value="grosir"  {{ request('jenis')==='grosir'  ? 'selected':'' }}>Sparepart Grosir</option>
          <option value="servis"  {{ request('jenis')==='servis'  ? 'selected':'' }}>Servis</option>
        </select>
      </div>
      <div class="filter-group">
        <label>Metode Bayar</label>
        <select name="metode" id="fMetode">
          <option value="">Semua Metode</option>
          <option value="Cash"  {{ request('metode')==='Cash'  ? 'selected':'' }}>Cash</option>
          <option value="QRIS"  {{ request('metode')==='QRIS'  ? 'selected':'' }}>QRIS</option>
        </select>
      </div>
      <button type="submit" class="btn-filter">Terapkan</button>
      <a href="{{ route('laporan.penjualan') }}" class="btn-reset">Reset</a>
    </div>
  </form>
</div>

{{-- Tabel --}}
<div class="table-card">
  <div class="table-card-header">
    <div class="table-card-title">Detail Transaksi</div>
    <span class="table-badge">{{ $transaksi->total() }} transaksi</span>
  </div>
  <div class="table-scroll-wrap">
  <table id="tabelLaporan">
    <thead>
      <tr>
        <th>No</th><th>Tanggal</th><th>No Transaksi</th>
        <th>Jenis Transaksi</th><th>Jumlah Item</th><th>Total</th><th>Metode Pembayaran</th>
      </tr>
    </thead>
    <tbody>
      @forelse($transaksi as $i => $t)
      <tr>
        <td>{{ ($transaksi->currentPage()-1)*$transaksi->perPage() + $i + 1 }}</td>
        <td>{{ $t->tanggal_transaksi->format('d M Y') }}</td>
        <td><strong>{{ $t->no_transaksi }}</strong></td>
        <td>
          @if($t->jenis==='eceran')
            <span class="badge badge-eceran">Sparepart Eceran</span>
          @elseif($t->jenis==='grosir')
            <span class="badge badge-grosir">Sparepart Grosir</span>
          @else
            <span class="badge badge-servis">Servis</span>
          @endif
        </td>
        <td>{{ $t->detailTransaksi->count() }} item</td>
        <td>
          @php
            $nilaiRetur = $t->detailTransaksi->sum(fn($d) => $d->qty_retur * $d->harga_satuan);
            $totalNetto = $t->total - $nilaiRetur;
          @endphp
          <strong>Rp {{ number_format($totalNetto,0,',','.') }}</strong>
          @if($nilaiRetur > 0)
            <div style="font-size:11px;color:var(--danger);font-weight:600;">
              Retur Rp {{ number_format($nilaiRetur,0,',','.') }}
            </div>
          @endif
        </td>
        <td>
          <span class="badge {{ $t->metode_bayar==='Cash' ? 'badge-cash' : 'badge-qris' }}">
            {{ $t->metode_bayar }}
          </span>
        </td>
      </tr>
      @empty
      <tr><td colspan="7" style="padding:32px;text-align:center;color:var(--text-sub);">Tidak ada data transaksi.</td></tr>
      @endforelse
    </tbody>
    @if($transaksi->count() > 0)
    <tfoot>
      <tr>
        <td colspan="5"><strong>Total ({{ $transaksi->total() }} transaksi)</strong></td>
        <td><strong>Rp {{ number_format($ringkasan['total_jual'],0,',','.') }}</strong></td>
        <td></td>
      </tr>
    </tfoot>
    @endif
  </table>
</div>
</div>

{{-- Bottom --}}
<div class="bottom-row">
  <div class="action-row">
    <button class="btn-pdf"   onclick="downloadPDF()">Download PDF</button>
    <button class="btn-csv"   onclick="exportCSV()">Export CSV</button>
    <button class="btn-print" onclick="cetakLaporan()">Cetak</button>
  </div>
  <div class="pagination-wrap">{{ $transaksi->withQueryString()->links('vendor.pagination.custom') }}</div>
</div>
@endsection

@section('scripts')
<script>
// ── Cetak laporan dengan format khusus ──
function showToast(msg, color='#057A55') {
  const c=document.getElementById('toastBox');
  const t=document.createElement('div');
  t.className='toast';t.style.background=color;t.innerHTML=msg;
  c.appendChild(t);setTimeout(()=>t.remove(),3500);
}

// ── Format date ke ISO (YYYY-MM-DD) untuk input date value ──
function toISO(d){
  const y = d.getFullYear();
  const m = String(d.getMonth()+1).padStart(2,'0');
  const t = String(d.getDate()).padStart(2,'0');
  return y+'-'+m+'-'+t;
}

// ── Set shortcut periode dan submit form filter ──
function setShortcut(key, el) {
  const today = new Date(); today.setHours(0,0,0,0);
  let dari, hingga;
  if (key==='hari-ini') { dari=hingga=toISO(today); }
  else if (key==='kemarin') { const k=new Date(today); k.setDate(k.getDate()-1); dari=hingga=toISO(k); }
  else if (key==='minggu-ini') {
    const d=today.getDay()===0?6:today.getDay()-1;
    const s=new Date(today); s.setDate(today.getDate()-d);
    const m=new Date(s); m.setDate(s.getDate()+6);
    dari=toISO(s); hingga=toISO(m);
  } else if (key==='minggu-lalu') {
    const d=today.getDay()===0?6:today.getDay()-1;
    const sI=new Date(today); sI.setDate(today.getDate()-d);
    const sL=new Date(sI); sL.setDate(sI.getDate()-7);
    const mL=new Date(sL); mL.setDate(sL.getDate()+6);
    dari=toISO(sL); hingga=toISO(mL);
  } else if (key==='bulan-ini') {
    dari=toISO(new Date(today.getFullYear(),today.getMonth(),1));
    hingga=toISO(new Date(today.getFullYear(),today.getMonth()+1,0));
  } else if (key==='bulan-lalu') {
    dari=toISO(new Date(today.getFullYear(),today.getMonth()-1,1));
    hingga=toISO(new Date(today.getFullYear(),today.getMonth(),0));
  } else if (key==='3-bulan') {
    dari=toISO(new Date(today.getFullYear(),today.getMonth()-2,1));
    hingga=toISO(new Date(today.getFullYear(),today.getMonth()+1,0));
  }
  document.getElementById('fDari').value=dari;
  document.getElementById('fHingga').value=hingga;
  document.querySelectorAll('.shortcut-btn').forEach(b=>b.classList.remove('active'));
  el.classList.add('active');
  document.getElementById('filterForm').submit();
}

// ── Hapus active state dari semua shortcut button ──
function clearShortcut() {
  document.querySelectorAll('.shortcut-btn').forEach(b=>b.classList.remove('active'));
}

const stripEmoji = s => s.replace(/[^\x00-\x7F\u00C0-\u024F\u1E00-\u1EFF]/g, '').trim().replace(/\s+/g,' ');

// ── Export data tabel ke CSV ──
function exportCSV() {
  const rows = [...document.querySelectorAll('#tabelLaporan tbody tr')];
  if (!rows.length) { showToast('Tidak ada data','#C27803'); return; }
  const header = ['No','Tanggal','No Transaksi','Jenis','Jumlah Item','Total','Metode'];
  const data = rows.map(r => [...r.cells].map(c=>stripEmoji(c.textContent)));
  const csv = [header,...data].map(r=>r.join(',')).join('\n');
  const a=document.createElement('a');
  a.href=URL.createObjectURL(new Blob(['\uFEFF'+csv],{type:'text/csv;charset=utf-8;'}));
  a.download='laporan_penjualan.csv'; a.click();
  showToast('CSV berhasil diexport');
}

// ── Generate dan download PDF dengan jsPDF ──
function downloadPDF() {
  const semua = @json($pdfData);
  if (!semua.length) { showToast('Tidak ada data','#C27803'); return; }

  const periode = '{{ request("dari") ? \Carbon\Carbon::parse(request("dari"))->format("d M Y")." s/d ".\Carbon\Carbon::parse(request("hingga"))->format("d M Y") : "Semua Periode" }}';
  const filterJenis  = '{{ request("jenis")  ? ucfirst(request("jenis"))  : "Semua Jenis" }}';
  const filterMetode = '{{ request("metode") ? request("metode")          : "Semua Metode" }}';
  const tglCetak = new Date().toLocaleDateString('id-ID',{day:'2-digit',month:'long',year:'numeric'});

  const {jsPDF}=window.jspdf;
  const doc=new jsPDF({orientation:'landscape',unit:'mm',format:'a4'});

  // Header
  doc.setFontSize(16); doc.setFont(undefined,'bold'); doc.setTextColor(30,42,74);
  doc.text('BENGKEL ANTON MOTOR',148,12,{align:'center'});
  doc.setFontSize(10); doc.setFont(undefined,'normal'); doc.setTextColor(80);
  doc.text('Jl. Tuanku Nan Renceh, Lubuk Basung, Kab. Agam, Sumatera Barat',148,18,{align:'center'});
  doc.text('Telp: 0813-6324-2276',148,23,{align:'center'});

  // Garis pemisah
  doc.setDrawColor(30,42,74); doc.setLineWidth(0.5);
  doc.line(14,26,283,26);

  // Judul laporan
  doc.setFontSize(13); doc.setFont(undefined,'bold'); doc.setTextColor(30,42,74);
  doc.text('LAPORAN PENJUALAN',148,32,{align:'center'});

  // Info filter
  doc.setFontSize(8); doc.setFont(undefined,'normal'); doc.setTextColor(100);
  doc.text('Periode : '+periode,14,38);
  doc.text('Jenis   : '+filterJenis,14,43);
  doc.text('Metode  : '+filterMetode,14,48);
  doc.text('Total Transaksi: '+semua.length+' transaksi',148,38,{align:'center'});
  doc.text('Dicetak : '+tglCetak,283,38,{align:'right'});

  // Ringkasan
  const totalVal = {{ $ringkasan['total_jual'] }};
  const rataVal  = {{ $ringkasan['rata_rata'] }};
  doc.text('Total Penjualan: Rp '+totalVal.toLocaleString('id-ID'),283,43,{align:'right'});
  doc.text('Rata-rata/Trx  : Rp '+rataVal.toLocaleString('id-ID'),283,48,{align:'right'});

  doc.setDrawColor(200); doc.setLineWidth(0.3);
  doc.line(14,51,283,51);

  // Tabel
  doc.autoTable({
    startY:54,
    head:[['No','Tanggal','No Transaksi','Jenis','Jumlah Item','Retur','Total','Metode']],
    body: semua.map((t,i)=>[i+1, t.tanggal, t.no_trx, t.jenis, t.jumlah_item, t.retur, t.total, t.metode]),
    headStyles:{fillColor:[30,42,74],fontSize:8.5,fontStyle:'bold',textColor:255,halign:'center'},
    bodyStyles:{fontSize:8.5,textColor:40},
    alternateRowStyles:{fillColor:[248,250,255]},
    styles:{overflow:'linebreak',cellPadding:2},
    columnStyles:{
      0:{halign:'center'},
      4:{halign:'center'},
      5:{halign:'right'},
      6:{halign:'right'},
      7:{halign:'center'},
    },
    tableWidth:'auto',
    margin:{left:14,right:14},
    didDrawPage: function(data) {
      const pages=doc.internal.getNumberOfPages();
      const pg=doc.internal.getCurrentPageInfo().pageNumber;
      doc.setFontSize(7.5); doc.setTextColor(150);
      doc.text('Hal. '+pg+'/'+pages+' — Bengkel Anton Motor',148,doc.internal.pageSize.height-6,{align:'center'});
    }
  });

  doc.save('laporan_penjualan_'+new Date().toISOString().slice(0,10)+'.pdf');
  showToast('PDF berhasil didownload');
}

// ── Cetak laporan dengan format khusus (tanpa dialog save, langsung print) ──
function cetakLaporan() {
  const semua = @json($pdfData);
  if(!semua.length){showToast('Tidak ada data','#C27803');return;}
  const periode      = '{{ request("dari") ? \Carbon\Carbon::parse(request("dari"))->format("d M Y")." s/d ".\Carbon\Carbon::parse(request("hingga"))->format("d M Y") : "Semua Periode" }}';
  const filterJenis  = '{{ request("jenis")  ? ucfirst(request("jenis"))  : "Semua Jenis" }}';
  const filterMetode = '{{ request("metode") ? request("metode")          : "Semua Metode" }}';
  const tglCetak     = new Date().toLocaleDateString('id-ID',{day:'2-digit',month:'long',year:'numeric'});
  const totalVal     = {{ $ringkasan['total_jual'] }};
  const rataVal      = {{ $ringkasan['rata_rata'] }};

  const{jsPDF}=window.jspdf;
  const doc=new jsPDF({orientation:'landscape',unit:'mm',format:'a4'});
  doc.setFontSize(16);doc.setFont(undefined,'bold');doc.setTextColor(30,42,74);
  doc.text('BENGKEL ANTON MOTOR',148,12,{align:'center'});
  doc.setFontSize(10);doc.setFont(undefined,'normal');doc.setTextColor(80);
  doc.text('Jl. Tuanku Nan Renceh, Lubuk Basung, Kab. Agam, Sumatera Barat',148,18,{align:'center'});
  doc.text('Telp: 0813-6324-2276',148,23,{align:'center'});
  doc.setDrawColor(30,42,74);doc.setLineWidth(0.5);doc.line(14,26,283,26);
  doc.setFontSize(13);doc.setFont(undefined,'bold');doc.setTextColor(30,42,74);
  doc.text('LAPORAN PENJUALAN',148,32,{align:'center'});
  doc.setFontSize(8);doc.setFont(undefined,'normal');doc.setTextColor(100);
  doc.text('Periode : '+periode,14,38);
  doc.text('Jenis   : '+filterJenis,14,43);
  doc.text('Metode  : '+filterMetode,14,48);
  doc.text('Total Transaksi: '+semua.length+' transaksi',148,38,{align:'center'});
  doc.text('Dicetak : '+tglCetak,283,38,{align:'right'});
  doc.text('Total Penjualan: Rp '+totalVal.toLocaleString('id-ID'),283,43,{align:'right'});
  doc.text('Rata-rata/Trx  : Rp '+rataVal.toLocaleString('id-ID'),283,48,{align:'right'});
  doc.setDrawColor(200);doc.setLineWidth(0.3);doc.line(14,51,283,51);
  doc.autoTable({
    startY:54,
    head:[['No','Tanggal','No Transaksi','Jenis','Jumlah Item','Retur','Total','Metode']],
    body:semua.map((t,i)=>[i+1,t.tanggal,t.no_trx,t.jenis,t.jumlah_item,t.retur,t.total,t.metode]),
    headStyles:{fillColor:[30,42,74],fontSize:8.5,fontStyle:'bold',textColor:255,halign:'center'},
    bodyStyles:{fontSize:8.5,textColor:40},
    alternateRowStyles:{fillColor:[248,250,255]},
    styles:{overflow:'linebreak',cellPadding:2},
    columnStyles:{
      0:{halign:'center'},
      4:{halign:'center'},
      5:{halign:'right'},
      6:{halign:'right'},
      7:{halign:'center'},
    },
    tableWidth:'auto',
    margin:{left:14,right:14},
    didDrawPage:function(data){
      const pages=doc.internal.getNumberOfPages();
      const pg=doc.internal.getCurrentPageInfo().pageNumber;
      doc.setFontSize(7.5);doc.setTextColor(150);
      doc.text('Hal. '+pg+'/'+pages+' — Bengkel Anton Motor',148,doc.internal.pageSize.height-6,{align:'center'});
    }
  });

  const blob = doc.output('blob');
  const url  = URL.createObjectURL(blob);
  let iframe = document.getElementById('__pdfPrintFrame');
  if (!iframe) {
    iframe = document.createElement('iframe');
    iframe.id = '__pdfPrintFrame';
    iframe.style.cssText = 'position:fixed;width:0;height:0;border:none;opacity:0;top:-9999px;left:-9999px;';
    document.body.appendChild(iframe);
  }
  iframe.src = url;
  iframe.onload = function() {
    setTimeout(function() {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
      setTimeout(function(){ URL.revokeObjectURL(url); }, 3000);
    }, 300);
  };
}
</script>
@endsection