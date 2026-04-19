<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage; // Diperlukan untuk upload gambar

class BukuController extends Controller
{
    /**
     * Menampilkan daftar semua Buku dan Kategori untuk dropdown filter. (READ - Index)
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua buku dengan relasi Kategori (Eager Loading)
        $buku = Buku::with('kategori')->get();
        
        // Mengambil semua kategori untuk digunakan di form atau filter
        $kategori = Kategori::all();
        
        // Mengarahkan ke view 'admin/buku/index.blade.php'
        return view('admin.buku.index', compact('buku', 'kategori'));
    }

    /**
     * Tampilkan form untuk membuat Buku baru. (CREATE - Form)
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Mengambil semua kategori untuk dropdown di form
        $kategori = Kategori::all();
        return view('admin.buku.create', compact('kategori'));
    }

    /**
     * Menyimpan Buku baru ke database. (CREATE - Store)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $messages = [
            'image.image' => 'Gambar harus berupa file image.',
            'image.max' => 'Maksimal ukuran file 1 MB.',
            // Tambahkan pesan validasi untuk field lain (disarankan)
        ];
        
        // 1. Validasi Data
        $request->validate([
            // Tambahkan validasi untuk semua field wajib (judul, kategori, pengarang, dll.)
            'judul_buku' => 'required|string|max:128',
            'id_kategori' => 'required|exists:kategori,id',
            'pengarang' => 'required|string|max:64',
            'penerbit' => 'required|string|max:64',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:'.(date('Y') + 1),
            'isbn' => 'required|string|max:64|unique:buku,isbn', // ISBN harus unik
            'stok' => 'required|integer|min:0',
            // dipinjam dan dibooking diisi 0 secara default (jika tidak dikirimkan)
            'image' => 'nullable|image|mimes:jpeg,jpg,png|file|max:1024',
        ], $messages);

        // 2. Upload dan simpan gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cover-buku', 'public');
        } else {
            $imagePath = 'cover-buku/book-default-cover.jpg';
        }

        // 3. Simpan data ke dalam database
        $data = $request->only(['judul_buku', 'id_kategori', 'pengarang',
            'penerbit', 'tahun_terbit', 'isbn', 'stok']);
        
        // Tambahkan nilai default untuk dipinjam dan dibooking jika tidak ada di request
        $data['dipinjam'] = $request->input('dipinjam', 0);
        $data['dibooking'] = $request->input('dibooking', 0);
        
        $data['image'] = $imagePath;
        Buku::create($data);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('admin.master.buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail Buku tertentu. (READ - Show)
     */
    public function show(Buku $buku)
    {
        return view('admin.buku.show', compact('buku'));
    }

    /**
     * Tampilkan form untuk mengedit Buku tertentu. (UPDATE - Form)
     */
    public function edit(Buku $buku)
    {
        $kategori = Kategori::all();
        return view('admin.buku.edit', compact('buku', 'kategori'));
    }

    /**
     * Perbarui Buku tertentu di database. (UPDATE - Update)
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'image.image' => 'Gambar harus berupa file image.',
            'image.max' => 'Maksimal ukuran file 1 MB.',
        ];
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpeg,jpg,png|file|max:1024',
        ], $messages);
        
        // Update data
        $data = $request->only(['judul_buku', 'id_kategori', 'pengarang',
            'penerbit', 'tahun_terbit', 'isbn', 'stok', 'dipinjam', 'dibooking']);

        if ($request->file('image')) {
            if ($request->oldImage && $request->oldImage <> 'cover-buku/book-default-cover.jpg') {
                Storage::delete($request->oldImage);
            }
            $imagePath = $request->file('image')->store('cover-buku', 'public');
            $data['image'] = $imagePath;
        }

        Buku::where('id', $id)->update($data);
        return redirect()->route('admin.master.buku.index')->with('success', 'Buku berhasil diupdate.');
    }

    /**
     * Hapus Buku tertentu dari database. (DELETE - Destroy)
     */
    public function destroy(Buku $buku)
    {
        if ($buku->image && $buku->image <> 'cover-buku/book-default-cover.jpg') {
            Storage::delete($buku->image);
        }
        Buku::destroy($buku->id); // Menggunakan $buku->id bukan 'id' sebagai parameter pertama
        return redirect()->back()->with('success', 'Buku berhasil dihapus.');
    }
}
