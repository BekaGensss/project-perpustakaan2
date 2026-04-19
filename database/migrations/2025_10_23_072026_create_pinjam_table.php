<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pinjam', function (Blueprint $table) {
            // Kunci utama (Primary Key)
            $table->id();

            // Nomor Peminjaman (harus unik)
            $table->string('no_pinjam')->unique();
            
            // Tanggal Peminjaman
            $table->timestamp('tgl_pinjam');
            
            // ❌ Perbaikan: Mengubah $table->string('id_booking') menjadi unsignedBigInteger
            // Ini agar sesuai dengan tipe $table->id() di tabel 'booking'.
            $table->unsignedBigInteger('id_booking'); 
            
            // ✅ Tambahkan Foreign Key constraint untuk id_booking
            $table->foreign('id_booking')->references('id')->on('booking')->onDelete('cascade'); 

            // Kunci Asing (Foreign Key) ke tabel 'users'
            // foreignId() sudah benar dan otomatis membuat kolom unsignedBigInteger.
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            
            // Total Denda
            $table->decimal('total_denda', 10, 2)->default(0);
            
            // ID Petugas yang Melakukan Peminjaman
            // Jika ini juga merujuk ke 'users', sebaiknya gunakan foreignId()
            $table->string('id_petugas_pinjam'); 
            
            // Kolom timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel jika migrasi dibatalkan
        Schema::dropIfExists('pinjam');
    }
};