<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Tambahkan untuk memastikan Hash tersedia jika dibutuhkan

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil UserSeeder.php yang berisi data Admin dan Member yang sudah diperbaiki.
        $this->call([
            UserSeeder::class, 
            // Tambahkan Seeder lain di sini (KategoriSeeder, BukuSeeder, dll.)
        ]);
        
        // HAPUS: Baris User::factory()->create(...) yang menyebabkan error 'name'.
        // HAPUS: Baris User::factory(10)->create();
    }
}