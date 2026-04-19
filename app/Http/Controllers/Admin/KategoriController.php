<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar semua Kategori dan jumlah buku terkait. (READ - Index)
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua kategori dan menghitung jumlah buku terkait (buku_count)
        $kategori = Kategori::withCount('buku')->get(); 
        
        // Mengarahkan ke view 'admin/kategori/index.blade.php'
        return view('admin.kategori.index', compact('kategori'));
    }

    /**
     * Menyimpan Kategori baru ke database. (CREATE - Store)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validasi: Cek apakah nama_kategori sudah ada
        $request->validate([
            'nama_kategori' => 'required|string|max:30|unique:kategori,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada. Silakan gunakan nama lain.',
        ]);
        
        // Jika validasi lolos, simpan data
        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Memperbarui nama Kategori yang dipilih. (UPDATE - Update)
     * Catatan: Menggunakan ID dari Route Model Binding, bukan dari $request->id.
     * @param  \Illuminate\Http\Request  $request
     * @param  string $id  (ID Kategori yang akan diupdate)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        // 1. Validasi: Pastikan nama kategori unik, kecuali untuk ID yang sedang diedit
        $request->validate([
            'nama_kategori' => 'required|string|max:30|unique:kategori,nama_kategori,' . $id,
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada. Silakan gunakan nama lain.',
        ]);

        // 2. Lakukan update
        Kategori::where('id', $id)->update([
            'nama_kategori' => $request->nama_kategori,
        ]);
        
        return redirect()->back()->with('success', 'Kategori berhasil diupdate.');
    }

    /**
     * Menghapus Kategori berdasarkan ID. (DELETE - Destroy)
     * @param  string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        // Mencari kategori atau gagal
        $kategori = Kategori::findOrFail($id); 
        
        // Hapus kategori
        $kategori->delete(); 

        return redirect()->back()->with(['success' => 'Kategori berhasil dihapus!']);
    }
    
    // Method create() dan show() diabaikan karena menggunakan AJAX/Modal di index
    // Anda bisa menambahkannya jika Anda menggunakan halaman terpisah
}
