<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviewer extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_proposal',
        'reviewer1',
        'reviewer2'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'id_proposal');
    }

    public function reviewerFirst()
    {
        return $this->belongsTo(User::class, 'reviewer1');
    }

    public function reviewerSecond()
    {
        return $this->belongsTo(User::class, 'reviewer2');
    }
}
