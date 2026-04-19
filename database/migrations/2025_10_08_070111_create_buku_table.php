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
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('judul_buku', 128);
            
            // Kolom Foreign Key
            $table->unsignedBigInteger('id_kategori'); // Gunakan unsignedBigInteger
            
            $table->string('pengarang', 64);
            $table->string('penerbit', 64);
            $table->year('tahun_terbit');
            $table->string('isbn', 64);
            $table->unsignedInteger('stok');
            $table->unsignedInteger('dipinjam');
            $table->unsignedInteger('dibooking');
            $table->string('image', 256)->default('cover-buku/book-default-cover.jpg');
            $table->timestamps();

            // Definisi Foreign Key (Opsional, tapi direkomendasikan)
            $table->foreign('id_kategori')->references('id')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
