<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pinjam; 
use App\Models\PinjamDetail; 
use Illuminate\Support\Facades\DB;

// START KODE TAMBAHAN UNTUK FUNGSI TRANSAKSI & PDF
use Carbon\Carbon;
use App\Models\Buku;
use App\Models\Booking;
use App\Models\BookingDetail;
use Illuminate\Support\Facades\Auth;
// [DIHAPUS: use Yajra\DataTables\DataTables;] - Dihilangkan untuk mencegah error 500
use Barryvdh\DomPDF\Facade\Pdf; // PDF sudah aktif

// 🚩 TAMBAHAN 1: Import untuk Excel Export
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PinjamExport;
// END KODE TAMBAHAN
// Import kelas Export Anda di sini (misalnya: use App\Exports\PinjamExport;)

class PinjamController extends Controller
{
    /**
     * Menampilkan halaman Data Peminjaman (Admin Resource Index).
     * Melayani rute: admin.transaksi.peminjaman.index
     */
    public function index(Request $request)
    {
        $query = Pinjam::with(['anggota', 'petugas_pinjam', 'pinjam_detail.buku'])
            ->whereHas('pinjam_detail', function ($q) {
                $q->where('status', 'Pinjam');
            });
            
        // Logika Filter Tanggal (Perbaikan untuk menangani input dari view)
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if (!empty($start_date) && !empty($end_date)) {
            $end_date_time = Carbon::parse($end_date)->endOfDay();
            $query->whereBetween('tgl_pinjam', [$start_date, $end_date_time]);
        }
        
        $data_pinjam = $query->orderBy('no_pinjam', 'DESC')->get();
        
        // 🚩 PERBAIKAN: View disesuaikan menjadi 'admin.pinjam.index'
        return view('admin.pinjam.index', compact('data_pinjam')); 
    }
    
    /**
     * Melakukan export data peminjaman ke dalam format PDF berdasarkan rentang tanggal.
     * Melayani rute: admin.transaksi.pinjam.exportPdfPinjam
     */
    public function exportPdfPinjam(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        
        // Kueri untuk mengambil data peminjaman yang sedang aktif dalam rentang tanggal
        $data_pinjam = Pinjam::with(['pinjam_detail.buku', 'anggota', 'petugas_pinjam'])
            ->whereHas('pinjam_detail', function ($query) {
                $query->where('status', 'Pinjam'); 
            })
            ->whereBetween('tgl_pinjam', [$startDate, $endDate])
            ->orderBy('no_pinjam', 'DESC')
            ->get();
            
        // 🚩 PERBAIKAN: View disesuaikan menjadi 'admin.pinjam.pinjam_pdf'
        $pdf = Pdf::loadView('admin.pinjam.pinjam_pdf', compact('data_pinjam'));
        return $pdf->download('transaksi_pinjam.pdf');
    }
    
    /**
     * Menambahkan fungsi Export Excel (Pengganti Yajra untuk Export).
     * Melayani rute: admin.transaksi.pinjam.exportExcelPinjam
     */
    public function exportExcelPinjam(Request $request)
    {
        // 🚩 Implementasi Fungsi Export Excel
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        
        return Excel::download(new PinjamExport($startDate, $endDate), 'datapinjam.xlsx');
    }
    
    // =======================================================
    // 🆕 METHOD BARU: PENGEMBALIAN BUKU 🆕
    // =======================================================
    
    /**
     * [FUNGSI BARU] Memproses pengembalian buku (Update Status & Stok).
     * Melayani rute: admin.transaksi.pinjam.kembalikanBuku
     */
    public function kembalikanBuku($no_pinjam, $id_buku)
    {
        try {
            DB::transaction(function () use ($no_pinjam, $id_buku) {
                
                // 1. Temukan detail pinjaman berdasarkan no_pinjam dan id_buku
                $pinjamDetail = PinjamDetail::where('no_pinjam', $no_pinjam)
                    ->where('id_buku', $id_buku)
                    ->where('status', 'Pinjam')
                    ->firstOrFail(); // Menggunakan firstOrFail untuk menangani error jika tidak ditemukan

                // 2. Update status menjadi "Kembali"
                $pinjamDetail->tgl_pengembalian = Carbon::now();
                $pinjamDetail->status = 'Kembali';
                $pinjamDetail->id_petugas_kembali = Auth::user()->id;
                $pinjamDetail->save();

                // 3. Update Stok Buku (Mengembalikan stok)
                $buku = Buku::find($id_buku);
                if ($buku) {
                    $buku->dipinjam -= 1;
                    $buku->stok += 1;
                    $buku->save();
                }
            });

            // 🚩 PERBAIKAN UTAMA: Mengembalikan redirect setelah transaksi sukses
            return redirect()->route('admin.transaksi.peminjaman.index')->with('success', 'Buku berhasil dikembalikan!');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Jika firstOrFail gagal (pinjaman tidak ditemukan atau sudah Kembali)
            return redirect()->route('admin.transaksi.peminjaman.index')->with('error', 'Pinjaman tidak ditemukan atau sudah dikembalikan.');
        } catch (\Exception $e) {
            // Jika ada error lain
            return redirect()->route('admin.transaksi.peminjaman.index')->with('error', 'Terjadi kesalahan saat memproses pengembalian.');
        }
    }

    /**
     * [FUNGSI BARU] Menampilkan halaman buku-buku yang sudah dikembalikan.
     * Melayani rute: admin.transaksi.peminjaman.pengembalian_index
     */
    public function pengembalian_index()
    {
        $data_pinjam = Pinjam::with(['pinjam_detail' => function ($query) {
            $query->where('status', 'Kembali');
        }, 'pinjam_detail.buku', 'pinjam_detail.petugas_kembali',
        'petugas_pinjam'])
        ->whereHas('pinjam_detail', function ($query) {
            $query->where('status', 'Kembali');
        })
        ->orderBy('no_pinjam', 'DESC')
        ->get();
        
        // 🚩 View baru: 'admin.pinjam.pengembalian_index'
        return view('admin.pinjam.pengembalian_index', compact('data_pinjam'));
    }

    // =======================================================
    // METHOD LAINNYA
    // =======================================================

    /**
     * [PERBAIKAN BUG] Method getData() untuk route peminjaman.data.
     * Sebelumnya route ini mengarah ke method yang tidak ada → 500 error.
     */
    public function getData(Request $request)
    {
        $query = Pinjam::with(['anggota', 'petugas_pinjam', 'pinjam_detail.buku'])
            ->whereHas('pinjam_detail', function ($q) {
                $q->where('status', 'Pinjam');
            });

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query->whereBetween('tgl_pinjam', [$request->start_date, Carbon::parse($request->end_date)->endOfDay()]);
        }

        $data = $query->orderBy('no_pinjam', 'DESC')->get();
        return response()->json(['data' => $data]);
    }

    /**
     * Menampilkan daftar buku yang sedang dipinjam oleh user tertentu (Status: Pinjam) - Untuk Member.
     */
    public function sedangPinjam(User $user)
    {
        // ... kode yang sudah ada ...
        $sedang_pinjam = Pinjam::with(['pinjam_detail' => function ($query) {
            $query->where('status', 'Pinjam');
        }, 'pinjam_detail.buku', 'pinjam_detail.petugas_kembali', 'petugas_pinjam'])
        ->whereHas('pinjam_detail', function ($query) {
            $query->where('status', 'Pinjam');
        })
        ->where('id_user', $user->id)
        ->orderBy('no_pinjam', 'ASC')
        ->get();

        if ($sedang_pinjam->isEmpty()) {
            return redirect()->route('member.index')->with('info', 'Tidak ada buku yang sedang dipinjam');
        }

        return view('member.sedang_pinjam', compact('sedang_pinjam'));
    }

    /**
     * Menampilkan riwayat peminjaman (semua status) oleh user tertentu - Untuk Member.
     */
    public function riwayatPinjam(User $user)
    {
        // ... kode yang sudah ada ...
        $riwayat_pinjam = Pinjam::with('pinjam_detail', 'pinjam_detail.buku',
            'pinjam_detail.petugas_kembali', 'petugas_pinjam')
            ->where('id_user', $user->id)
            ->orderBy('no_pinjam', 'ASC')
            ->get();

        if ($riwayat_pinjam->isEmpty()) {
            return redirect()->route('member.index')->with('info', 'Tidak ada riwayat peminjaman');
        }

        return view('member.riwayat_pinjam', compact('riwayat_pinjam'));
    }

    /**
     * Menampilkan daftar buku yang sedang dipinjam oleh SELURUH USER (Status: Pinjam) - Untuk Admin.
     */
    public function sedangPinjamAdmin()
    {
        // ... kode yang sudah ada ...
        $data_pinjam = Pinjam::with('anggota', 'petugas_pinjam', 'pinjam_detail', 'pinjam_detail.buku')
        ->whereHas('pinjam_detail', function ($query) {
            $query->where('status', 'Pinjam');
        })
        ->get();

        // 🚩 PERBAIKAN: View disesuaikan menjadi 'admin.pinjam.index'
        return view('admin.pinjam.index', compact('data_pinjam'));
    }
    
    /**
     * Menyimpan transaksi peminjaman baru dari data booking.
     * Melayani rute: admin.transaksi.peminjaman.store
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            // Ambil kode booking yang dikirim (misal: 'B251103001')
            $id_booking_kode = $request->input('id_booking'); 
            
            // Cari objek booking berdasarkan kode
            $booking = Booking::where('id_booking', $id_booking_kode)->first();
            
            // 🆕 BARU: Ambil Primary Key (ID) yang dibutuhkan oleh Foreign Key tabel pinjam
            $booking_primary_key = $booking->id; 
            
            $id_user = $booking->id_user;
            
            // Membuat no_pinjam dengan format Pyymmdd001
            $todayDate = Carbon::now()->format('ymd');
            $nextPinjamNumber = str_pad(Pinjam::whereDate('created_at', Carbon::today())->count() + 1, 3, '0', STR_PAD_LEFT);
            $no_pinjam = 'P' . $todayDate . $nextPinjamNumber;
            
            $tgl_pinjam = Carbon::now();
            $status = 'Pinjam';
            
            // Simpan data ke tabel pinjam
            $pinjam = Pinjam::create([
                'no_pinjam' => $no_pinjam,
                'tgl_pinjam' => $tgl_pinjam,
                // 🚩 PERBAIKAN: Menggunakan Primary Key
                'id_booking' => $booking_primary_key, 
                
                'id_user' => $id_user,
                'id_petugas_pinjam' => Auth::user()->id,
            ]);
            
            // Simpan data ke tabel pinjam_detail
            foreach ($request->input('denda') as $index => $denda) {
                // Mendapatkan id_buku dari BookingDetail (masih merujuk pada kode booking)
                $id_buku = BookingDetail::where('id_booking', $id_booking_kode)
                    ->pluck('id_buku')[$index];
                
                $lama_pinjam = $request->input('lama')[$index];
                $tgl_kembali = Carbon::parse($tgl_pinjam)->addDays((int)$lama_pinjam);
                
                PinjamDetail::create([
                    'no_pinjam' => $no_pinjam,
                    'id_buku' => $id_buku,
                    'tgl_kembali' => $tgl_kembali,
                    'tgl_pengembalian' => null,
                    'denda' => $denda,
                    'lama_pinjam' => $lama_pinjam,
                    'status' => $status,
                ]);
                
                // Update stok buku
                $buku = Buku::find($id_buku);
                $buku->dibooking -= 1;
                $buku->dipinjam += 1;
                $buku->save();
            }
            
            // 🚩 PERBAIKAN: Hapus data dari tabel booking menggunakan Primary Key
            BookingDetail::where('id_booking', $id_booking_kode)->delete();
            Booking::where('id', $booking_primary_key)->delete(); 
        });
        
        return redirect()->route('admin.transaksi.booking.index')->with('success',
            'Data pinjaman berhasil disimpan dan booking telah dihapus.');
    }
}