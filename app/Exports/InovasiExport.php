<?php

namespace App\Exports;

use App\HilirasasiInovasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InovasiExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return HilirasasiInovasi::select(
            'nidn_nidk_nup',
            'nama_perguruan_tinggi',
            'program_studi',
            'nomor_ktp',
            'tanggal_lahir',
            'nomor_telepon',
            'deskripsi_profil',
            'kata_kunci',
            'judul_inovasi',
            'inventor_contact_person',
            'deskripsi_keunggulan_inovasi',
            'status'
        )->get();
    }

    public function headings(): array
    {
        return [
            'NIDN/NIDK/NUP',
            'Nama Perguruan Tinggi',
            'Program Studi',
            'Nomor KTP',
            'Tanggal Lahir',
            'Nomor Telepon',
            'Deskripsi Profil',
            'Kata Kunci',
            'Judul Inovasi',
            'Inventor Contact Person',
            'Deskripsi Keunggulan Inovasi',
            'Status'
        ];
    }
}
