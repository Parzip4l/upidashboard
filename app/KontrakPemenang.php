<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontrakPemenang extends Model
{
    use HasFactory;
    protected $table = 'kontrak_proposal';
    protected $fillable = [
        'proposal_id',
        'kontrak'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
