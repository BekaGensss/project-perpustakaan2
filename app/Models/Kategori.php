<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Buku; // <--- DITAMBAHKAN AGAR RELASI TERDEFINISI JELAS

class Kategori extends Model
{
    use HasFactory;
    
    // Nama tabel di database
    protected $table = 'kategori';
    
    // Field yang tidak boleh diisi (mass assignment protection)
    protected $guarded = [
        'id',
    ];

    /**
     * Relasi one-to-many: Satu Kategori memiliki banyak Buku.
     */
    public function buku()
    {
        // Parameter kedua: foreign key di tabel 'buku'
        return $this->hasMany(Buku::class, 'id_kategori');
    }
}