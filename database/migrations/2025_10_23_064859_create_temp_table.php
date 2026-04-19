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
        Schema::create('temp', function (Blueprint $table) {
            $table->id();
            // Kolom untuk ID Buku, harus unsigned karena merujuk ke ID
            $table->integer('id_buku')->unsigned(); 
            // Kolom untuk ID User, harus unsigned karena merujuk ke ID
            $table->integer('id_user')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp');
    }
};