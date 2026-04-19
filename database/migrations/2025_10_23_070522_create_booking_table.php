<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Diperlukan untuk DB::raw()

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            
            // Kolom ID Booking sebagai string unik
            $table->string('id_booking')->unique();
            
            // Tanggal booking dengan default waktu saat ini
            $table->datetime('tgl_booking')->default(DB::raw('CURRENT_TIMESTAMP'));
            
            // Batas waktu pengambilan buku
            $table->datetime('batas_ambil');
            
            // Foreign Key ke tabel users (Menggunakan unsignedBigInteger untuk ID)
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};