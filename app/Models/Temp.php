<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit (meskipun Laravel otomatis akan mencari 'temps')
    protected $table = 'temp';

    // Menentukan kolom mana saja yang bisa diisi secara massal (mass assignable)
    protected $fillable = [
        'id_buku',
        'id_user',
    ];

    /**
     * Relasi: Satu record Temp dimiliki oleh satu Buku.
     */
    public function buku()
    {
        // Asumsi model Buku ada di App\Models\Buku
        return $this->belongsTo(Buku::class, 'id_buku');
    }
    
    /**
     * Relasi: Satu record Temp dimiliki oleh satu User.
     */
    public function user()
    {
        // Asumsi model User ada di App\Models\User
        return $this->belongsTo(User::class, 'id_user');
    }
}