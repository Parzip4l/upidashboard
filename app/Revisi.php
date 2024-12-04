<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    protected $table = 'revisi_proposal';

    protected $fillable = [
        'proposal_id',
        'catatan',
        'created_by'
    ];
    
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
