<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationCenter extends Model
{
    /** @use HasFactory<\Database\Factories\DonationCenterFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'city_id',
        'user_id'
    ];



    public function hours()
{
    return $this->hasMany(DonationCenterHour::class);
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
