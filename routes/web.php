<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Kontroler Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BukuController;
// Perbaikan: Hapus alias yang tidak perlu karena Controller Admin belum dibuat/digunakan
// use App\Http\Controllers\Admin\BookingController as AdminBookingController;
// use App\Http\Controllers\Admin\PinjamController as AdminPinjamController;

// Kontroler Member
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Member\TempController; // ⬅️ TempController (Keranjang)
use App\Http\Controllers\Member\BookingController; // ⬅️ BookingController Member
use App\Http\Controllers\PinjamController; // ⬅️ PinjamController Member (Diasumsikan PinjamController ini melayani rute Admin dan Member)

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Di sini tempat Anda dapat mendaftarkan rute web untuk aplikasi Anda.
| Rute-rute ini dimuat oleh RouteServiceProvider di dalam sebuah grup
| yang berisi grup middleware "web".
|
*/

// =======================================================================
// RUTE KATALOG UMUM MEMBER & LANDING PAGE
// =======================================================================

// Rute Landing Page (Welcome)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rute Katalog Buku
Route::get('/katalog', [MemberController::class, 'index'])->name('member.index')->middleware('isMember');

// Rute untuk Menampilkan Detail Buku (Katalog Anggota)
Route::get('detail-buku/{buku}', [MemberController::class, 'detailBuku'])
    ->name('member.detailBuku')
    ->middleware('isMember');

// =======================================================================
// RUTE AUTENTIKASI (LOGIN/LOGOUT)
// =======================================================================

// Rute Autentikasi untuk Tamu (Guest)
Route::middleware('guest')->group(function () {
    // Rute Login Default (Admin/User)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Rute Tambahan Khusus Member
    Route::post('/register-member', [AuthController::class, 'registerMember'])->name('registerMember');
    Route::post('/login-member', [AuthController::class, 'loginMember'])->name('loginMember');
});

// Rute Autentikasi untuk Pengguna Terautentikasi
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// =======================================================================
// RUTE KHUSUS ADMIN
// =======================================================================

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        // Rute Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');

        // Rute Profil Admin
        Route::get('/profil', [DashboardController::class, 'tampilProfil'])->name('profil');
        Route::put('/profil', [DashboardController::class, 'updateProfil']);

        // Rute Ganti Password Admin
        Route::get('/ganti-password', [DashboardController::class, 'tampilGantiPassword'])->name('ganti-password');
        Route::post('/ganti-password', [DashboardController::class, 'updateGantiPassword']); // tanpa name untuk hindari duplikat

        // ⬅️ PENGELOLAAN DATA TRANSAKSI GLOBAL UNTUK ADMIN (Menggunakan Controller yang tersedia)
        Route::get('data-keranjang', [TempController::class, 'dataKeranjangAdmin'])->name('dataKeranjang');
        // Perbaikan: Menggunakan BookingController (Member) yang sudah ada dan memiliki method dataBookingAdmin()
        Route::get('data-booking', [BookingController::class, 'dataBookingAdmin'])->name('dataBooking');
        // Perbaikan: Menggunakan PinjamController yang sudah ada (diasumsikan memiliki method)
        Route::get('sedang-pinjam', [PinjamController::class, 'sedangPinjamAdmin'])->name('sedangPinjam'); 
        Route::get('riwayat-pinjam', [PinjamController::class, 'riwayatPinjamAdmin'])->name('riwayatPinjam');
    });
    
    // RUTE PENGELOLAAN DATA MASTER
    Route::prefix('admin/master')->name('admin.master.')->group(function () {

        // Resource Route untuk User (CRUD)
        Route::resource('user', UserController::class);

        // Resource Route untuk Kategori (CRUD)
        Route::resource('kategori', KategoriController::class);

        // Resource Route untuk Buku (CRUD)
        Route::resource('buku', BukuController::class);

        // Rute Kustom untuk Reset Password User
        Route::put('user/reset-password/{user}', [UserController::class, 'resetPassword'])
            ->name('user.resetPassword');
    });

    // 🆕 RUTE PENGELOLAAN DATA TRANSAKSI
    Route::prefix('admin/transaksi')->name('admin.transaksi.')->group(function () {
        // Resource Route: Booking
        Route::resource('booking', BookingController::class)->except(['create', 'store', 'edit', 'update']);
        
        // Resource Route: Peminjaman
        Route::resource('peminjaman', PinjamController::class)->except(['destroy']);
        
        // Rute Kustom: Halaman Pengembalian Buku (index)
        Route::get('pengembalian', [PinjamController::class, 'pengembalian_index'])
            ->name('peminjaman.pengembalian');

        // =======================================================
        // ⬅️ RUTE BARU TAMBAHAN UNTUK PEMINJAMAN ⬅️
        // =======================================================

        // 1. Rute AJAX DataTables
        Route::get('peminjaman/data', [PinjamController::class, 'getData'])
            ->name('peminjaman.data');

        // 2. Rute Export PDF
        Route::get('export-pdf-pinjam', [PinjamController::class, 'exportPdfPinjam'])
            ->name('pinjam.exportPdfPinjam');
        
        // 3. Rute Export Excel
        Route::get('export-excel-pinjam', [PinjamController::class, 'exportExcelPinjam'])
            ->name('pinjam.exportExcelPinjam');
        
        // 4. Rute Aksi Kembalikan Buku (PUT/UPDATE)
        Route::put('pinjam/kembalikanBuku/{no_pinjam}/{id_buku}', [PinjamController::class, 'kembalikanBuku'])
            ->name('pinjam.kembalikanBuku');
            
    });
});

// =======================================================================
// RUTE KHUSUS MEMBER (ANGGOTA)
// =======================================================================

Route::middleware(['auth', 'isMember'])->group(function () {
    Route::prefix('member')->name('member.')->group(function () {

        // RUTE PROFIL & PASSWORD
        Route::get('/profil', [MemberController::class, 'tampilProfil'])->name('profil');
        Route::put('/profil', [MemberController::class, 'updateProfil']);
        Route::get('/ganti-password', [MemberController::class, 'tampilGantiPassword'])->name('ganti-password');
        Route::put('/ganti-password', [MemberController::class, 'updateGantiPassword']);

        // RUTE KERANJANG (TempController)
        Route::post('tambah-ke-keranjang', [TempController::class, 'tambahKeranjang'])->name('tambahKeranjang');
        Route::get('data-keranjang/{user}', [TempController::class, 'dataKeranjang'])->name('dataKeranjang');
        Route::delete('hapus-keranjang/{buku}/{user}', [TempController::class, 'hapusKeranjang'])->name('hapusKeranjang');

        // ⬅️ KODE BARU: Rute untuk menyelesaikan booking
        Route::post('simpan-booking', [TempController::class, 'simpanBooking'])->name('simpanBooking');

        // RUTE BOOKING (BookingController)
        Route::get('data-booking/{user}', [BookingController::class, 'dataBooking'])->name('dataBooking');
        // ⬅️ KODE BARU: Rute untuk mencetak bukti booking
        Route::get('cetak-booking/{user}', [BookingController::class, 'bookingPdf'])->name('cetakBooking');

        // RUTE PEMINJAMAN (PinjamController)
        Route::get('sedang-pinjam/{user}', [PinjamController::class, 'sedangPinjam'])->name('sedangPinjam');
        Route::get('riwayat-pinjam/{user}', [PinjamController::class, 'riwayatPinjam'])->name('riwayatPinjam');

    });
});