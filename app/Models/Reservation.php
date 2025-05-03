<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //
    protected $fillable = [
        'donor_id',
        'donation_center_id',
        'reservation_date',
        'reservation_time',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

  
    public function donationCenter(){

        return $this->belongsTo(DonationCenter::class);
    }
}
