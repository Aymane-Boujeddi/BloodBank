<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //
    protected $fillable = ['date', 'time', 'donor_id', 'center_id'];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function center()
    {
        return $this->belongsTo(DonationCenter::class);
    }
    
}
