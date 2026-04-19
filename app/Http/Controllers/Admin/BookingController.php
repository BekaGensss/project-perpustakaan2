<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; // Import Model Booking
use Illuminate\Support\Facades\DB; // Diperlukan untuk transaksi database

class BookingController extends Controller
{
    /**
     * Menampilkan daftar semua data booking yang masuk (Resource Index).
     * Melayani rute: admin.transaksi.booking.index
     */
    public function index()
    {
        // Mengambil semua data booking dengan eager loading data anggota (user)
        // Pastikan relasi 'anggota' ada di Model Booking
        $booking = Booking::with('anggota')->get();
        
        return view('admin.booking.index', compact('booking'));
    }

    /**
     * Menampilkan detail data booking tertentu (Resource Show).
     * Melayani rute: admin.transaksi.booking.show
     */
    public function show(string $id)
    {
        // Menerapkan fungsi show sesuai permintaan Anda:
        $data_booking = Booking::with('booking_detail', 'booking_detail.buku', 'anggota')
            ->where('id', $id)
            ->get();
            
        return view('admin.booking.show', compact('data_booking'));
    }

    /**
     * Mengubah status booking, misalnya dari 'Pending' menjadi 'Siap Ambil'.
     * Melayani rute: admin.transaksi.booking.update
     */
    public function update(Request $request, Booking $booking)
    {
        // Contoh: Logika untuk memproses booking menjadi peminjaman
        if ($request->action == 'process_to_pinjam') {
             // Di sini seharusnya ada logika kompleks yang memindahkan data dari Booking ke Pinjam

             try {
                 DB::beginTransaction();

                 // 1. Ubah status booking (Contoh: 'processed')
                 $booking->status = 'processed';
                 $booking->save();

                 // 2. Tambahkan logika pinjam buku di sini (memanggil PinjamController atau Service)

                 DB::commit();
                 return redirect()->route('admin.transaksi.booking.index')
                         ->with('success', 'Booking berhasil diproses menjadi Peminjaman.');
                
             } catch (\Exception $e) {
                 DB::rollBack();
                 return redirect()->back()->with('error', 'Gagal memproses booking: ' . $e->getMessage());
             }
        }

        return redirect()->back()->with('success', 'Status booking berhasil diperbarui.');
    }
    
    /**
     * Menghapus data booking (Resource Destroy).
     * Melayani rute: admin.transaksi.booking.destroy
     */
    public function destroy(Booking $booking)
    {
        // 1. Kembalikan stok buku jika diperlukan
        // $booking->booking_detail->each(function ($detail) {
        //     $detail->buku->increment('stok');
        // });

        // 2. Hapus Booking
        $booking->delete();

        return redirect()->route('admin.transaksi.booking.index')
                         ->with('success', 'Booking berhasil dihapus/dibatalkan.');
    }

    // Method lain (jika ada, seperti yang ada di Controller Member)
    // public function dataBookingAdmin() 
    // { ... }
}