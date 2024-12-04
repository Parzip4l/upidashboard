<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemenangM extends Model
{
    use HasFactory;
    protected $table = 'pemenang_proposal';
    protected $fillable = [
        'proposal_id',
        'ditetapkan_oleh',
        'tahun',
        'nama_industri'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
