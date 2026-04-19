<?php

namespace App\Http\Controllers\Member;

use App\Models\Buku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// Ditambahkan:
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash; // <<< Ditambahkan untuk fitur Ganti Password

class MemberController extends Controller
{
    /**
     * Menampilkan halaman katalog buku untuk anggota (member).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil data buku dengan relasi kategori (eager loading)
        // dan lakukan paginasi sebanyak 12 item per halaman.
        $buku = Buku::with('kategori')->paginate(12);

        // Tampilkan view 'member.index' dengan data buku
        return view('member.index', compact('buku'));
    }

    /**
     * Menampilkan detail buku tertentu dalam format JSON.
     *
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailBuku(Buku $buku)
    {
        // Ambil detail buku termasuk relasi kategori (eager loading).
        $detailBuku = $buku->load('kategori');

        // Mengembalikan data sebagai JSON.
        return response()->json($detailBuku);
    }

    // =======================================================================
    // FITUR PROFIL MEMBER
    // =======================================================================

    /**
     * Menampilkan halaman profil untuk member.
     *
     * @return \Illuminate\View\View
     */
    public function tampilProfil()
    {
        return view('member.profil');
    }

    /**
     * Memperbarui data profil member.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfil(Request $request)
    {
        $messages = [
            'nama.required' => 'Nama lengkap harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
            'image.image' => 'Gambar harus berupa file image.',
            'image.max' => 'Maksimal ukuran file 1 MB.',
        ];

        // Validasi data yang masuk
        $validatedData = $request->validate([
            'nama' => 'required|string|max:128',
            'alamat' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png|file|max:1024',
        ], $messages);

        // Proses upload gambar
        if ($request->file('image')) {
            // Ambil path gambar lama dari data user terautentikasi (BUKAN dari request)
            $oldImage = Auth::user()->image;
            if ($oldImage && $oldImage <> 'profil-pic/default.jpg') {
                Storage::delete($oldImage);
            }
            // Simpan gambar baru
            $validatedData['image'] = $request->file('image')->store('profil-pic');
        }

        // Update data pengguna (member)
        User::where('id', Auth::user()->id)->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('member.profil')->with('success', 'Profilmu berhasil diupdate.');
    }

    // =======================================================================
    // FITUR GANTI PASSWORD MEMBER
    // =======================================================================

    /**
     * Menampilkan halaman ganti password untuk member.
     *
     * @return \Illuminate\View\View
     */
    public function tampilGantiPassword()
    {
        return view('member.ganti_password');
    }

    /**
     * Memperbarui password member.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateGantiPassword(Request $request)
    {
        $messages = [
            'password_saat_ini.required' => 'Password saat ini harus diisi.',
            'password_saat_ini.min' => 'Minimal 8 karakter.',
            'password_baru.required' => 'Password baru harus diisi.',
            'password_baru.min' => 'Minimal 8 karakter.',
            'konfirmasi_password.required' => 'Konfirmasi password harus diisi.',
            'konfirmasi_password.min' => 'Minimal 8 karakter.',
            'konfirmasi_password.same' => 'Password dan konfirmasi password tidak cocok.',
        ];

        // 1. Validasi input
        $validatedData = $request->validate([
            'password_saat_ini' => 'required|string|min:8',
            'password_baru' => 'required|string|min:8',
            'konfirmasi_password' => 'required|string|min:8|same:password_baru',
        ], $messages);

        // 2. Cek apakah password saat ini benar
        $cekPassword = Hash::check($request->password_saat_ini, auth()->user()->password);

        if (!$cekPassword) {
            // Jika password saat ini salah, kembali dengan pesan error
            return redirect()->back()->with('error', 'Gagal, password saat ini salah');
        }

        // 3. Update password baru
        User::where('id', Auth::user()->id)->update([
            'password' => Hash::make($request->password_baru),
        ]);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('member.ganti-password')->with('success', 'Password berhasil diupdate.');
    }
}