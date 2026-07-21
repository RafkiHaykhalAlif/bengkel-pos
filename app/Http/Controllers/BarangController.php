<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BarangController extends Controller {

    // ── Tampilkan daftar barang ──
    public function index() {
        $barang = Barang::orderBy('nama_barang')->get();
        return view('barang.index', compact('barang'));
    }

    // ── Tampilkan halaman inventaris dengan indikator stok menipis ──
    public function inventaris() {
        $barang       = Barang::orderBy('nama_barang')->get();
        $stokMenipis  = $barang->filter(fn($b) => $b->stok < $b->min_stok);
        return view('inventaris.index', compact('barang', 'stokMenipis'));
    }

    // ── Fungsi untuk menambahkan barang baru ──
    public function store(Request $request) {
        $request->merge(['kode_barang' => $request->kode_barang ?: null]);
        $request->validate([
            'kode_barang'  => ['nullable', 'max:20', 'unique:barang,kode_barang'],
            'nama_barang'  => 'required|max:100',
            'harga_beli'   => 'required|integer|min:0',
            'harga_eceran' => 'required|integer|min:0',
            'harga_grosir' => 'required|integer|min:0',
            'stok'         => 'required|integer|min:0',
            'min_stok'     => 'required|integer|min:0',
        ]);

        Barang::create($request->all());

        return response()->json(['success' => true, 'message' => 'Barang berhasil ditambahkan.']);
    }

    // ── Fungsi untuk memperbarui data barang ──
    public function update(Request $request, $id) {
        $barang = Barang::findOrFail($id);

        $request->merge(['kode_barang' => $request->kode_barang ?: null]);
        $request->validate([
            'kode_barang'  => ['nullable', 'max:20', Rule::unique('barang','kode_barang')->ignore($barang->id)],
            'nama_barang'  => 'required|max:100',
            'harga_beli'   => 'required|integer|min:0',
            'harga_eceran' => 'required|integer|min:0',
            'harga_grosir' => 'required|integer|min:0',
            'stok'         => 'required|integer|min:0',
            'min_stok'     => 'required|integer|min:0',
        ]);

        $barang->update($request->all());

        return response()->json(['success' => true, 'message' => 'Barang berhasil diperbarui.']);
    }

    // ── Fungsi untuk menghapus barang ──
    public function destroy($id) {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return response()->json(['success' => true, 'message' => 'Barang berhasil dihapus.']);
    }

    // ── Fungsi untuk mengimpor barang dari file CSV ──
    public function import(Request $request) {
        $request->validate(['file' => 'required|file|mimes:csv,txt']);

        $file   = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');
        $added  = 0; $updated = 0; $errors = [];
        $i      = 0;

        while (($cols = fgetcsv($handle)) !== false) {
            $i++;
            if ($i === 1 && isset($cols[0]) && stripos($cols[0], 'kode') !== false) continue;
            if (count($cols) < 7) { $errors[] = "Baris {$i}: kolom kurang"; continue; }

            [$kode, $nama, $hBeli, $hEcer, $hGros, $stok, $minStok] = $cols;
            $nama = trim($nama);
            if (!$nama) { $errors[] = "Baris {$i}: nama kosong"; continue; }

            $kode     = trim($kode);
            $existing = $kode ? Barang::where('kode_barang', $kode)->first() : null;
            $data = [
                'nama_barang'  => $nama,
                'harga_beli'   => (int) $hBeli,
                'harga_eceran' => (int) $hEcer,
                'harga_grosir' => (int) $hGros,
                'stok'         => (int) $stok,
                'min_stok'     => (int) $minStok,
            ];

            if ($existing) { $existing->update($data); $updated++; }
            else { Barang::create(array_merge(['kode_barang' => $kode ?: null], $data)); $added++; }
        }

        fclose($handle);

        return response()->json([
            'success' => true,
            'message' => "Import selesai: {$added} ditambahkan, {$updated} diperbarui.",
            'added'   => $added,
            'updated' => $updated,
            'errors'  => $errors,
        ]);
    }
}