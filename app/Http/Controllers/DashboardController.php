<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller {

    // ── Fungsi untuk menampilkan dashboard dengan berbagai statistik dan grafik ──
    public function index(Request $request) {
        $filter = $request->get('filter', 'harian');

        // Tentukan rentang tanggal berdasarkan filter
        [$dari, $hingga] = match($filter) {
            'mingguan' => [Carbon::now()->startOfWeek()->startOfDay(), Carbon::now()->endOfWeek()->endOfDay()],
            'bulanan'  => [Carbon::now()->startOfMonth()->startOfDay(), Carbon::now()->endOfMonth()->endOfDay()],
            default    => [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()],
        };

        // ── Stat cards ──
        if ($filter === 'harian') {
            $trxQuery = Transaksi::whereDate('tanggal_transaksi', Carbon::today());
        } else {
            $trxQuery = Transaksi::whereBetween('tanggal_transaksi', [$dari, $hingga]);
        }
        $totalTrx    = $trxQuery->count();
        $totalBarang = Barang::count();
        $stokMenipisCount = Barang::whereColumn('stok', '<', 'min_stok')->count();

        // Hitung totalJual dan labaBersih dengan memperhitungkan retur + biaya jasa
        $detailPeriode = DetailTransaksi::whereHas('transaksi', function($q) use ($filter, $dari, $hingga) {
            if ($filter === 'harian') {
                $q->whereDate('tanggal_transaksi', Carbon::today());
            } else {
                $q->whereBetween('tanggal_transaksi', [$dari, $hingga]);
            }
        })->with('barang')->get();

        // Omzet netto = qty yang tidak diretur x harga satuan
        $totalJualBarang = $detailPeriode->sum(fn($d) => ($d->qty - $d->qty_retur) * $d->harga_satuan);
        $totalModal      = $detailPeriode->sum(fn($d) => ($d->qty - $d->qty_retur) * ($d->barang->harga_beli ?? 0));

        // Tambahkan biaya jasa dari transaksi periode ini
        if ($filter === 'harian') {
            $totalBiayaJasa = Transaksi::whereDate('tanggal_transaksi', Carbon::today())->sum('biaya_jasa');
        } else {
            $totalBiayaJasa = Transaksi::whereBetween('tanggal_transaksi', [$dari, $hingga])->sum('biaya_jasa');
        }
        $totalJual  = $totalJualBarang + $totalBiayaJasa;
        $labaBersih = $totalJual - $totalModal;

        // ── Grafik data ──
        $chartData = $this->getChartData($filter, $dari, $hingga);

        // ── Stok menipis (tampilkan semua yang stoknya < min_stok) ──
        $stokMenipis = Barang::whereColumn('stok', '<', 'min_stok')
                        ->orderBy('stok', 'asc')->get();

        // ── Transaksi terakhir (5 terbaru hari ini) dengan netto retur ──
        $transaksiTerakhir = Transaksi::with('detailTransaksi')
                            ->whereDate('tanggal_transaksi', Carbon::today())
                            ->orderBy('tanggal_transaksi', 'desc')
                            ->limit(5)->get()
                            ->map(function($t) {
                                $nilaiRetur = $t->detailTransaksi->sum(fn($d) => $d->qty_retur * $d->harga_satuan);
                                $t->total_netto = $t->total - $nilaiRetur;
                                return $t;
                            });

        // ── Barang terlaris (berdasarkan total qty terjual) ──
        $barangTerlaris = DetailTransaksi::with('barang')
                        ->selectRaw('barang_id, SUM(qty) as total_terjual, SUM(subtotal) as total_nilai')
                        ->groupBy('barang_id')
                        ->orderByDesc('total_terjual')
                        ->limit(5)->get();

        return view('dashboard.index', compact(
            'filter', 'totalTrx', 'totalJual', 'totalBarang',
            'stokMenipisCount', 'labaBersih', 'chartData',
            'stokMenipis', 'transaksiTerakhir', 'barangTerlaris'
        ));
    }

    // ── Fungsi untuk mendapatkan data grafik berdasarkan filter ──
    private function getChartData(string $filter, $dari, $hingga): array {
        return match($filter) {
            'mingguan' => $this->chartMingguan($dari),
            'bulanan'  => $this->chartBulanan(),
            default    => $this->chartHarian(),
        };
    }

    // ── Fungsi untuk chart harian (omzet per jam hari ini) ──
    private function chartHarian(): array {
        $labels = ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];
        $data = [];
        foreach (range(8, 17) as $jam) {
            $data[] = (int) Transaksi::whereDate('tanggal_transaksi', Carbon::today())
                ->whereTime('tanggal_transaksi', '>=', sprintf('%02d:00:00', $jam))
                ->whereTime('tanggal_transaksi', '<',  sprintf('%02d:00:00', $jam + 1))
                ->sum('total');
        }
        return ['labels' => $labels, 'data' => $data, 'subtitle' => 'Hari ini per jam'];
    }

    // ── Fungsi untuk chart mingguan (omzet per hari dalam seminggu) ──
    private function chartMingguan($dari): array {
        $hariList = ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
        $data = [];
        for ($i = 0; $i < 7; $i++) {
            $tgl = $dari->copy()->addDays($i);
            $data[] = (int) Transaksi::whereDate('tanggal_transaksi', $tgl)->sum('total');
        }
        return ['labels' => $hariList, 'data' => $data, 'subtitle' => 'Minggu ini per hari'];
    }

    // ── Fungsi untuk chart bulanan (omzet per bulan dalam setahun) ──
    private function chartBulanan(): array {
        $bulanList = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
        $data = [];
        $tahun = Carbon::now()->year;
        for ($bln = 1; $bln <= 12; $bln++) {
            $data[] = (int) Transaksi::whereYear('tanggal_transaksi', $tahun)
                ->whereMonth('tanggal_transaksi', $bln)->sum('total');
        }
        return ['labels' => $bulanList, 'data' => $data, 'subtitle' => Carbon::now()->year.' per bulan'];
    }
}