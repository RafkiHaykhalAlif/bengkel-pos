<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\DetailJasa;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiController extends Controller {

    // ── Fungsi untuk halaman POS eceran ──
    public function eceran() {
        $barang = Barang::where('stok', '>', 0)->orderBy('nama_barang')->get();
        return view('pos.eceran', compact('barang'));
    }

    // ── Fungsi untuk halaman POS grosir ──
    public function grosir() {
        $barang = Barang::where('stok', '>', 0)->orderBy('nama_barang')->get();
        return view('pos.grosir', compact('barang'));
    }

    // ── Fungsi untuk menyimpan transaksi ──
    public function store(Request $request) {
        $request->validate([
            'jenis'        => 'required|in:eceran,grosir,servis',
            'metode_bayar' => 'required|in:Cash,QRIS',
            'items'        => 'nullable|array',
            'items.*.barang_id'    => 'required_with:items|exists:barang,id',
            'items.*.qty'          => 'required_with:items|integer|min:1',
            'items.*.harga_satuan' => 'required_with:items|integer|min:0',
            'detail_jasa'          => 'nullable|array',
            'detail_jasa.*.keterangan' => 'required_with:detail_jasa|string|max:255',
            'detail_jasa.*.harga'      => 'required_with:detail_jasa|integer|min:0',
        ]);

        $hasItems = !empty($request->items) && count($request->items) > 0;
        $hasJasa  = !empty($request->detail_jasa) && count($request->detail_jasa) > 0;
        if (!$hasItems && !$hasJasa) {
            return response()->json(['success' => false, 'message' => 'Minimal harus ada barang atau jasa.'], 422);
        }

        DB::beginTransaction();
        $batchUuid = ActivityLogger::newBatch(); // ── Generate batch UUID ──
        try {
            $prefix = 'TRX-' . Carbon::now()->format('Ymd') . '-';
            $last   = Transaksi::where('no_transaksi', 'like', $prefix . '%')
                        ->orderBy('no_transaksi', 'desc')->first();
            $no     = $last
                ? $prefix . str_pad((int)substr($last->no_transaksi, -3) + 1, 3, '0', STR_PAD_LEFT)
                : $prefix . '001';

            $subtotal   = $hasItems ? collect($request->items)->sum(fn($i) => $i['qty'] * $i['harga_satuan']) : 0;
            $biaya_jasa = $hasJasa  ? collect($request->detail_jasa)->sum(fn($j) => (int)$j['harga']) : 0;
            $total      = $subtotal + $biaya_jasa;

            $transaksi = Transaksi::create([
                'no_transaksi'      => $no,
                'user_id'           => Auth::id(),
                'jenis'             => $request->jenis,
                'metode_bayar'      => $request->metode_bayar,
                'total'             => $total,
                'biaya_jasa'        => $biaya_jasa,
                'status'            => 'selesai',
                'tanggal_transaksi' => Carbon::now(),
            ]);

            // ── Log transaksi dibuat ──
            ActivityLogger::log(
                'Transaksi baru dibuat',
                'App\\Models\\Transaksi',
                $transaksi->id,
                ['attributes' => [
                    'no_transaksi' => $no,
                    'jenis'        => $request->jenis,
                    'metode_bayar' => $request->metode_bayar,
                    'total'        => $total,
                    'status'       => 'selesai',
                ]],
                $batchUuid
            );

            // Simpan detail barang
            if ($hasItems) {
                foreach ($request->items as $item) {
                    $barang = Barang::findOrFail($item['barang_id']);
                    if ($barang->stok < $item['qty']) {
                        throw new \Exception("Stok {$barang->nama_barang} tidak mencukupi.");
                    }
                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'barang_id'    => $item['barang_id'],
                        'qty'          => $item['qty'],
                        'harga_satuan' => $item['harga_satuan'],
                        'subtotal'     => $item['qty'] * $item['harga_satuan'],
                    ]);

                    $stokLama = $barang->stok;
                    $barang->decrement('stok', $item['qty']);

                    // ── Log stok barang berkurang ──
                    ActivityLogger::log(
                        'Data barang diperbarui',
                        'App\\Models\\Barang',
                        $barang->id,
                        [
                            'attributes' => ['stok' => $barang->stok - $item['qty']],
                            'old'        => ['stok' => $stokLama],
                            'new'        => ['stok' => $stokLama - $item['qty']],
                        ],
                        $batchUuid
                    );
                }
            }

            // Simpan detail jasa
            if ($hasJasa) {
                foreach ($request->detail_jasa as $jasa) {
                    DetailJasa::create([
                        'transaksi_id' => $transaksi->id,
                        'keterangan'   => $jasa['keterangan'],
                        'harga'        => (int)$jasa['harga'],
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success'      => true,
                'no_transaksi' => $no,
                'total'        => $total,
                'biaya_jasa'   => $biaya_jasa,
                'message'      => 'Transaksi berhasil disimpan.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    // ── Fungsi untuk menampilkan daftar transaksi ──
    public function index(Request $request) {
        $query = Transaksi::with(['user', 'detailTransaksi'])
                    ->orderBy('tanggal_transaksi', 'desc');

        if ($request->dari)   $query->whereDate('tanggal_transaksi', '>=', $request->dari);
        if ($request->hingga) $query->whereDate('tanggal_transaksi', '<=', $request->hingga);
        if ($request->jenis)  $query->where('jenis', $request->jenis);
        if ($request->no)     $query->where('no_transaksi', 'like', '%' . $request->no . '%');

        $transaksi = $query->paginate(10);
        return view('transaksi.index', compact('transaksi'));
    }

    // ── Fungsi untuk menampilkan detail transaksi ──
    public function show(Request $request, $id) {
        $transaksi = Transaksi::with(['user', 'detailTransaksi.barang', 'detailJasa'])->findOrFail($id);

        if ($request->wantsJson() || $request->header('Accept') === 'application/json') {
            return response()->json($transaksi->load('detailTransaksi.barang'));
        }

        return view('transaksi.show', compact('transaksi'));
    }

    // ── Fungsi untuk memproses retur barang ──
    public function retur(Request $request) {
        $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id',
            'items'        => 'required|array|min:1',
            'items.*.detail_id' => 'required|exists:detail_transaksis,id',
            'items.*.qty_retur' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        $batchUuid = ActivityLogger::newBatch(); // ── Generate batch UUID retur ──
        try {
            $transaksi = Transaksi::findOrFail($request->transaksi_id);

            foreach ($request->items as $item) {
                $detail = DetailTransaksi::findOrFail($item['detail_id']);
                $maxRetur = $detail->qty - $detail->qty_retur;
                if ($item['qty_retur'] > $maxRetur) {
                    throw new \Exception("Qty retur melebihi sisa qty untuk {$detail->barang->nama_barang}. Maks: {$maxRetur}");
                }

                $tambahan_retur = $item['qty_retur'];
                $detail->increment('qty_retur', $tambahan_retur);

                $stokLama = $detail->barang->stok;
                $detail->barang->increment('stok', $tambahan_retur);

                // ── Log stok barang bertambah karena retur ──
                ActivityLogger::log(
                    'Data barang diperbarui',
                    'App\\Models\\Barang',
                    $detail->barang->id,
                    [
                        'attributes' => ['stok' => $stokLama + $tambahan_retur],
                        'old'        => ['stok' => $stokLama],
                        'new'        => ['stok' => $stokLama + $tambahan_retur],
                        'keterangan' => 'Stok kembali karena retur',
                    ],
                    $batchUuid
                );
            }

            $totalRetur = $transaksi->detailTransaksi()->sum('qty_retur');
            $status     = $totalRetur > 0 ? 'diretur' : 'selesai';
            $transaksi->update(['status' => $status]);

            // ── Log transaksi diretur ──
            ActivityLogger::log(
                'Transaksi diperbarui',
                'App\\Models\\Transaksi',
                $transaksi->id,
                ['attributes' => ['status' => $status], 'old' => ['status' => 'selesai']],
                $batchUuid
            );

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Retur berhasil diproses.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}