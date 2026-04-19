<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Import Models yang dibutuhkan untuk fungsi-fungsi penghitung
use App\Models\Temp;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Pinjam;
use App\Models\PinjamDetail;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'alamat',
        'email',
        'image',
        'password',
        'role_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // =======================================================================
    // FUNGSI PENGHITUNG TOTAL STATUS (UNTUK NAVBAR/DASHBOARD MEMBER)
    // =======================================================================

    /**
     * Menghitung total item dalam keranjang (temp) milik user ini.
     *
     * @return int
     */
    public function totalKeranjang()
    {
        return Temp::where('id_user', $this->id)->count();
    }

    /**
     * Menghitung total buku yang sedang di-booking oleh user ini.
     *
     * @return int
     */
    public function totalBooking()
    {
        return BookingDetail::whereIn('id_booking', function ($query) {
            $query->select('id_booking')
                ->from(with(new Booking)->getTable())
                ->where('id_user', $this->id);
        })->count();
    }

    /**
     * Menghitung total buku yang sedang dipinjam (status 'Pinjam') oleh user ini.
     *
     * @return int
     */
    public function totalSedangPinjam()
    {
        return PinjamDetail::whereIn('no_pinjam', function ($query) {
            $query->select('no_pinjam')
                ->from(with(new Pinjam)->getTable())
                ->where('status', 'Pinjam') // Filter status Pinjam
                ->where('id_user', $this->id);
        })->count();
    }

    /**
     * Menghitung total item dalam semua riwayat peminjaman (termasuk yang sudah dikembalikan) oleh user ini.
     *
     * @return int
     */
    public function totalRiwayatPinjam()
    {
        return PinjamDetail::whereIn('no_pinjam', function ($query) {
            $query->select('no_pinjam')
                ->from(with(new Pinjam)->getTable())
                ->where('id_user', $this->id);
        })->count();
    }
}