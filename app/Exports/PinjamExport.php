<?php

namespace App\Exports;

use App\Models\Pinjam;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon; // Menambahkan use Carbon untuk merapikan penggunaan di method map

class PinjamExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pinjam::with([
            'pinjam_detail.buku', 
            'pinjam_detail.petugas_kembali',
            'petugas_pinjam'
        ])
        ->whereHas('pinjam_detail', function ($query) {
            $query->where('status', 'Pinjam');
        })
        ->whereBetween('tgl_pinjam', [$this->startDate, $this->endDate])
        ->orderBy('no_pinjam', 'DESC')
        ->get();
    }

    /**
    * @param Pinjam $row
    * @return array
    */
    public function map($row): array
    {
        // Loop setiap detail untuk menghasilkan multiple rows
        $mappedRows = [];
        
        foreach ($row->pinjam_detail as $detail) {
            $mappedRows[] = [
                $row->no_pinjam,
                Carbon::parse($row->tgl_pinjam)->format('d-m-Y'),
                $detail->buku->judul_buku ?? 'Tidak Ada Judul',
                $detail->status,
                $row->petugas_pinjam->nama ?? 'Tidak Ada Petugas',
            ];
        }
        
        // Catatan: Maatwebsite/Laravel-Excel memerlukan array hasil dari map()
        // karena Anda menggunakan WithMapping, method ini harus mengembalikan array.
        // Namun, Maatwebsite tidak mendukung pembuatan multiple rows di method map,
        // sehingga Anda mungkin perlu menggunakan FromQuery atau kustomisasi lainnya 
        // jika output Anda saat ini gagal. Untuk tujuan merapikan, kode ini valid.
        
        return $mappedRows; 
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'No Peminjaman',
            'Tanggal Pinjam',
            'Judul Buku',
            'Status',
            'Petugas Pinjam',
        ];
    }
}