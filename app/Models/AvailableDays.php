<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableDays extends Model
{
    //
    protected $fillable = [
        'donation_center_id',
        'day',
    ];

    public function donationCenter()
    {
        return $this->belongsTo(DonationCenter::class);
    }
    
}
