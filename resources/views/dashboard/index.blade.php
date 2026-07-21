@extends('layouts.app')
@section('title', 'Dashboard')
@section('head')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
@endsection
@section('styles')
  .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
  .page-title{font-size:20px;font-weight:800;color:var(--text-main);}
  .page-date{font-size:12.5px;color:var(--text-sub);font-weight:500;}
  .filter-tabs{display:flex;gap:4px;background:#E8EEFF;border-radius:8px;padding:3px;}
  .ftab{padding:6px 16px;border-radius:6px;font-size:12.5px;font-weight:600;font-family:inherit;color:var(--text-sub);background:transparent;border:none;cursor:pointer;transition:all 0.2s;text-decoration:none;}
  .ftab.active{background:var(--white);color:var(--primary-dark);box-shadow:0 1px 4px rgba(0,0,0,0.08);}
  .stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;}
  .stat-card{background:var(--white);border-radius:12px;padding:18px 20px;border:1px solid #E8EEFF;box-shadow:0 1px 4px rgba(0,0,0,0.04);position:relative;overflow:hidden;transition:transform 0.2s,box-shadow 0.2s;}
  .stat-card:hover{transform:translateY(-2px);box-shadow:0 6px 18px rgba(26,86,219,0.10);}
  .stat-label{font-size:11px;font-weight:700;color:var(--text-sub);text-transform:uppercase;letter-spacing:0.07em;margin-bottom:8px;}
  .stat-value{font-size:24px;font-weight:800;color:var(--text-main);line-height:1;margin-bottom:8px;}
  .stat-value.sm{font-size:18px;}
  .stat-badge{display:inline-flex;align-items:center;gap:3px;font-size:11px;font-weight:700;padding:2px 7px;border-radius:20px;}
  .stat-badge.up{background:var(--success-light);color:var(--success);}
  .stat-badge.warn{background:var(--warning-light);color:var(--warning);}
  .row-2{display:grid;grid-template-columns:1fr 340px;gap:16px;margin-bottom:16px;}
  .card{background:var(--white);border-radius:12px;border:1px solid #E8EEFF;box-shadow:0 1px 4px rgba(0,0,0,0.04);overflow:hidden;}
  .card-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid #F0F4FF;}
  .card-title{font-size:13.5px;font-weight:700;color:var(--text-main);display:flex;align-items:center;gap:8px;}
  .card-title::before{content:'';width:3px;height:13px;background:var(--primary);border-radius:99px;display:inline-block;}
  .card-body{padding:16px 20px;}
  .chart-wrap{height:230px;}
  .mini-table{width:100%;border-collapse:collapse;}
  .mini-table th{font-size:10.5px;font-weight:700;color:var(--text-sub);text-transform:uppercase;letter-spacing:0.06em;padding:0 0 10px;text-align:left;border-bottom:1px solid #F0F4FF;}
  .mini-table td{padding:10px 0;font-size:12.5px;color:var(--text-main);border-bottom:1px solid #F8F9FF;vertical-align:middle;}
  .mini-table tr:last-child td{border-bottom:none;}
  .mini-table .no-trx{font-size:11.5px;font-weight:700;color:var(--primary);}
  .mini-table .jenis-badge{display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:20px;font-size:11px;font-weight:600;}
  .badge-sparepart{background:#EBF2FF;color:var(--primary-dark);}
  .badge-grosir{background:#E0F2FE;color:#0369A1;}
  .badge-servis{background:var(--warning-light);color:var(--warning);}
  .mini-table .nominal{font-weight:700;color:var(--text-main);text-align:right;font-size:12px;}
  .stok-list{display:flex;flex-direction:column;gap:0;}
  .stok-item{display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid #F8F9FF;}
  .stok-item:last-child{border-bottom:none;}
  .stok-name{font-size:12.5px;font-weight:600;color:var(--text-main);margin-bottom:2px;}
  .stok-code{font-size:11px;color:var(--text-sub);}
  .stok-right{text-align:right;}
  .stok-qty{font-size:14px;font-weight:800;color:var(--danger);}
  .stok-qty.sold{color:var(--primary);}
  .stok-min{font-size:10.5px;color:var(--text-sub);}
  .stok-bar-wrap{margin-top:3px;width:80px;height:4px;background:#F0F4FF;border-radius:99px;overflow:hidden;}
  .stok-bar{height:100%;border-radius:99px;background:var(--danger);}
  .row-bottom{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
  .btn-link{font-size:12px;font-weight:600;color:var(--primary);background:none;border:none;cursor:pointer;font-family:inherit;text-decoration:none;}
  .btn-link:hover{text-decoration:underline;}
  .empty-state{padding:24px;text-align:center;color:var(--text-sub);font-size:13px;}
  .stok-scroll{max-height:280px;overflow-y:auto;padding-right:4px;}
  .stok-scroll::-webkit-scrollbar{width:4px;}
  .stok-scroll::-webkit-scrollbar-track{background:transparent;}
  .stok-scroll::-webkit-scrollbar-thumb{background:#CBD5E1;border-radius:99px;}
  .stok-scroll::-webkit-scrollbar-thumb:hover{background:#94A3B8;}
  .card-scroll{max-height:280px;overflow-y:auto;padding-right:4px;}
  .card-scroll::-webkit-scrollbar{width:4px;}
  .card-scroll::-webkit-scrollbar-track{background:transparent;}
  .card-scroll::-webkit-scrollbar-thumb{background:#CBD5E1;border-radius:99px;}
  .card-scroll::-webkit-scrollbar-thumb:hover{background:#94A3B8;}

  /* ── Tablet (≤900px) ── */
  @media(max-width:900px){
    .stat-grid{grid-template-columns:repeat(2,1fr);}
    .row-2{grid-template-columns:1fr;}
    .row-bottom{grid-template-columns:1fr;}
    .chart-wrap{height:200px;}
  }

  /* ── Mobile (≤640px) ── */
  @media(max-width:640px){
    .page-header{flex-direction:column;align-items:flex-start;gap:8px;margin-bottom:14px;}
    .page-title{font-size:17px;}
    .page-date{font-size:11.5px;}
    .filter-tabs{width:100%;}
    .ftab{flex:1;text-align:center;padding:7px 8px;font-size:12px;}
    .stat-grid{grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:14px;}
    .stat-card{padding:14px 14px;}
    .stat-value{font-size:20px;}
    .stat-value.sm{font-size:15px;}
    .stat-label{font-size:10px;}
    .row-2{gap:12px;margin-bottom:12px;}
    .row-bottom{gap:12px;}
    .card-header{padding:12px 14px;}
    .card-body{padding:12px 14px;}
    .chart-wrap{height:180px;}
    .mini-table th{font-size:10px;padding:0 0 8px;}
    .mini-table td{padding:8px 0;font-size:11.5px;}
    .mini-table .no-trx{font-size:10.5px;}
    .stok-name{font-size:12px;}
    .stok-bar-wrap{width:60px;}
  }
@endsection

@section('content')

{{-- Page Header --}}
<div class="page-header">
  <div class="page-title">Dashboard</div>
  <div style="display:flex;align-items:center;gap:12px;">
    <div class="page-date">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</div>
    <div class="filter-tabs">
      <a class="ftab {{ $filter==='harian'   ? 'active':'' }}" href="{{ route('dashboard',['filter'=>'harian'])   }}">Harian</a>
      <a class="ftab {{ $filter==='mingguan' ? 'active':'' }}" href="{{ route('dashboard',['filter'=>'mingguan']) }}">Mingguan</a>
      <a class="ftab {{ $filter==='bulanan'  ? 'active':'' }}" href="{{ route('dashboard',['filter'=>'bulanan'])  }}">Bulanan</a>
    </div>
  </div>
</div>

{{-- Stat Cards --}}
<div class="stat-grid">
  <div class="stat-card">
    <div class="stat-label">Total Transaksi</div>
    <div class="stat-value">{{ $totalTrx }}</div>
    <span class="stat-badge up">{{ $filter === 'harian' ? 'Hari ini' : ($filter === 'mingguan' ? 'Minggu ini' : 'Bulan ini') }}</span>
  </div>
  <div class="stat-card">
    <div class="stat-label">Total Penjualan</div>
    <div class="stat-value sm">Rp {{ number_format($totalJual,0,',','.') }}</div>
    <span class="stat-badge up">{{ $filter === 'harian' ? 'Hari ini' : ($filter === 'mingguan' ? 'Minggu ini' : 'Bulan ini') }}</span>
  </div>
  <div class="stat-card">
    <div class="stat-label">Total Barang</div>
    <div class="stat-value">{{ $totalBarang }}</div>
    @if($stokMenipisCount > 0)
      <span class="stat-badge warn">{{ $stokMenipisCount }} stok menipis</span>
    @else
      <span class="stat-badge up">Semua aman</span>
    @endif
  </div>
  <div class="stat-card">
    <div class="stat-label">Laba Bersih</div>
    <div class="stat-value sm">Rp {{ number_format($labaBersih,0,',','.') }}</div>
    <span class="stat-badge up">Omzet − Modal</span>
  </div>
</div>

{{-- Grafik Penjualan --}}
<div class="row-2">
  <div class="card">
    <div class="card-header">
      <div class="card-title">Grafik Penjualan</div>
      <span style="font-size:12px;color:var(--text-sub);font-weight:500;">{{ $chartData['subtitle'] }}</span>
    </div>
    <div class="card-body">
      <div class="chart-wrap">
        <canvas id="salesChart"></canvas>
      </div>
    </div>
  </div>

  {{-- Stok Menipis --}}
  <div class="card">
    <div class="card-header">
      <div class="card-title">Stok Menipis</div>
      <a class="btn-link" href="{{ route('inventaris') }}">Lihat Semua</a>
    </div>
    <div class="card-body" style="padding-top:8px;">
      @if(count($stokMenipis) > 0)
      <div class="stok-scroll">
        <div class="stok-list">
          @foreach($stokMenipis as $b)
            @php $pct = $b->min_stok > 0 ? min(100, round($b->stok/$b->min_stok*100)) : 0; @endphp
            <div class="stok-item">
              <div>
                <div class="stok-name">{{ $b->nama_barang }}</div>
                <div class="stok-code">{{ $b->kode_barang }}</div>
              </div>
              <div class="stok-right">
                <div class="stok-qty">{{ $b->stok }} pcs</div>
                <div class="stok-min">Min: {{ $b->min_stok }}</div>
                <div class="stok-bar-wrap"><div class="stok-bar" style="width:{{ $pct }}%"></div></div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      @else
        <div class="empty-state">Semua stok dalam kondisi aman</div>
      @endif
    </div>
  </div>
</div>

{{-- Transaksi Terakhir + Barang Terlaris --}}
<div class="row-bottom">
  <div class="card">
    <div class="card-header">
      <div class="card-title">Transaksi Terakhir</div>
      <a class="btn-link" href="{{ route('transaksi.index') }}">Lihat Semua</a>
    </div>
    <div class="card-body" style="padding-top:4px;">
      @if($transaksiTerakhir->count() > 0)
      <div class="card-scroll">
      <table class="mini-table">
        <thead>
          <tr>
            <th>No. Transaksi</th>
            <th>Jenis</th>
            <th>Waktu</th>
            <th style="text-align:right">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($transaksiTerakhir as $t)
          <tr>
            <td><div class="no-trx">{{ $t->no_transaksi }}</div></td>
            <td>
              @if($t->jenis === 'servis')
                <span class="jenis-badge badge-servis">Servis</span>
              @elseif($t->jenis === 'grosir')
                <span class="jenis-badge badge-grosir">Grosir</span>
              @else
                <span class="jenis-badge badge-sparepart">Sparepart</span>
              @endif
            </td>
            <td style="color:var(--text-sub);font-size:12px;">{{ $t->tanggal_transaksi->format('H:i') }}</td>
            <td class="nominal">Rp {{ number_format($t->total_netto,0,',','.') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      </div>
      @else
        <div class="empty-state">Belum ada transaksi hari ini</div>
      @endif
    </div>
  </div>

  {{-- Barang Terlaris --}}
  <div class="card">
    <div class="card-header">
      <div class="card-title">Barang Terlaris</div>
      <a class="btn-link" href="{{ route('laporan.penjualan') }}">Lihat Laporan</a>
    </div>
    <div class="card-body" style="padding-top:8px;">
      @if($barangTerlaris->count() > 0)
      <div class="card-scroll">
      <div class="stok-list">
        @foreach($barangTerlaris as $item)
        <div class="stok-item">
          <div>
            <div class="stok-name">{{ $item->barang->nama_barang ?? '-' }}</div>
            <div class="stok-code">{{ $item->barang->kode_barang ?? '-' }}</div>
          </div>
          <div class="stok-right">
            <div class="stok-qty sold">{{ $item->total_terjual }} terjual</div>
            <div class="stok-min">Rp {{ number_format($item->total_nilai,0,',','.') }}</div>
          </div>
        </div>
        @endforeach
        </div>
      </div>
      @else
        <div class="empty-state">Belum ada data penjualan</div>
      @endif
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
// ── Grafik Penjualan ──
const chartLabels = @json($chartData['labels']);
const chartData   = @json($chartData['data']);

const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: chartLabels,
    datasets: [{
      label: 'Penjualan',
      data: chartData,
      backgroundColor: 'rgba(26,86,219,0.12)',
      borderColor: '#1A56DB',
      borderWidth: 2,
      borderRadius: 6,
      hoverBackgroundColor: 'rgba(26,86,219,0.25)',
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false },
      tooltip: {
        callbacks: {
          label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID')
        },
        backgroundColor: '#1E2A4A',
        titleColor: '#fff',
        bodyColor: 'rgba(255,255,255,0.85)',
        padding: 10,
        cornerRadius: 8,
      }
    },
    scales: {
      x: {
        grid: { display: false },
        ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#6B7280' }
      },
      y: {
        grid: { color: '#F3F4F6' },
        ticks: {
          font: { family: 'Plus Jakarta Sans', size: 11 },
          color: '#6B7280',
          callback: v => v >= 1000000 ? 'Rp '+(v/1000000).toFixed(1)+'jt' : 'Rp '+(v/1000)+'rb'
        }
      }
    }
  }
});
</script>
@endsection