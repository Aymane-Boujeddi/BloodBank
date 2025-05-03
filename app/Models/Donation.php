<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    //
    protected $fillable = [
        'donor_id',
        'donation_center_id',
        'donation_date',
        'amount',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
    public function donationCenter()
    {
        return $this->belongsTo(DonationCenter::class);
    }
    public function result()
    {
        return $this->hasOne(Result::class);
    }
}
