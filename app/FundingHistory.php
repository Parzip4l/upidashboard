<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundingHistory extends Model
{
    use HasFactory;
    protected $table = 'funding_histories';
    protected $fillable = [
        'team_composition_id', 'proposal_title', 'year', 'name', 'status'
    ];

    /**
     * A funding history belongs to a team composition.
     */
    public function teamComposition()
    {
        return $this->belongsTo(TeamComposition::class);
    }
}
  
}
