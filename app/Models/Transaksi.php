<?php
// ── Ganti isi app/Models/Transaksi.php dengan ini ──

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model {
    // ── Definisikan nama tabel dan kolom yang dapat diisi massal ──
    protected $table = 'transaksis';
    protected $fillable = [
        'no_transaksi', 'user_id', 'jenis',
        'metode_bayar', 'total', 'biaya_jasa', 'status', 'tanggal_transaksi'
    ];

    // ── Definisikan tipe data untuk tanggal_transaksi ──
    protected $casts = [
        'tanggal_transaksi' => 'datetime',
    ];

    // ── Relasi dengan User ──
    public function user() {
        return $this->belongsTo(User::class);
    }

    // ── Relasi dengan DetailTransaksi ──
    public function detailTransaksi() {
        return $this->hasMany(DetailTransaksi::class);
    }

    // ── Relasi dengan DetailJasa ──
    public function detailJasa() {
        return $this->hasMany(DetailJasa::class);
    }
}