<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_center_id',
        'closed_days',
        'unavailable_dates',
        'slot_duration_minutes',
        'slots_per_hour',
        'special_hours'
    ];

    // Tell Laravel these fields contain JSON data
    protected $casts = [
        'closed_days' => 'array',
        'unavailable_dates' => 'array',
        'special_hours' => 'array'
    ];

    public function donationCenter()
    {
        return $this->belongsTo(DonationCenter::class);
    }
}
