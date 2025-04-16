<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningHour extends Model
{
    //
    protected $fillable = [
        'donation_center_id',
        'day_of_week',
        'opening_time',
        'closing_time',
        'is_open',
    ];
     
    public function donationCenter()
    {
        return $this->belongsTo(DonationCenter::class);
    }
}
