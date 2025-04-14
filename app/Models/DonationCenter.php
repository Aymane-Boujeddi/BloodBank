<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationCenter extends Model
{
    /** @use HasFactory<\Database\Factories\DonationCenterFactory> */
    use HasFactory;

    protected $fillable = [
        'center_name', // This needs to match your migration field
        'address',
        'phone_number',
        'city_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hours()
    {
        return $this->hasMany(DonationCenterHour::class);
    }

    public function donors()
    {
        return $this->hasMany(Donor::class);
    }

    public function reservations()
    {
        return $this->hasMany(Rdv::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

        

    // Helper method to get hours for a specific day
    public function getHoursForDay($day)
    {
        return $this->hours()->where('day_of_week', strtolower($day))->first();
    }

    // Helper method to check if center is open on a specific day
    public function isOpenOnDay($day)
    {
        $hours = $this->getHoursForDay($day);
        return $hours && !$hours->is_closed;
    }
   
}
