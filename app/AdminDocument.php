<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminDocument extends Model
{
    use HasFactory;
    protected $table = 'admin_documents';
    protected $fillable = [
        'proposal_id',
        'proposal_file',
        'partner_commitment_letter',
        'funding_commitment_letter',
        'study_commitment_letter',
        'applicant_bio_form',
        'partner_profile_form',
        'cooperation_agreement',
        'hki_agreement',
        'budget_plan_file'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
