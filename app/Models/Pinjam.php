<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    use HasFactory;
    
    // Menetapkan nama tabel secara eksplisit
    protected $table = 'pinjam';

    // Menetapkan kolom yang tidak boleh diisi secara massal (mass assignable)
    protected $guarded = [
        'id',
    ];

    /**
     * Relasi: Satu Pinjam memiliki banyak PinjamDetail.
     * Foreign key di tabel PinjamDetail merujuk pada 'no_pinjam' di tabel Pinjam.
     */
    public function pinjam_detail()
    {
        // Asumsi model PinjamDetail ada di App\Models\PinjamDetail
        // Menggunakan 'no_pinjam' sebagai foreign key dan local key
        return $this->hasMany(PinjamDetail::class, 'no_pinjam', 'no_pinjam');
    }

    /**
     * Relasi: Pinjam dimiliki oleh Petugas (User) yang melakukan peminjaman.
     * Foreign key di tabel ini adalah 'id_petugas_pinjam'.
     */
    public function petugas_pinjam()
    {
        // Asumsi model User ada di App\Models\User
        return $this->belongsTo(User::class, 'id_petugas_pinjam');
    }

    /**
     * Relasi: Pinjam dimiliki oleh Anggota (User) yang melakukan peminjaman.
     * Foreign key di tabel ini adalah 'id_user'.
     */
    public function anggota()
    {
        // Asumsi model User ada di App\Models\User
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relasi: Pinjam dimiliki oleh Booking (Jika Anda ingin tahu dari booking mana pinjaman ini berasal)
     * Foreign key di tabel ini adalah 'id_booking'.
     * Catatan: Relasi ini opsional, tergantung kebutuhan aplikasi Anda.
     */
    public function booking()
    {
        // Asumsi model Booking ada di App\Models\Booking
        return $this->belongsTo(Booking::class, 'id_booking');
    }
}