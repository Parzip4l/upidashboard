<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;
    protected $table = 'timeline_proposal';

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'proposal_id',
        'proposal_upload',
        'administrasi',
        'substansi',
        'revisi',
        'revisi_upload',
        'verifikasi_revisi',
        'penetapan_pemenang',
        'kontrak',
        'pelaksanaan'
    ];

    // Tentukan relasi jika ada, misalnya relasi dengan model Proposal
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
