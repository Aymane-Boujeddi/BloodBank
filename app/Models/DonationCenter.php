<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationCenter extends Model
{
    /** @use HasFactory<\Database\Factories\DonationCenterFactory> */
    use HasFactory;

    protected $fillable = [
        'center_name', 
        'address',
        'phone_number',
        'city_id',
        'user_id',
        'latitude',
        'longitude',
        'opening_time',
        'closing_time',
        'hourly_rate',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function availableDays()
    {
        return $this->hasMany(AvailableDays::class);
    }
    public function donors()
    {
        return $this->hasMany(Donor::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

   

   
}
