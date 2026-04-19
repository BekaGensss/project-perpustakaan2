<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash; // KLAS BARU: Untuk hashing password
use \App\Models\User; // Sudah benar, menggunakan namespace absolut

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    // FUNGSI UNTUK REAL-TIME DASHBOARD DATA
    public function getStats()
    {
        $totalBuku = \App\Models\Buku::count();
        $totalAnggota = User::where('role_id', 2)->count();
        $sedangDipinjam = \App\Models\PinjamDetail::where('status', 'Pinjam')->count();
        $bookingAktif = \App\Models\Booking::count();
        
        $bukuTersedia = \App\Models\Buku::sum('stok');
        $totalKategori = \App\Models\Kategori::count();
        $totalPeminjamanSelesai = \App\Models\PinjamDetail::where('status', 'Kembali')->count();

        // Chart 1: Peminjaman 7 Hari Terakhir
        $labelsHari = [];
        $dataHarian = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i);
            $labelsHari[] = $date->format('d M');
            $dataHarian[] = \App\Models\Pinjam::whereDate('tgl_pinjam', $date->toDateString())->count();
        }

        // Chart 2: Komposisi Status
        $statusPinjam = [
            'booking' => $bookingAktif,
            'pinjam' => $sedangDipinjam,
            'kembali' => $totalPeminjamanSelesai
        ];

        // Chart 3: 5 Buku Terpopuler
        $bukuTerpopuler = \App\Models\Buku::orderBy('dipinjam', 'desc')->take(5)->get(['judul_buku', 'dipinjam']);

        return response()->json([
            'totalBuku' => (int) $totalBuku,
            'totalAnggota' => (int) $totalAnggota,
            'sedangDipinjam' => (int) $sedangDipinjam,
            'bookingAktif' => (int) $bookingAktif,
            'bukuTersedia' => (int) $bukuTersedia,
            'totalKategori' => (int) $totalKategori,
            'totalPeminjamanSelesai' => (int) $totalPeminjamanSelesai,
            
            // Real-time Chart Data
            'chartHarian' => [
                'labels' => $labelsHari,
                'data' => $dataHarian
            ],
            'chartStatus' => $statusPinjam,
            'chartPopuler' => $bukuTerpopuler
        ]);
    }

    // FUNGSI UNTUK MENAMPILKAN HALAMAN PROFIL
    public function tampilProfil()
    {
        return view('admin.profil');
    }

    // FUNGSI UNTUK MEMPERBARUI DATA PROFIL
    public function updateProfil(Request $request)
    {
        $messages = [
            'nama.required' => 'Nama lengkap harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
            'image.image' => 'Gambar harus berupa file image.',
            'image.max' => 'Maksimal ukuran file 1 MB.',
        ];

        $validatedData = $request->validate([
            'nama' => 'required|string|max:128',
            'alamat' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png|file|max:1024',
        ], $messages);

        if ($request->file('image')) {
            // Ambil path gambar lama dari data user yang terautentikasi (BUKAN dari request)
            $oldImage = Auth::user()->image;
            if ($oldImage && $oldImage <> 'profil-pic/default.jpg') {
                Storage::delete($oldImage);
            }
            // Simpan gambar baru
            $validatedData['image'] = $request->file('image')->store('profil-pic');
        }

        // Update data user yang sedang login
        User::where('id', Auth::user()->id)->update($validatedData);

        return redirect()->route('admin.profil')->with('success', 'Profilmu berhasil diupdate.');
    }

    // FUNGSI BARU: MENAMPILKAN HALAMAN GANTI PASSWORD
    public function tampilGantiPassword()
    {
        return view('admin.ganti_password');
    }

    // FUNGSI BARU: MEMPROSES UPDATE PASSWORD
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

        $validatedData = $request->validate([
            'password_saat_ini' => 'required|string|min:8',
            'password_baru' => 'required|string|min:8',
            'konfirmasi_password' => 'required|string|min:8|same:password_baru',
        ], $messages);

        // Cek apakah password lama yang dimasukkan pengguna valid
        $cekPassword = Hash::check($request->password_saat_ini, auth()->user()->password);

        if (!$cekPassword) {
            return redirect()->back()->with('error', 'Gagal, password saat ini salah');
        }

        // Jika password lama benar, update password baru
        User::where('id', Auth::user()->id)->update([
            'password' => Hash::make($request->password_baru), // Gunakan Hash::make() untuk enkripsi
        ]);

        return redirect()->route('admin.ganti-password')->with('success', 'Password berhasil diupdate.');
    }
}