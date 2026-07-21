<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model {
    // ── Definisikan nama tabel dan kolom yang dapat diisi massal ──
    protected $table = 'detail_transaksis';
    protected $fillable = [
        'transaksi_id', 'barang_id', 'qty',
        'harga_satuan', 'subtotal', 'qty_retur'
    ];

    // ── Relasi dengan Transaksi dan Barang ──
    public function transaksi() {
        return $this->belongsTo(Transaksi::class);
    }

    // ── Relasi dengan Barang ──
    public function barang() {
        return $this->belongsTo(Barang::class);
    }
}