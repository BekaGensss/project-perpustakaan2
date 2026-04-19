<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori; // WAJIB: Diperlukan untuk relasi kategori()
use App\Models\BookingDetail; // WAJIB: Diperlukan untuk relasi booking_detail()

class Buku extends Model
{
    use HasFactory;
    
    // Nama tabel di database
    protected $table = 'buku';
    
    // Field yang tidak boleh diisi (mass assignment protection)
    protected $guarded = [
        'id', 
    ];

    /**
     * Relasi many-to-one: Buku dimiliki oleh satu Kategori. 
     * Digunakan untuk eager loading: booking_detail.buku.kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    /**
     * Relasi one-to-many: Buku memiliki banyak BookingDetail.
     * Diperlukan oleh Model BookingDetail untuk mengakses data Buku.
     */
    public function booking_detail()
    {
        // Foreign key di tabel 'booking_detail' adalah 'id_buku'
        return $this->hasMany(BookingDetail::class, 'id_buku');
    }
}