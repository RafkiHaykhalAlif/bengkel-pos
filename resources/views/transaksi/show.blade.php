@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('head')
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
@endsection
@section('styles')
  .main-center{flex:1;padding:36px 32px;display:flex;align-items:flex-start;justify-content:center;}
  .modal-card{background:var(--white);width:680px;border-radius:16px;border:1px solid var(--border);box-shadow:0 8px 32px rgba(26,86,219,0.12),0 2px 8px rgba(0,0,0,0.06);overflow:hidden;animation:fadeUp 0.35s ease both;}
  @keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
  .modal-header{background:var(--header-bg);padding:20px 28px;display:flex;align-items:center;justify-content:space-between;}
  .modal-header-title{font-size:17px;font-weight:800;color:#fff;display:flex;align-items:center;gap:10px;}
  .modal-header-icon{width:34px;height:34px;background:rgba(255,255,255,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;}
  .modal-header-badge{font-size:12px;font-weight:600;background:rgba(255,255,255,0.12);color:rgba(255,255,255,0.85);padding:4px 12px;border-radius:20px;border:1px solid rgba(255,255,255,0.15);}
  .modal-body{padding:28px 28px 24px;}
  .info-grid{display:grid;grid-template-columns:1fr 1fr;margin-bottom:24px;border:1px solid #EEF2FF;border-radius:10px;overflow:hidden;}
  .info-row{display:flex;flex-direction:column;padding:14px 18px;border-bottom:1px solid #EEF2FF;background:#FAFBFF;}
  .info-row:nth-child(odd){border-right:1px solid #EEF2FF;}
  .info-row:nth-last-child(-n+2){border-bottom:none;}
  .info-label{font-size:11px;font-weight:600;color:var(--text-sub);text-transform:uppercase;letter-spacing:0.07em;margin-bottom:4px;}
  .info-value{font-size:14px;font-weight:700;color:var(--text-main);}
  .badge-success{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;background:var(--success-light);color:var(--success);width:fit-content;}
  .badge-retur{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;background:var(--danger-light);color:var(--danger);width:fit-content;}
  .section-label{font-size:13.5px;font-weight:700;color:var(--text-main);margin-bottom:12px;display:flex;align-items:center;gap:8px;}
  .section-label::before{content:'';width:3px;height:14px;background:var(--primary);border-radius:99px;}
  .item-table-wrap{border:1px solid #EEF2FF;border-radius:10px;overflow:hidden;margin-bottom:20px;}
  table{width:100%;border-collapse:collapse;}
  thead tr{background:var(--header-bg);}
  thead th{padding:11px 14px;text-align:left;font-size:11.5px;font-weight:600;color:rgba(255,255,255,0.85);text-transform:uppercase;}
  tbody tr{border-bottom:1px solid #EEF2FF;}
  tbody tr:last-child{border-bottom:none;}
  tbody tr:hover{background:#F5F8FF;}
  tbody td{padding:11px 14px;font-size:13.5px;color:var(--text-main);}
  tbody td.retur-row{background:#FFF5F5;}
  .retur-tag{font-size:10.5px;font-weight:700;background:var(--danger-light);color:var(--danger);padding:2px 7px;border-radius:20px;margin-left:6px;}
  .total-row{display:flex;justify-content:flex-end;align-items:center;gap:16px;padding:14px 18px;background:#F0F4FF;border:1px solid var(--border);border-radius:10px;margin-bottom:24px;}
  .total-label{font-size:13.5px;font-weight:600;color:var(--text-sub);}
  .total-value{font-size:18px;font-weight:800;color:var(--primary-dark);}
  .retur-section{border:1.5px solid #FECACA;border-radius:12px;overflow:hidden;margin-bottom:20px;}
  .retur-section-header{background:#FEF2F2;padding:12px 18px;display:flex;align-items:center;gap:8px;border-bottom:1px solid #FECACA;}
  .retur-section-title{font-size:13px;font-weight:700;color:var(--danger);}
  .retur-section-sub{font-size:11.5px;color:#EF4444;font-weight:500;margin-left:auto;}
  .retur-table tbody tr{border-bottom:1px solid #FEE2E2;}
  .retur-table tbody tr:last-child{border-bottom:none;}
  .retur-table thead tr{background:#DC2626;}
  .retur-table tbody tr:hover{background:#FFF5F5;}
  .retur-table tbody td{padding:10px 14px;font-size:13px;}
  .divider{height:1px;background:#EEF2FF;margin-bottom:20px;}
  .action-row{display:flex;gap:12px;}
  .btn-cetak{padding:11px 28px;background:var(--primary-dark);color:#fff;font-size:14px;font-weight:700;font-family:inherit;border:none;border-radius:8px;cursor:pointer;display:flex;align-items:center;gap:8px;box-shadow:0 4px 12px rgba(26,86,219,0.28);transition:background 0.2s,transform 0.15s;}
  .btn-cetak:hover{background:var(--primary);transform:translateY(-1px);}
  .btn-tutup{padding:11px 28px;background:var(--white);color:var(--text-main);font-size:14px;font-weight:600;font-family:inherit;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;}
  .btn-tutup:hover{background:#F3F4F6;}
  /* Struk */
  .struk-overlay{display:none;position:fixed;inset:0;background:rgba(15,25,60,0.55);backdrop-filter:blur(4px);z-index:300;align-items:center;justify-content:center;padding:24px;}
  .struk-overlay.show{display:flex;}
  .struk-modal-wrap{display:flex;flex-direction:column;align-items:center;animation:strukanim 0.3s ease both;}
  @keyframes strukanim{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
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
  .struk-footer{text-align:center;margin-top:6px;}
  .struk-footer .simpan-note{font-size:7.5px;color:#555;line-height:1.5;margin-bottom:3px;}
  .struk-footer .terima-kasih{font-size:9px;font-weight:bold;color:#000;}
  .struk-action-row{display:flex;gap:10px;margin-top:10px;width:240px;}
  .btn-struk-print{flex:1;padding:11px;background:#1E429F;color:#fff;font-size:13px;font-weight:700;font-family:inherit;border:none;border-radius:8px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;}
  .btn-struk-close{flex:1;padding:11px;background:#fff;color:#111827;font-size:13px;font-weight:600;font-family:inherit;border:1.5px solid #C7D4F0;border-radius:8px;cursor:pointer;}
  @media print{
    body > *:not(#strukPrintContainer) { display:none !important; }
    #strukPrintContainer { display:block !important; font-family:Arial,Helvetica,sans-serif; font-size:9pt; color:#000; padding-bottom:8px; width:52mm; }
    @page { margin:4mm 3mm 6mm; }
  }

  /* ── Tablet (≤900px) ── */
  @media(max-width:900px){
    .modal-card{width:100%;}
    .info-grid{grid-template-columns:1fr;}
  }

  /* ── Mobile (≤640px) ── */
  @media(max-width:640px){
    .modal-card{width:100%;border-radius:0;}
    .modal-header{padding:14px 16px;}
    .modal-header-title{font-size:14px;}
    .modal-body{padding:16px;}
    .info-grid{grid-template-columns:1fr;border-radius:8px;}
    .info-row{padding:10px 14px;}
    .info-row:nth-child(odd){border-right:none;border-bottom:1px solid #EEF2FF;}
    .item-table-wrap{overflow-x:auto;}
    table{min-width:420px;}
    thead th{padding:9px 10px;font-size:10.5px;}
    tbody td{padding:9px 10px;font-size:12.5px;}
    .total-row{padding:12px 14px;}
    .total-value{font-size:15px;}
    .action-row{flex-direction:column;gap:8px;}
    .btn-cetak,.btn-tutup{width:100%;justify-content:center;text-align:center;}
    .struk-overlay{padding:12px;}
    .struk-action-row{width:calc(100vw - 48px);max-width:300px;}
    .struk-wrap{width:calc(100vw - 64px);max-width:280px;}
    .retur-section{border-radius:8px;}
  }
@endsection

@php
  $jenisLabel = ['eceran'=>'Sparepart Eceran','grosir'=>'Sparepart Grosir','servis'=>'Servis'];
  $returItems = $transaksi->detailTransaksi->where('qty_retur','>',0);
@endphp

@section('content')
{{-- Container khusus print --}}
<div id="strukPrintContainer" style="display:none;"></div>
<div style="display:flex;align-items:flex-start;justify-content:center;padding:8px 0;">
  <div class="modal-card">
    <div class="modal-header">
      <div class="modal-header-title">
        Detail Transaksi
      </div>
      <span class="modal-header-badge">{{ $transaksi->no_transaksi }}</span>
    </div>

    <div class="modal-body">
      {{-- Info Grid --}}
      <div class="info-grid">
        <div class="info-row">
          <span class="info-label">No. Transaksi</span>
          <span class="info-value">{{ $transaksi->no_transaksi }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Status</span>
          <span class="info-value">
            @if($transaksi->status === 'diretur')
              <span class="badge-retur">Diretur</span>
            @else
              <span class="badge-success">Selesai</span>
            @endif
          </span>
        </div>
        <div class="info-row">
          <span class="info-label">Tanggal</span>
          <span class="info-value">{{ $transaksi->tanggal_transaksi->format('d F Y') }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Jam</span>
          <span class="info-value">{{ $transaksi->tanggal_transaksi->format('H:i') }} WIB</span>
        </div>
        <div class="info-row">
          <span class="info-label">Jenis Transaksi</span>
          <span class="info-value">{{ $jenisLabel[$transaksi->jenis] ?? $transaksi->jenis }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Metode Pembayaran</span>
          <span class="info-value">{{ $transaksi->metode_bayar }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Kasir</span>
          <span class="info-value">{{ $transaksi->user->name ?? '-' }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Biaya Jasa</span>
          <span class="info-value">
            @if($transaksi->detailJasa && $transaksi->detailJasa->count() > 0)
              @foreach($transaksi->detailJasa as $j)
                <div style="font-size:12.5px;color:var(--warning);">{{ $j->keterangan }}: <strong>Rp {{ number_format($j->harga,0,',','.') }}</strong></div>
              @endforeach
            @else
              <span style="{{ $transaksi->biaya_jasa > 0 ? 'color:var(--warning);' : 'color:var(--text-sub);' }}">
                {{ $transaksi->biaya_jasa > 0 ? 'Rp '.number_format($transaksi->biaya_jasa,0,',','.') : '—' }}
              </span>
            @endif
          </span>
        </div>
        <div class="info-row">
          <span class="info-label">Total</span>
          <span class="info-value" style="color:var(--primary-dark);">Rp {{ number_format($transaksi->total,0,',','.') }}</span>
        </div>
      </div>

      {{-- Item Transaksi --}}
      <div class="section-label">Item Transaksi</div>
      <div class="item-table-wrap">
        <table>
          <thead><tr>
            <th>No</th><th>Kode</th><th>Nama Barang</th>
            <th>Harga Satuan</th><th>Qty</th><th>Subtotal</th>
          </tr></thead>
          <tbody>
            @foreach($transaksi->detailTransaksi as $i => $d)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $d->barang->kode_barang ?? '-' }}</td>
              <td>
                {{ $d->barang->nama_barang ?? '-' }}
                @if($d->qty_retur > 0)
                  <span class="retur-tag">retur</span>
                @endif
              </td>
              <td>Rp {{ number_format($d->harga_satuan,0,',','.') }}</td>
              <td>{{ $d->qty }}</td>
              <td><strong>Rp {{ number_format($d->subtotal,0,',','.') }}</strong></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Total Row --}}
      <div class="total-row">
        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
          @if($transaksi->biaya_jasa > 0)
          @if($transaksi->detailTransaksi->count() > 0)
          <div style="display:flex;gap:24px;font-size:13px;">
            <span style="color:var(--text-sub);">Subtotal Barang</span>
            <span style="font-weight:600;">Rp {{ number_format($transaksi->total - $transaksi->biaya_jasa,0,',','.') }}</span>
          </div>
          @endif
          @foreach($transaksi->detailJasa as $j)
          <div style="display:flex;gap:24px;font-size:13px;">
            <span style="color:var(--warning);font-weight:600;">{{ $j->keterangan }}</span>
            <span style="color:var(--warning);font-weight:700;">Rp {{ number_format($j->harga,0,',','.') }}</span>
          </div>
          @endforeach
          <div style="height:1px;width:100%;background:var(--border);margin:2px 0;"></div>
          @endif
          @php
            $nilaiRetur = $returItems->sum(fn($d) => $d->qty_retur * $d->harga_satuan);
          @endphp
          @if($nilaiRetur > 0)
          <div style="display:flex;gap:24px;font-size:13px;">
            <span style="color:var(--text-sub);">Total Bruto</span>
            <span style="font-weight:600;">Rp {{ number_format($transaksi->total,0,',','.') }}</span>
          </div>
          <div style="display:flex;gap:24px;font-size:13px;">
            <span style="color:var(--danger);font-weight:600;">Nilai Retur</span>
            <span style="color:var(--danger);font-weight:700;">− Rp {{ number_format($nilaiRetur,0,',','.') }}</span>
          </div>
          <div style="height:1px;width:100%;background:var(--border);margin:2px 0;"></div>
          <div style="display:flex;gap:24px;">
            <span class="total-label">Total Netto:</span>
            <span class="total-value">Rp {{ number_format($transaksi->total - $nilaiRetur,0,',','.') }}</span>
          </div>
          @else
          <div style="display:flex;gap:24px;">
            <span class="total-label">Total Transaksi:</span>
            <span class="total-value">Rp {{ number_format($transaksi->total,0,',','.') }}</span>
          </div>
          @endif
        </div>
      </div>

      {{-- Section Retur --}}
      @if($returItems->count() > 0)
      <div class="retur-section">
        <div class="retur-section-header">
          <span style="font-size:15px;"></span>
          <span class="retur-section-title">Barang yang Diretur</span>
          <span class="retur-section-sub">{{ $transaksi->updated_at->format('d M Y H:i') }}</span>
        </div>
        <table class="retur-table">
          <thead><tr>
            <th>No</th><th>Kode</th><th>Nama Barang</th>
            <th>Harga Satuan</th><th>Qty Retur</th><th>Nilai Retur</th>
          </tr></thead>
          <tbody>
            @foreach($returItems as $i => $d)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $d->barang->kode_barang ?? '-' }}</td>
              <td class="td-retur-nama">{{ $d->barang->nama_barang ?? '-' }}</td>
              <td>Rp {{ number_format($d->harga_satuan,0,',','.') }}</td>
              <td class="td-retur-qty">{{ $d->qty_retur }}</td>
              <td>Rp {{ number_format($d->qty_retur * $d->harga_satuan,0,',','.') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div style="display:flex;justify-content:flex-end;align-items:center;gap:14px;padding:12px 18px;background:#FFF5F5;border-top:1px solid #FECACA;">
          <span style="font-size:13px;font-weight:600;color:#EF4444;">Total Nilai Retur:</span>
          <span style="font-size:16px;font-weight:800;color:var(--danger);">
            Rp {{ number_format($returItems->sum(fn($d)=>$d->qty_retur*$d->harga_satuan),0,',','.') }}
          </span>
        </div>
      </div>
      @endif

      {{-- Divider --}}
      <div class="divider"></div>

      {{-- Action Buttons --}}
      <div class="action-row">
        <button class="btn-cetak" onclick="bukaStruk()">Cetak Struk</button>
        <a class="btn-tutup" href="{{ route('transaksi.index') }}">Kembali</a>
      </div>
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
        <div class="struk-info">
          <div class="struk-info-row"><span>No. Transaksi</span><span>{{ $transaksi->no_transaksi }}</span></div>
          <div class="struk-info-row"><span>Tanggal</span><span>{{ $transaksi->tanggal_transaksi->format('d M Y') }}</span></div>
          <div class="struk-info-row"><span>Jam</span><span>{{ $transaksi->tanggal_transaksi->format('H:i') }}</span></div>
          <div class="struk-info-row"><span>Jenis</span><span>{{ $jenisLabel[$transaksi->jenis] ?? $transaksi->jenis }}</span></div>
          <div class="struk-info-row"><span>Metode</span><span>{{ $transaksi->metode_bayar }}</span></div>
          <div class="struk-info-row"><span>Kasir</span><span>{{ $transaksi->user->name ?? '-' }}</span></div>
        </div>
        <div class="struk-items">
          <div style="font-size:8.5px;font-weight:bold;margin-bottom:4px;color:#000;">SPAREPART:</div>
          @foreach($transaksi->detailTransaksi as $d)
          @php $qtyNetto = $d->qty - $d->qty_retur; @endphp
          @if($qtyNetto > 0)
          <div class="struk-item">
            <div class="struk-item-name">{{ $d->barang->nama_barang ?? '-' }}</div>
            <div class="struk-item-detail">
              <span>{{ $qtyNetto }} x Rp {{ number_format($d->harga_satuan,0,',','.') }}</span>
              <span>Rp {{ number_format($qtyNetto * $d->harga_satuan,0,',','.') }}</span>
            </div>
            @if($d->qty_retur > 0)
            <div style="font-size:9px;color:#DC2626;margin-top:2px;">
              (diretur: {{ $d->qty_retur }} x Rp {{ number_format($d->harga_satuan,0,',','.') }} = −Rp {{ number_format($d->qty_retur * $d->harga_satuan,0,',','.') }})
            </div>
            @endif
          </div>
          @endif
          @endforeach
          @if($transaksi->detailJasa && $transaksi->detailJasa->count() > 0)
          <div style="margin-top:8px;padding-top:8px;border-top:1px dashed #999;">
            <div style="font-size:8.5px;font-weight:bold;margin-bottom:4px;color:#555;">BIAYA JASA:</div>
            @foreach($transaksi->detailJasa as $j)
            <div class="struk-item" style="display:flex;justify-content:space-between;align-items:center;">
              <div class="struk-item-name" style="font-size:8px;margin-bottom:0;">{{ $j->keterangan }}</div>
              <div style="font-size:8px;font-weight:bold;">Rp {{ number_format($j->harga,0,',','.') }}</div>
            </div>
            @endforeach
          </div>
          @endif
        </div>
        @php
          $nilaiReturOverlay = $transaksi->detailTransaksi->sum(fn($d) => $d->qty_retur * $d->harga_satuan);
          $nettoOverlay = $transaksi->total - $nilaiReturOverlay;
        @endphp
        <div class="struk-total">
          @if($transaksi->biaya_jasa > 0)
          @if($transaksi->detailTransaksi->count() > 0)
          <div class="struk-total-row">
            <span>Subtotal Barang</span>
            <span>Rp {{ number_format($transaksi->total - $transaksi->biaya_jasa,0,',','.') }}</span>
          </div>
          @endif
          @if($transaksi->detailJasa && $transaksi->detailJasa->count() > 0)
          <div class="struk-total-row">
            <span>Subtotal Jasa</span>
            <span>Rp {{ number_format($transaksi->detailJasa->sum('harga'),0,',','.') }}</span>
          </div>
          @endif
          @endif
          @if($nilaiReturOverlay > 0)
          <div class="struk-total-row">
            <span>Total Bruto</span>
            <span>Rp {{ number_format($transaksi->total,0,',','.') }}</span>
          </div>
          <div class="struk-total-row" style="color:#DC2626;">
            <span>Retur</span>
            <span>− Rp {{ number_format($nilaiReturOverlay,0,',','.') }}</span>
          </div>
          @endif
          <div class="struk-total-main">
            <span class="struk-total-main-label">TOTAL</span>
            <span class="struk-total-main-value">Rp {{ number_format($nettoOverlay,0,',','.') }}</span>
          </div>
        </div>
        <div class="struk-footer">
          <div class="simpan-note">Simpan struk ini sebagai<br>bukti pembelian</div>
          <div class="terima-kasih">Terima Kasih!</div>
        </div>
      </div>
      <div class="struk-bottom"></div>
    </div>
    <div class="struk-action-row">
      <button class="btn-struk-print" onclick="cetakStruk()">Cetak Struk</button>
      <button class="btn-struk-close" onclick="document.getElementById('strukOverlay').classList.remove('show')">Kembali</button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
// ── Fungsi untuk membuka modal struk ──
function bukaStruk() { document.getElementById('strukOverlay').classList.add('show'); }

// ── Fungsi untuk menyiapkan konten struk dan memicu print ──
function cetakStruk() {
  @php
    $itemsJs = '<div style="font-size:9pt;font-weight:bold;margin-bottom:3px;">SPAREPART:</div>';
    foreach($transaksi->detailTransaksi as $d) {
      $qtyNetto = $d->qty - $d->qty_retur;
      if($qtyNetto <= 0) continue; 
      $nama  = addslashes($d->barang->nama_barang ?? '-');
      $harga = number_format($d->harga_satuan, 0, ',', '.');
      $sub   = number_format($qtyNetto * $d->harga_satuan, 0, ',', '.');
      $itemsJs .= "<div style=\"font-size:9pt;font-weight:bold;margin-top:6px;\">{$nama}</div>";
      $itemsJs .= "<div style=\"overflow:hidden;margin-top:2px;\"><span style=\"float:left;font-size:8.5pt;\">{$qtyNetto} x Rp {$harga}</span><span style=\"float:right;font-size:9pt;font-weight:bold;\">Rp {$sub}</span></div><div style=\"clear:both;\"></div>";
      if($d->qty_retur > 0) {
        $itemsJs .= "<div style=\"font-size:7.5pt;color:#DC2626;margin-top:1px;\">(sudah diretur: {$d->qty_retur} pcs)</div>";
      }
    }
    $jasaJs = '';
    $nilaiReturStruk = $transaksi->detailTransaksi->sum(fn($d) => $d->qty_retur * $d->harga_satuan);
    $subtotalSparepart = $transaksi->detailTransaksi->sum(fn($d) => ($d->qty - $d->qty_retur) * $d->harga_satuan);
    
    if($transaksi->detailJasa && $transaksi->detailJasa->count() > 0) {
      $jasaJs .= "<hr style=\"border:none;border-top:1px dashed #000;margin:5px 0;\">";
      $jasaJs .= "<div style=\"overflow:hidden;margin-bottom:3px;margin-top:3px;\"><span style=\"float:left;font-size:8.5pt;font-weight:bold;\">BIAYA JASA:</span></div><div style=\"clear:both;\"></div>";
      foreach($transaksi->detailJasa as $j) {
        $jFmt = number_format($j->harga, 0, ',', '.');
        $jasaJs .= "<div style=\"overflow:hidden;margin-bottom:2px;\"><span style=\"float:left;font-size:8pt;\">{$j->keterangan}</span><span style=\"float:right;font-size:8.5pt;font-weight:bold;\">Rp {$jFmt}</span></div><div style=\"clear:both;\"></div>";
      }
      
      // Subtotal Sparepart
      $subtotalSparepartFmt = number_format($subtotalSparepart, 0, ',', '.');
      $jasaJs .= "<hr style=\"border:none;border-top:1px dashed #000;margin:5px 0;\">";
      $jasaJs .= "<div style=\"overflow:hidden;margin-bottom:2px;margin-top:4px;\"><span style=\"float:left;font-size:8.5pt;\">subtotal sparepart</span><span style=\"float:right;font-size:8.5pt;\">Rp {$subtotalSparepartFmt}</span></div><div style=\"clear:both;\"></div>";
      
      // Subtotal Jasa
      $jasaTotalFmt = number_format($transaksi->detailJasa->sum('harga'), 0, ',', '.');
      $jasaJs .= "<div style=\"overflow:hidden;margin-bottom:2px;\"><span style=\"float:left;font-size:8.5pt;\">subtotal Jasa</span><span style=\"float:right;font-size:8.5pt;\">Rp {$jasaTotalFmt}</span></div><div style=\"clear:both;\"></div>";
    } else if($transaksi->biaya_jasa > 0) {
      if($transaksi->detailTransaksi->count() > 0) {
        $subtotalFmt = number_format(max(0, $transaksi->total - $transaksi->biaya_jasa - $nilaiReturStruk), 0, ',', '.');
        $jasaJs .= "<hr style=\"border:none;border-top:1px dashed #000;margin:5px 0;\">";
        $jasaJs .= "<div style=\"overflow:hidden;margin-bottom:3px;\"><span style=\"float:left;font-size:8.5pt;\">Subtotal Barang</span><span style=\"float:right;font-size:8.5pt;font-weight:bold;\">Rp {$subtotalFmt}</span></div><div style=\"clear:both;\"></div>";
      }
    }
  @endphp

  const itemsHtml = `{!! addslashes($itemsJs) !!}`;
  const jasaHtml  = `{!! addslashes($jasaJs) !!}`;

  const container = document.getElementById('strukPrintContainer');
  container.innerHTML = `
    <div style="width:52mm;font-family:Arial,Helvetica,sans-serif;font-size:9pt;color:#000;">
    <p style="font-size:12pt;font-weight:bold;text-align:center;letter-spacing:1px;margin-bottom:3px;">BENGKEL ANTON MOTOR</p>
    <p style="font-size:8pt;text-align:center;margin-bottom:2px;">Jl. Tuanku Nan Renceh, Lubuk Basung</p>
    <p style="font-size:8pt;text-align:center;margin-bottom:2px;">Kab. Agam, Sumatera Barat</p>
    <p style="font-size:8pt;text-align:center;margin-bottom:5px;">Telp: 0813-6324-2276</p>
    <hr style="border:none;border-top:1px dashed #000;margin:5px 0;">
    <div style="width:100%;overflow:hidden;margin-bottom:3px;"><span style="float:left;font-size:8.5pt;">No. Transaksi</span><span style="float:right;font-size:8.5pt;font-weight:bold;">{{ $transaksi->no_transaksi }}</span></div><div style="clear:both;"></div>
    <div style="width:100%;overflow:hidden;margin-bottom:3px;"><span style="float:left;font-size:8.5pt;">Tanggal</span><span style="float:right;font-size:8.5pt;font-weight:bold;">{{ $transaksi->tanggal_transaksi->format('d M Y') }}</span></div><div style="clear:both;"></div>
    <div style="width:100%;overflow:hidden;margin-bottom:3px;"><span style="float:left;font-size:8.5pt;">Jam</span><span style="float:right;font-size:8.5pt;font-weight:bold;">{{ $transaksi->tanggal_transaksi->format('H:i') }}</span></div><div style="clear:both;"></div>
    <div style="width:100%;overflow:hidden;margin-bottom:3px;"><span style="float:left;font-size:8.5pt;">Kasir</span><span style="float:right;font-size:8.5pt;font-weight:bold;">{{ $transaksi->user->name ?? '-' }}</span></div><div style="clear:both;"></div>
    <div style="width:100%;overflow:hidden;margin-bottom:3px;"><span style="float:left;font-size:8.5pt;">Metode</span><span style="float:right;font-size:8.5pt;font-weight:bold;">{{ $transaksi->metode_bayar }}</span></div><div style="clear:both;"></div>
    <hr style="border:none;border-top:1px dashed #000;margin:5px 0;">
    ${itemsHtml}
    ${jasaHtml}
    <div style="width:100%;border-top:1.5px solid #000;border-bottom:1.5px solid #000;padding:6px 0;margin-top:5px;overflow:hidden;">
      <span style="float:left;font-size:11pt;font-weight:bold;">TOTAL</span>
      @php $totalNetto = $transaksi->total - $transaksi->detailTransaksi->sum(fn($d) => $d->qty_retur * $d->harga_satuan); @endphp
      <span style="float:right;font-size:11pt;font-weight:bold;">Rp {{ number_format($totalNetto,0,',','.') }}</span>
    </div>
    <div style="clear:both;"></div>
    <p style="text-align:center;font-size:8pt;margin-top:10px;line-height:1.6;">Simpan struk ini sebagai<br>bukti pembelian</p>
    <p style="text-align:center;font-size:10pt;font-weight:bold;margin-top:5px;">Terima Kasih!</p>
    </div>`;

  container.style.display = 'block';
  document.body.appendChild(container);
  window.onafterprint = function() {
    container.style.display = 'none';
    container.innerHTML = '';
    document.getElementById('strukOverlay').classList.remove('show');
  };
  window.print();
}
</script>
@endsection