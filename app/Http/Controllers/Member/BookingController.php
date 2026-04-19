<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking; // Diperlukan
use App\Models\Kategori; // Diperlukan (Meskipun tidak langsung, ini bagus untuk Model Buku)
use Barryvdh\DomPDF\Facade\Pdf; // Diperlukan untuk bookingPdf

class BookingController extends Controller
{
    /**
     * Menampilkan daftar semua data booking (Digunakan untuk Admin Transaksi Index/Resource Index).
     * Melayani rute: admin.transaksi.booking.index
     */
    public function index()
    {
        $booking = Booking::with('anggota')->get();
        return view('admin.booking.index', compact('booking'));
    }

    /**
     * Menampilkan detail data booking tertentu (Resource Show).
     * Melayani rute: admin.transaksi.booking.show
     */
    public function show(string $id)
    {
        // Method show yang harus ada untuk melayani Resource Route Admin (GET /admin/transaksi/booking/{id})
        $data_booking = Booking::with('booking_detail', 'booking_detail.buku', 'anggota')
            ->where('id', $id)
            ->get(); 
            
        return view('admin.booking.show', compact('data_booking'));
    }

    /**
     * Menampilkan daftar semua data booking untuk Member tertentu.
     * Melayani rute: member.dataBooking
     */
    public function dataBooking(User $user)
    {
        // Eager loading 3 tingkat: booking_detail -> buku -> kategori
        $data_booking = Booking::with('booking_detail.buku.kategori')
            ->where('id_user', $user->id)
            ->get();
        
        if ($data_booking->isEmpty()) { 
            return redirect()->route('member.index')->with('info', 'Tidak ada buku yang dibooking');
        }

        return view('member.data_booking', compact('data_booking'));
    }

    /**
     * Membuat PDF bukti booking untuk Member tertentu.
     * Melayani rute: member.cetakBooking
     */
    public function bookingPdf(User $user)
    {
        $data_booking = Booking::with('booking_detail', 'booking_detail.buku', 'booking_detail.buku.kategori')
            ->where('id_user', $user->id)
            ->get();

        $pdf = Pdf::loadView('member.booking_pdf', compact('data_booking'));
        return $pdf->stream('data_booking.pdf');
    }

    /**
     * Menampilkan semua data booking untuk Dashboard Admin.
     * Melayani rute: admin.dataBooking (Untuk widget/ringkasan dashboard)
     */
    public function dataBookingAdmin()
    {
        $data_booking = Booking::with('anggota', 'booking_detail', 'booking_detail.buku', 'booking_detail.buku.kategori')->get();

        return view('admin.data_booking', compact('data_booking'));
    }
}