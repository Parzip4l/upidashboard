<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianProposal extends Model
{
    use HasFactory;

    protected $table = 'penilaian_proposal';

    protected $fillable = [
        'id_proposal',
        'reviewer',
        'tujuan_sasaran',
        'metodologi',
        'jadwal_tahapan',
        'inovasi',
        'keberlanjutan_program',
        'dampak_sosial_ekonomi',
        'capaian_iku',
        'implementasi',
        'sdm',
        'anggaran',
        'nilai_total'
    ];
}
