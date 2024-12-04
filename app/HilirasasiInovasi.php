<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HilirasasiInovasi extends Model
{
    use HasFactory;
    protected $table = 'hilirisasi_inovasi';

    protected $fillable = [
        'user_id',
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
        'foto_produk_inovasi',
        'dokumen_produk_inovasi',
        'status',
        'kategori',
        'poster_inovasi',
        'powerpoint',
        'video_inovasi',
    ];
}
