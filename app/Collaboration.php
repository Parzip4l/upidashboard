<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaboration extends Model
{
    use HasFactory;
    protected $table = 'collaborations';
    protected $fillable = [
        'proposal_id',
        'background',
        'target_users',
        'success_metrics',
        'implementation_needs',
        'cooperation_expectation',
        'industry_problems',
        'solution_description',
        'proposed_incentives'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
