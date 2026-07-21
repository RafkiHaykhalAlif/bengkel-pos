@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('head')
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
@endsection
@section('styles')
  .page-title{font-size:22px;font-weight:800;color:var(--text-main);margin-bottom:24px;}
  .filter-card{background:var(--white);border-radius:12px;border:1px solid var(--border);padding:20px 24px;margin-bottom:20px;box-shadow:0 2px 6px rgba(0,0,0,0.04);}
  .section-label{font-size:13.5px;font-weight:700;color:var(--text-main);margin-bottom:12px;display:flex;align-items:center;gap:8px;}
  .section-label::before{content:'';width:3px;height:14px;background:var(--primary);border-radius:99px;}
  .filter-row{display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto;gap:12px;align-items:end;}
  .filter-group label{display:block;font-size:11.5px;font-weight:600;color:var(--text-sub);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;}
  .filter-group input,.filter-group select{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;font-size:13.5px;font-family:inherit;color:var(--text-main);background:#F8FAFF;outline:none;transition:border-color 0.2s;}
  .filter-group input:focus,.filter-group select:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(26,86,219,0.10);background:var(--white);}
  .btn-cari{padding:10px 22px;background:var(--primary-dark);color:#fff;font-size:13.5px;font-weight:700;font-family:inherit;border:none;border-radius:8px;cursor:pointer;display:flex;align-items:center;gap:6px;white-space:nowrap;transition:background 0.2s,transform 0.15s;box-shadow:0 4px 12px rgba(26,86,219,0.25);}
  .btn-cari:hover{background:var(--primary);transform:translateY(-1px);}
  .table-card{background:var(--white);border-radius:12px;border:1px solid var(--border);overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,0.04);margin-bottom:16px;}
  .table-card-header{padding:16px 20px;border-bottom:1px solid #EEF2FF;display:flex;align-items:center;justify-content:space-between;}
  .table-card-title{font-size:14px;font-weight:700;color:var(--text-main);display:flex;align-items:center;gap:8px;}
  .table-card-title::before{content:'';width:3px;height:14px;background:var(--primary);border-radius:99px;display:inline-block;}
  .table-badge{font-size:11.5px;font-weight:600;background:var(--bg);color:var(--primary-dark);padding:3px 10px;border-radius:20px;border:1px solid var(--border);}
  table{width:100%;border-collapse:collapse;}
  thead tr{background:var(--header-bg);}
  thead th{padding:12px 16px;text-align:left;font-size:11.5px;font-weight:600;color:rgba(255,255,255,0.85);letter-spacing:0.05em;text-transform:uppercase;}
  tbody tr{border-bottom:1px solid #EEF2FF;transition:background 0.15s;}
  tbody tr:last-child{border-bottom:none;}
  tbody tr:hover{background:#F5F8FF;}
  tbody td{padding:12px 16px;font-size:13.5px;color:var(--text-main);}
  .td-sub{color:var(--text-sub);font-size:12.5px;}
  .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11.5px;font-weight:600;white-space:nowrap;}
  .badge-eceran{background:#EBF2FF;color:#1E429F;}
  .badge-grosir{background:#E0F2FE;color:#0369A1;}
  .badge-servis{background:var(--warning-light);color:var(--warning);}
  .badge-retur{background:var(--danger-light);color:var(--danger);}
  .badge-selesai{background:var(--success-light);color:var(--success);}
  .aksi-row{display:flex;gap:6px;flex-wrap:nowrap;}
  .btn-detail{padding:5px 12px;background:var(--bg);color:var(--primary-dark);border:1.5px solid var(--border);border-radius:6px;font-size:12px;font-weight:600;font-family:inherit;cursor:pointer;transition:background 0.2s;white-space:nowrap;text-decoration:none;display:inline-flex;align-items:center;}
  .btn-detail:hover{background:var(--primary-dark);color:#fff;border-color:var(--primary-dark);}
  .btn-retur{padding:5px 12px;background:var(--danger-light);color:var(--danger);border:1.5px solid #FECACA;border-radius:6px;font-size:12px;font-weight:600;font-family:inherit;cursor:pointer;transition:background 0.2s;white-space:nowrap;}
  .btn-retur:hover{background:var(--danger);color:#fff;border-color:var(--danger);}
  .btn-retur:disabled{opacity:0.4;cursor:not-allowed;}
  /* Modal Retur */
  .modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,25,60,0.45);backdrop-filter:blur(4px);z-index:200;align-items:center;justify-content:center;padding:24px;}
  .modal-overlay.show{display:flex;}
  .modal-retur{background:var(--white);width:600px;max-height:90vh;border-radius:16px;overflow:hidden;display:flex;flex-direction:column;box-shadow:0 16px 48px rgba(0,0,0,0.2);animation:fadeUp 0.3s ease both;}
  @keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
  .modal-retur-header{background:var(--header-bg);padding:18px 24px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;}
  .modal-retur-title{font-size:16px;font-weight:800;color:#fff;display:flex;align-items:center;gap:10px;}
  .modal-retur-sub{font-size:12px;color:rgba(255,255,255,0.65);font-weight:500;margin-top:3px;}
  .btn-close-modal{padding:0 12px;height:34px;background:rgba(255,255,255,0.12);border:none;border-radius:8px;color:#fff;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;transition:background 0.2s;}
  .btn-close-modal:hover{background:rgba(255,255,255,0.22);}
  .modal-retur-body{padding:24px;overflow-y:auto;flex:1;}
  .retur-info-bar{background:#FEF2F2;border:1px solid #FECACA;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:12.5px;color:var(--danger);font-weight:600;display:flex;align-items:center;gap:8px;}
  .retur-table-wrap{border:1px solid #EEF2FF;border-radius:10px;overflow:hidden;margin-bottom:20px;}
  .retur-table-wrap table thead tr{background:var(--header-bg);}
  .retur-table-wrap table thead th{padding:10px 14px;font-size:11px;font-weight:600;color:rgba(255,255,255,0.85);text-transform:uppercase;}
  .retur-table-wrap table tbody tr{border-bottom:1px solid #EEF2FF;}
  .retur-table-wrap table tbody tr:last-child{border-bottom:none;}
  .retur-table-wrap table tbody td{padding:10px 14px;font-size:13px;color:var(--text-main);vertical-align:middle;}
  .retur-table-wrap table tbody tr.selected{background:#FEF2F2;}
  .retur-check{width:16px;height:16px;cursor:pointer;accent-color:var(--danger);}
  .qty-retur{width:60px;padding:5px 8px;border:1.5px solid var(--border);border-radius:6px;font-size:13px;font-family:inherit;text-align:center;outline:none;}
  .qty-retur:focus{border-color:var(--danger);box-shadow:0 0 0 3px rgba(220,38,38,0.1);}
  .qty-retur:disabled{background:#F3F4F6;color:#9CA3AF;}
  .retur-summary{background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:14px 18px;margin-bottom:20px;}
  .retur-summary-row{display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px;color:var(--text-sub);}
  .retur-summary-row:last-child{margin-bottom:0;font-weight:800;font-size:14px;color:var(--danger);}
  .retur-summary-row span:last-child{font-weight:700;color:var(--text-main);}
  .retur-summary-row:last-child span:last-child{color:var(--danger);}
  .modal-retur-footer{padding:16px 24px;border-top:1px solid #EEF2FF;display:flex;gap:10px;justify-content:flex-end;flex-shrink:0;}
  .btn-retur-semua{padding:10px 20px;background:#FEF2F2;color:var(--danger);border:1.5px solid #FECACA;border-radius:8px;font-size:13px;font-weight:700;font-family:inherit;cursor:pointer;transition:background 0.2s;}
  .btn-retur-semua:hover{background:var(--danger);color:#fff;}
  .btn-konfirm-retur{padding:10px 24px;background:var(--danger);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;font-family:inherit;cursor:pointer;transition:background 0.2s,transform 0.15s;box-shadow:0 4px 12px rgba(220,38,38,0.3);}
  .btn-konfirm-retur:hover{background:#B91C1C;transform:translateY(-1px);}
  .btn-batal-retur{padding:10px 20px;background:var(--white);color:var(--text-main);border:1.5px solid var(--border);border-radius:8px;font-size:13px;font-weight:600;font-family:inherit;cursor:pointer;}
  .toast-box{position:fixed;bottom:28px;right:28px;z-index:9999;}
  .toast{padding:13px 20px;border-radius:10px;font-size:13px;font-weight:700;color:#fff;box-shadow:0 4px 16px rgba(0,0,0,0.15);margin-top:8px;animation:toastIn 0.3s ease;}
  @keyframes toastIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}

  /* ── Tablet (≤900px) ── */
  @media(max-width:900px){
    .filter-row{grid-template-columns:1fr 1fr;}
  }

  /* ── Mobile (≤640px) ── */
  @media(max-width:640px){
    .page-title{font-size:18px;margin-bottom:16px;}
    .filter-card{padding:14px 14px;}
    .filter-row{grid-template-columns:1fr;gap:8px;}
    .btn-cari{width:100%;justify-content:center;}
    .table-card{overflow-x:auto;}
    table{min-width:600px;}
    .table-card-header{padding:12px 14px;flex-wrap:wrap;gap:6px;}
    thead th{padding:10px 12px;font-size:10.5px;}
    tbody td{padding:10px 12px;font-size:12.5px;}
    .aksi-row{flex-wrap:wrap;gap:4px;}
    .btn-detail,.btn-retur{padding:5px 10px;font-size:11.5px;}
    .modal-retur{width:calc(100vw - 24px);}
    .modal-retur-body{padding:16px;}
    .modal-retur-footer{padding:12px 16px;flex-wrap:wrap;}
    .btn-konfirm-retur,.btn-retur-semua,.btn-batal-retur{flex:1;text-align:center;padding:10px 12px;}
    .toast-box{bottom:16px;right:12px;left:12px;}
    .toast{font-size:12.5px;}
  }
@endsection

@section('content')
<div class="toast-box" id="toastBox"></div>
<div class="page-title">Riwayat Transaksi</div>

{{-- Filter --}}
<div class="filter-card">
  <div class="section-label">Filter &amp; Pencarian</div>
  <form method="GET" action="{{ route('transaksi.index') }}">
    <div class="filter-row">
      <div class="filter-group">
        <label>Tanggal Mulai</label>
        <input type="date" name="dari" value="{{ request('dari') }}" />
      </div>
      <div class="filter-group">
        <label>Tanggal Selesai</label>
        <input type="date" name="hingga" value="{{ request('hingga') }}" />
      </div>
      <div class="filter-group">
        <label>No Transaksi</label>
        <input type="text" name="no" value="{{ request('no') }}" placeholder="Cari no transaksi..." />
      </div>
      <div class="filter-group">
        <label>Jenis Transaksi</label>
        <select name="jenis">
          <option value="">Semua</option>
          <option value="eceran"  {{ request('jenis')==='eceran'  ? 'selected' : '' }}>Sparepart Eceran</option>
          <option value="grosir"  {{ request('jenis')==='grosir'  ? 'selected' : '' }}>Sparepart Grosir</option>
          <option value="servis"  {{ request('jenis')==='servis'  ? 'selected' : '' }}>Servis</option>
        </select>
      </div>
      <button type="submit" class="btn-cari">Cari</button>
    </div>
  </form>
</div>

{{-- Tabel --}}
<div class="table-card">
  <div class="table-card-header">
    <div class="table-card-title">List Transaksi</div>
    <span class="table-badge">{{ $transaksi->total() }} data</span>
  </div>
  <table>
    <thead>
      <tr>
        <th>No Transaksi</th><th>Tanggal</th><th>Jam</th>
        <th>Total</th><th>Metode</th><th>Jenis Transaksi</th>
        <th>Status</th><th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($transaksi as $t)
      <tr>
        <td><strong>{{ $t->no_transaksi }}</strong><br><span class="td-sub">{{ $t->user->name ?? '-' }}</span></td>
        <td>{{ $t->tanggal_transaksi->format('d M Y') }}</td>
        <td>{{ $t->tanggal_transaksi->format('H:i') }}</td>
        <td>
          @php $nilaiRetur = $t->detailTransaksi->sum(fn($d) => $d->qty_retur * $d->harga_satuan); @endphp
          <strong>Rp {{ number_format($t->total - $nilaiRetur,0,',','.') }}</strong>
          @if($nilaiRetur > 0)
            <div style="font-size:11px;color:var(--danger);font-weight:600;">Retur -Rp {{ number_format($nilaiRetur,0,',','.') }}</div>
          @endif
        </td>
        <td>{{ $t->metode_bayar }}</td>
        <td>
          @if($t->jenis === 'eceran')
            <span class="badge badge-eceran">Sparepart Eceran</span>
          @elseif($t->jenis === 'grosir')
            <span class="badge badge-grosir">Sparepart Grosir</span>
          @else
            <span class="badge badge-servis">Servis</span>
          @endif
        </td>
        <td>
          @if($t->status === 'diretur')
            <span class="badge badge-retur">Diretur</span>
          @else
            <span class="badge badge-selesai">Selesai</span>
          @endif
        </td>
        <td>
          <div class="aksi-row">
            <a class="btn-detail" href="{{ route('transaksi.show', $t->id) }}">Detail</a>
            @php $sisaRetur = $t->detailTransaksi->sum(fn($d) => $d->qty - $d->qty_retur); @endphp
            <button class="btn-retur" {{ $sisaRetur <= 0 ? 'disabled' : '' }}
              onclick="bukaRetur({{ $t->id }}, '{{ $t->no_transaksi }}')">Retur</button>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="8" style="padding:32px;text-align:center;color:var(--text-sub);">Tidak ada data transaksi.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Pagination --}}
<div style="display:flex;justify-content:flex-end;gap:6px;">
  {{ $transaksi->withQueryString()->links('vendor.pagination.custom') }}
</div>

{{-- Modal Retur --}}
<div class="modal-overlay" id="modalReturOverlay">
  <div class="modal-retur">
    <div class="modal-retur-header">
      <div>
        <div class="modal-retur-title">Retur Transaksi</div>
        <div class="modal-retur-sub" id="returSubjudul">Pilih item yang ingin diretur</div>
      </div>
      <button class="btn-close-modal" onclick="tutupRetur()">Tutup</button>
    </div>
    <div class="modal-retur-body">
      <div class="retur-info-bar">Centang barang yang ingin diretur dan atur jumlah retur. Stok akan dikembalikan ke inventaris.</div>
      <div class="retur-table-wrap">
        <table>
          <thead><tr>
            <th style="width:36px;text-align:center;">Pilih</th>
            <th>Nama Barang</th>
            <th style="text-align:center;">Dibeli</th>
            <th style="text-align:center;">Jml Retur</th>
            <th style="text-align:right;">Nilai Retur</th>
          </tr></thead>
          <tbody id="returItemBody"></tbody>
        </table>
      </div>
      <div class="retur-summary">
        <div class="retur-summary-row"><span>Item dipilih</span><span id="returItemCount">0 item</span></div>
        <div class="retur-summary-row"><span>Total Nilai Retur</span><span id="returNilai">Rp 0</span></div>
      </div>
    </div>
    <div class="modal-retur-footer">
      <button class="btn-retur-semua" onclick="pilihSemua()">Pilih Semua</button>
      <button class="btn-batal-retur" onclick="tutupRetur()">Batal</button>
      <button class="btn-konfirm-retur" onclick="konfirmasiRetur()">Proses Retur</button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
let returTrxId = null;

// ── Fungsi untuk menampilkan toast notification ──
function showToast(msg, color='#057A55') {
  const c=document.getElementById('toastBox');
  const t=document.createElement('div');
  t.className='toast';t.style.background=color;t.innerHTML=msg;
  c.appendChild(t);setTimeout(()=>t.remove(),3500);
}

// ── Buka modal retur dan load data item dari transaksi ──
function bukaRetur(trxId, noTrx) {
  returTrxId = trxId;
  document.getElementById('returSubjudul').textContent = noTrx + ' · Pilih item yang ingin diretur';
  document.getElementById('returItemBody').innerHTML = '<tr><td colspan="5" style="padding:20px;text-align:center;color:var(--text-sub);">Memuat data...</td></tr>';
  document.getElementById('modalReturOverlay').classList.add('show');

  fetch(`/transaksi/${trxId}`, { headers:{'Accept':'application/json','X-CSRF-TOKEN':CSRF} })
    .then(r=>r.json()).then(data => {
      const items = data.detail_transaksi || data.detailTransaksi || [];
      if (!items.length) {
        document.getElementById('returItemBody').innerHTML='<tr><td colspan="5" style="padding:20px;text-align:center;">Tidak ada item.</td></tr>';
        return;
      }
      // Filter hanya item yang masih bisa diretur
      const itemsBisaRetur = items.filter(item => (item.qty - (item.qty_retur || 0)) > 0);
      if (!itemsBisaRetur.length) {
        document.getElementById('returItemBody').innerHTML='<tr><td colspan="5" style="padding:20px;text-align:center;color:var(--text-sub);">Semua item sudah diretur.</td></tr>';
        updateReturSummary();
        return;
      }
      document.getElementById('returItemBody').innerHTML = itemsBisaRetur.map(item => {
        const sisaQty = item.qty - (item.qty_retur || 0);
        return `
        <tr id="retur-row-${item.id}">
          <td style="text-align:center;">
            <input type="checkbox" class="retur-check" id="chk-${item.id}"
              data-id="${item.id}" data-harga="${item.harga_satuan}" data-qty="${sisaQty}"
              onchange="toggleReturRow(this)" />
          </td>
          <td>${item.barang?.nama_barang ?? '-'}<br><small style="color:#9CA3AF;">Diretur: ${item.qty_retur || 0}/${item.qty}</small></td>
          <td style="text-align:center;">${sisaQty}</td>
          <td style="text-align:center;">
            <input type="number" class="qty-retur" id="qtyRetur-${item.id}"
              value="1" min="1" max="${sisaQty}" disabled
              oninput="updateReturSummary()" />
          </td>
          <td style="text-align:right;" id="nilaiRetur-${item.id}">Rp 0</td>
        </tr>`;
      }).join('');
      updateReturSummary();
    });
}

// ── Toggle state baris item retur saat checkbox diubah ──
function toggleReturRow(chk) {
  const row = document.getElementById('retur-row-'+chk.dataset.id);
  const qtyInput = document.getElementById('qtyRetur-'+chk.dataset.id);
  row.classList.toggle('selected', chk.checked);
  qtyInput.disabled = !chk.checked;
  updateReturSummary();
}

// ── Fungsi untuk memilih semua item retur sekaligus ──
function pilihSemua() {
  document.querySelectorAll('.retur-check').forEach(chk => {
    chk.checked = true;
    const row = document.getElementById('retur-row-'+chk.dataset.id);
    const qtyInput = document.getElementById('qtyRetur-'+chk.dataset.id);
    row.classList.add('selected');
    qtyInput.disabled = false;
  });
  updateReturSummary();
}

// ── Update ringkasan retur (jumlah item dan total nilai) saat checkbox atau input jumlah retur diubah ──
function updateReturSummary() {
  let total=0, count=0;
  document.querySelectorAll('.retur-check:checked').forEach(chk => {
    const qty = parseInt(document.getElementById('qtyRetur-'+chk.dataset.id).value)||0;
    const nilai = qty * parseInt(chk.dataset.harga);
    total += nilai; count++;
    document.getElementById('nilaiRetur-'+chk.dataset.id).textContent = 'Rp '+nilai.toLocaleString('id-ID');
  });
  document.querySelectorAll('.retur-check:not(:checked)').forEach(chk => {
    document.getElementById('nilaiRetur-'+chk.dataset.id).textContent = 'Rp 0';
  });
  document.getElementById('returItemCount').textContent = count+' item';
  document.getElementById('returNilai').textContent = 'Rp '+total.toLocaleString('id-ID');
}

// ── Kirim data retur ke server untuk diproses saat tombol konfirmasi diklik ──
function konfirmasiRetur() {
  const items = [];
  document.querySelectorAll('.retur-check:checked').forEach(chk => {
    const qty = parseInt(document.getElementById('qtyRetur-'+chk.dataset.id).value)||0;
    if (qty > 0) items.push({ detail_id: parseInt(chk.dataset.id), qty_retur: qty });
  });
  if (!items.length) { showToast('Pilih minimal satu item untuk diretur','#C27803'); return; }

  fetch('/transaksi/retur', {
    method:'POST',
    headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
    body: JSON.stringify({ transaksi_id: returTrxId, items })
  })
  .then(r=>r.json()).then(data => {
    if (data.success) {
      tutupRetur();
      showToast('Retur berhasil diproses!');
      setTimeout(()=>location.reload(),1500);
    } else {
      showToast(data.message,'#DC2626');
    }
  });
}

// ── Tutup modal retur ──
function tutupRetur() { document.getElementById('modalReturOverlay').classList.remove('show'); }

// ── Tutup modal retur saat klik di luar modal (pada overlay) ──
document.getElementById('modalReturOverlay').addEventListener('click', function(e) {
  if (e.target===this) tutupRetur();
});
</script>
@endsection