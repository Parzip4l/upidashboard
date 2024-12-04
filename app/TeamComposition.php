<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamComposition extends Model
{
    use HasFactory;
    protected $table = 'team_compositions';
    protected $fillable = [
        'proposal_id',
        'member_type',
        'name',
        'identifier',
        'faculty_kamda',
        'program',
        'position',
        'active_status',
        'funding_history',
        'is_lead'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function fundingHistories()
    {
        return $this->hasMany(FundingHistory::class);
    }
}
