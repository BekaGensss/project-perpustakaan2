# 📚 EL-KALA (E-Library: Katalog Literasi Digital Anda)

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

**EL-KALA** adalah platform sistem informasi manajemen perpustakaan modern berbasis web yang dirancang untuk memberikan pengalaman literasi digital yang intuitif, cepat, dan elegan. Dengan antarmuka berbasis *Glassmorphism* dan *Light Theme* yang bersih, EL-KALA memudahkan pengguna dalam melakukan pengecekan ketersediaan buku hingga sistem booking digital.

---

## ✨ Fitur Utama

### 👤 Untuk Pengunjung (Guest)
- **Landing Page Modern**: Halaman utama yang interaktif dengan statistik real-time.
- **Katalog Buku**: Menjelajahi koleksi literatur tanpa harus login terlebih dahulu.
- **Sistem Panduan**: Alur peminjaman yang divisualisasikan dengan jelas.
- **FAQ Interaktif**: Jawaban instan untuk pertanyaan seputar kebijakan perpustakaan.

### 🔑 Untuk Anggota (Member)
- **Sistem Booking 1-Klik**: Melakukan reservasi buku secara digital sebelum mengambil fisik di lokasi.
- **Manajemen Keranjang**: Mengumpulkan buku-buku pilihan sebelum diproses.
- **Status Peminjaman**: Riwayat peminjaman buku yang sedang aktif dan riwayat penyelesaian.
- **Profil Pengguna**: Manajemen data diri dan pengaturan keamanan (Ganti Password).

### 🛠️ Untuk Admin (Dashboard)
- **Manajemen Katalog**: Kontrol penuh atas data Buku, Kategori, dan Penulis.
- **Manajemen Anggota**: Verifikasi dan kontrol status keaktifan user.
- **Statistik Dashboard**: Visualisasi data jumlah buku, member aktif, dan kategori secara keseluruhan.
- **Konfigurasi Sistem**: Pengaturan branding dan manajemen data master.

---

## 🚀 Panduan Instalasi Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan EL-KALA di komputer Anda.

### 📋 Prasyarat
- **PHP**: ^8.2
- **Composer**: Dependency Manager
- **Node.js & NPM**: Untuk manajemen aset (Vite/Mix)
- **Database Server**: MySQL / MariaDB (Laragon/XAMPP direkomendasikan)

### 🛠️ Langkah-Langkah

1. **Persiapan Project**
   Buka terminal di direktori proyek Anda:
   ```bash
   composer install
   npm install && npm run build
   ```

2. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Pengaturan Database**
   Buka file `.env` dan sesuaikan nama database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Migrasi & Seed Data**
   Jalankan perintah ini untuk membuat tabel dan mengisi data awal (termasuk akun admin):
   ```bash
   php artisan migrate --seed
   ```

5. **Symlink Storage**
   Agar gambar buku dan profil muncul, jalankan perintah link storage:
   ```bash
   php artisan storage:link
   ```

6. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```
   Akses di browser pada alamat: `http://127.0.0.1:8000`

---

## 🔐 Akun Akses Default

### 🤴 Administrator
- **Email**: `admin@example.com`
- **Password**: `password`

### 👥 Member / Anggota
Silakan melakukan registrasi melalui tombol **Daftar** di halaman utama aplikasi.

---

## 📂 Struktur Direktori Penting

- `app/Models/`: Definisi entitas data (Buku, User, Kategori).
- `app/Http/Controllers/`: Logika bisnis dan pemrosesan data.
- `resources/views/admin/`: Seluruh antarmuka Dashboard Administrator.
- `resources/views/member/`: Antarmuka katalog dan member area.
- `resources/views/welcome.blade.php`: Halaman depan / Landing Page utama.
- `public/assets/`: Berisi aset statis (CSS, JS, Plugins).

---

## 🛡️ License
Proyek ini dilisensikan di bawah **MIT license**. Anda bebas menggunakannya untuk tujuan edukatif maupun komersial dengan tetap mencantumkan kredit pengembang asli.

---

## 🤝 Kontribusi
Ingin berkontribusi? Silakan lakukan **Fork** repositori ini, lakukan perubahan pada branch baru, dan kirimkan **Pull Request**. Kami sangat terbuka untuk masukan atau perbaikan fitur!

---
*Dibuat dengan ❤️ untuk kemajuan literasi digital.*
**Maintained by EL-KALA Team.**
