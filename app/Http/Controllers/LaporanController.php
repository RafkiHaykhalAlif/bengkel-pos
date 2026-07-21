<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller {

    // ── Fungsi untuk membangun query dasar dengan filter dari request ──
    private function getQuery(Request $request) {
        $query = Transaksi::with(['detailTransaksi.barang', 'user'])
                    ->orderBy('tanggal_transaksi', 'desc');

        if ($request->dari)
            $query->whereDate('tanggal_transaksi', '>=', $request->dari);
        if ($request->hingga)
            $query->whereDate('tanggal_transaksi', '<=', $request->hingga);
        if ($request->jenis)
            $query->where('jenis', $request->jenis);
        if ($request->metode)
            $query->where('metode_bayar', $request->metode);

        return $query;
    }

    // ── Hitung total netto (sudah dikurangi retur) per transaksi ──
    private function totalNetto(Transaksi $t): int {
        $nilaiRetur = $t->detailTransaksi->sum(fn($d) => $d->qty_retur * $d->harga_satuan);
        return $t->total - $nilaiRetur;
    }

    // ── Hitung modal netto (stok yang tidak diretur saja) per transaksi ──
    private function modalNetto(Transaksi $t): int {
        return $t->detailTransaksi->sum(fn($d) =>
            ($d->qty - $d->qty_retur) * ($d->barang->harga_beli ?? 0)
        );
    }

    public function penjualan(Request $request) {
        $transaksi = $this->getQuery($request)->paginate(8)->withQueryString();

        $all = $this->getQuery($request)->get();

        // ── Hitung total netto per transaksi (total - nilai retur) dan buat ringkasan ──
        $totalJual = $all->sum(fn($t) => $this->totalNetto($t));

        $ringkasan = [
            'total_trx'    => $all->count(),
            'total_jual'   => $totalJual,
            'rata_rata'    => $all->count() > 0 ? round($totalJual / $all->count()) : 0,
            'total_servis' => $all->where('jenis', 'servis')->count(),
        ];

        $pdfData = $all->map(fn($t) => [
            'tanggal'     => $t->tanggal_transaksi->format('d M Y'),
            'no_trx'      => $t->no_transaksi,
            'jenis'       => ucfirst($t->jenis),
            'metode'      => $t->metode_bayar,
            'jumlah_item' => $t->detailTransaksi->sum('qty').' item',
            'retur'       => $t->detailTransaksi->sum('qty_retur') > 0
                             ? 'Rp '.number_format($t->detailTransaksi->sum(fn($d)=>$d->qty_retur*$d->harga_satuan),0,',','.')
                             : '-',
            'total'       => 'Rp '.number_format($this->totalNetto($t),0,',','.'),
        ]);

        return view('laporan.penjualan', compact('transaksi', 'ringkasan') + [
            'semuaTransaksi' => $all,
            'pdfData'        => $pdfData,
        ]);
    }

    // ── Fungsi untuk laporan keuangan (omzet, modal, laba) dengan grafik ──
    public function keuangan(Request $request) {
        $transaksi = $this->getQuery($request)->paginate(8)->withQueryString();

        $all = $this->getQuery($request)->get();

        $totalOmzet = $all->sum(fn($t) => $this->totalNetto($t));
        $totalModal = $all->sum(fn($t) => $this->modalNetto($t));

        $ringkasan = [
            'total_trx'   => $all->count(),
            'total_omzet' => $totalOmzet,
            'total_modal' => $totalModal,
            'laba_bersih' => $totalOmzet - $totalModal,
        ];

        // ── Data grafik ──
        $hariList = ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
        $chartHarian = [];
        $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
        for ($i = 0; $i < 7; $i++) {
            $tgl = $startOfWeek->copy()->addDays($i);
            $chartHarian[] = (int) \App\Models\Transaksi::whereDate('tanggal_transaksi', $tgl)->sum('total');
        }

        $chartMingguan = [];
        for ($mg = 3; $mg >= 0; $mg--) {
            $s = \Carbon\Carbon::now()->startOfMonth()->subWeeks($mg);
            $e = $s->copy()->addDays(6);
            $chartMingguan[] = (int) \App\Models\Transaksi::whereBetween('tanggal_transaksi', [$s, $e])->sum('total');
        }

        $bulanList = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
        $chartBulanan = [];
        $tahun = \Carbon\Carbon::now()->year;
        for ($bln = 1; $bln <= 12; $bln++) {
            $chartBulanan[] = (int) \App\Models\Transaksi::whereYear('tanggal_transaksi', $tahun)
                ->whereMonth('tanggal_transaksi', $bln)->sum('total');
        }

        $chartData = [
            'harian'   => ['labels' => $hariList,   'data' => $chartHarian,   'subtitle' => 'Pendapatan per hari'],
            'mingguan' => ['labels' => ['Mg 1','Mg 2','Mg 3','Mg 4'], 'data' => $chartMingguan, 'subtitle' => 'Pendapatan per minggu'],
            'bulanan'  => ['labels' => $bulanList,  'data' => $chartBulanan,  'subtitle' => 'Pendapatan '.now()->year.' per bulan'],
        ];

        $pdfData = $all->map(fn($t) => [
            'tanggal' => $t->tanggal_transaksi->format('d M Y'),
            'no_trx'  => $t->no_transaksi,
            'jenis'   => ucfirst($t->jenis),
            'metode'  => $t->metode_bayar,
            'omzet'   => $this->totalNetto($t),
            'modal'   => $this->modalNetto($t),
            'laba'    => $this->totalNetto($t) - $this->modalNetto($t),
        ]);

        return view('laporan.keuangan', compact('transaksi', 'ringkasan', 'chartData') + [
            'semuaTransaksi' => $all,
            'pdfData'        => $pdfData,
        ]);
    }
}