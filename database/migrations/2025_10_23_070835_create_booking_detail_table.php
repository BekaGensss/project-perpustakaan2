<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('booking_detail', function (Blueprint $table) {
            // Kunci utama (Primary Key)
            $table->id(); 

            // Kolom ID Booking
            // Asumsi: id_booking adalah string atau ID dari tabel booking utama.
            // Jika merujuk ke id() di tabel 'bookings', lebih baik menggunakan unsignedBigInteger.
            $table->string('id_booking'); 
            
            // Kolom Kunci Asing (Foreign Key) ke tabel 'buku'
            $table->unsignedBigInteger('id_buku');
            
            // Mendefinisikan Kunci Asing: 
            // id_buku merujuk ke kolom 'id' di tabel 'buku'.
            // Jika buku dihapus, detail booking ini juga akan dihapus (cascade).
            $table->foreign('id_buku')->references('id')->on('buku')->onDelete('cascade');
            
            // Kolom timestamps (created_at dan updated_at)
            $table->timestamps();
        });
    }

    /**
     * Balikkan (Undo) migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_detail');
    }
};