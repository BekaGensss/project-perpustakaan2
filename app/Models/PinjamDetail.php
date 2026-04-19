<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinjamDetail extends Model
{
    use HasFactory;

    // Menetapkan nama tabel secara eksplisit
    protected $table = 'pinjam_detail';

    // Menetapkan kolom yang tidak boleh diisi secara massal (mass assignable)
    protected $guarded = [
        'id',
    ];

    /**
     * Relasi: PinjamDetail dimiliki oleh satu Pinjam (Induk).
     * Foreign Key di tabel ini adalah 'no_pinjam'.
     */
    public function pinjam()
    {
        // Tabel pinjam menggunakan 'no_pinjam' sebagai local key (yang dirujuk)
        return $this->belongsTo(Pinjam::class, 'no_pinjam', 'no_pinjam');
    }

    /**
     * Relasi: PinjamDetail dimiliki oleh satu Buku.
     * Foreign Key di tabel ini adalah 'id_buku'.
     */
    public function buku()
    {
        // Asumsi model Buku ada di App\Models\Buku
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    /**
     * Relasi: Petugas (User) yang melakukan pengembalian.
     * Foreign Key di tabel ini adalah 'id_petugas_kembali'.
     */
    public function petugas_kembali()
    {
        // Asumsi model User ada di App\Models\User
        return $this->belongsTo(User::class, 'id_petugas_kembali');
    }
}