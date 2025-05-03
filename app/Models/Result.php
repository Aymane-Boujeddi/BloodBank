<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'donation_id',
        'blood_type',
        'status',
        'hemoglobin',
        'blood_pressure',
        'pulse',
        'has_medical_issues',
        'medical_notes',
        'next_eligible_donation_date',
        'certificate_generated',
        'published_at'
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }


}
