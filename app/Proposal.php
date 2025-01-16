<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;
    protected $table = 'proposals';
    protected $fillable = [
        'fakultas_kamda',
        'prodi',
        'ketua_inovator',
        'nama_industri',
        'tkt',
        'bukti_tkt',
        'judul_proposal',
        'skema',
        'tema',
        'rencana_anggaran_biaya',
        'durasi_pelaksanaan',
        'dana_hilirisasi_inovasi',
        'mitra_tunai',
        'mitra_natura',
        'status',
        'tipe_proposal',
        'created_by'
    ];

    public function collaboration()
    {
        return $this->hasOne(Collaboration::class);
    }

    public function teamCompositions()
    {
        return $this->hasMany(TeamComposition::class);
    }

    public function industryPartner()
    {
        return $this->hasOne(IndustryPartner::class);
    }

    public function adminDocument()
    {
        return $this->hasOne(AdminDocument::class);
    }

    public function timelineProposals()
    {
        return $this->hasMany(TimelineProposal::class);
    }
    
    public function revisi()
    {
        return $this->hasMany(Revisi::class);
    }

    public function Pemenang()
    {
        return $this->hasOne(PemenangM::class);
    }

    public function Kontrak()
    {
        return $this->hasOne(KontrakPemenang::class);
    }
}
