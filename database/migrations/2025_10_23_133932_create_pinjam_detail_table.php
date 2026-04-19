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
        Schema::create('pinjam_detail', function (Blueprint $table) {
            $table->id();

            // Kunci Asing ke tabel 'pinjam' (merujuk pada kolom 'no_pinjam')
            // Kolom ini harus memiliki tipe data yang sama dengan 'no_pinjam' di tabel 'pinjam' (VARCHAR/string)
            $table->string('no_pinjam');
            $table->foreign('no_pinjam')->references('no_pinjam')->on('pinjam')->onDelete('cascade');

            // Kunci Asing ke tabel 'buku'
            // foreignId() secara otomatis membuat kolom unsignedBigInteger dan constrained
            $table->foreignId('id_buku')->constrained('buku')->onDelete('cascade');
            
            // Tanggal kembali yang direncanakan
            $table->timestamp('tgl_kembali')->nullable();

            // Tanggal pengembalian aktual
            $table->timestamp('tgl_pengembalian')->nullable();
            
            // Status peminjaman
            $table->enum('status', ['Pinjam', 'Kembali'])->default('Pinjam');
            
            // Jumlah denda yang dikenakan
            $table->decimal('denda', 10, 2)->default(0);

            // Lama pinjam (dalam hari)
            $table->integer('lama_pinjam');

            // ID Petugas yang menerima pengembalian
            $table->string('id_petugas_kembali')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjam_detail');
    }
};