<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\ActivityLogger;

class Barang extends Model {

    protected $table = 'barang';
    protected $fillable = [
        'kode_barang', 'nama_barang', 'harga_beli',
        'harga_eceran', 'harga_grosir', 'stok', 'min_stok'
    ];

    // ── Log aktivitas otomatis via Eloquent events ──
    protected static function booted(): void {
        static::created(function ($barang) {
            ActivityLogger::log(
                'Barang baru ditambahkan',
                'App\\Models\\Barang',
                $barang->id,
                ['attributes' => $barang->toArray()]
            );
        });

        static::updated(function ($barang) {
            $dirty = $barang->getDirty();
            $original = array_intersect_key($barang->getOriginal(), $dirty);
            
            $nonStokDirty = array_diff_key($dirty, ['stok' => true]);
            if (!empty($nonStokDirty)) {
                ActivityLogger::log(
                    'Data barang diperbarui',
                    'App\\Models\\Barang',
                    $barang->id,
                    ['attributes' => $dirty, 'old' => $original]
                );
            }
        });

        static::deleted(function ($barang) {
            ActivityLogger::log(
                'Barang dihapus',
                'App\\Models\\Barang',
                $barang->id,
                ['attributes' => ['nama_barang' => $barang->nama_barang]]
            );
        });
    }

    // ── Relasi dengan DetailTransaksi ──
    public function detailTransaksi() {
        return $this->hasMany(DetailTransaksi::class);
    }
}