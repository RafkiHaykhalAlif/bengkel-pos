<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// ── Model untuk menyimpan detail jasa yang terkait dengan transaksi (jasa servis) ──
class DetailJasa extends Model {
protected $table = 'detail_jasa';
    protected $fillable = ['transaksi_id', 'keterangan', 'harga'];
    // ── Relasi dengan Transaksi ──
    public function transaksi() {
        return $this->belongsTo(Transaksi::class);
    }
}