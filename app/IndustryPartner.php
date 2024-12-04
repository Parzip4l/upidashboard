<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryPartner extends Model
{
    use HasFactory;
    protected $table = 'industry_partners';
    protected $fillable = [
        'proposal_id',
        'name',
        'business_focus',
        'business_scale',
        'address',
        'email',
        'phone'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
