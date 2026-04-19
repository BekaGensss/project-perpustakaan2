<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BookingDetail; // WAJIB: Diperlukan untuk relasi hasMany
use App\Models\User;         // WAJIB: Diperlukan untuk relasi user()

class Booking extends Model
{
    use HasFactory;

    // Menetapkan nama tabel secara eksplisit
    protected $table = 'booking';

    // Menetapkan kolom yang tidak boleh diisi secara massal
    protected $guarded = [
        'id',
    ];

    /**
     * Relasi: Satu Booking memiliki banyak BookingDetail.
     * Menggunakan local key 'id_booking' untuk konsistensi penomoran.
     */
    public function booking_detail()
    {
        // Foreign key di BookingDetail: 'id_booking'
        // Local key di Booking: 'id_booking'
        // CATATAN: Modul menggunakan 'id_booking' sebagai local key
        return $this->hasMany(BookingDetail::class, 'id_booking', 'id_booking');
    }
    
    // Namun, jika Anda ingin menggunakan primary key Eloquent standar ('id'):
    /*
    public function booking_detail_standar()
    {
        return $this->hasMany(BookingDetail::class, 'id_booking', 'id');
    }
    */

    /**
     * Relasi: Satu Booking dimiliki oleh satu User (Anggota).
     */
    public function user() 
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
    // Alias untuk relasi yang lebih sesuai dengan user (anggota)
    public function anggota() 
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}