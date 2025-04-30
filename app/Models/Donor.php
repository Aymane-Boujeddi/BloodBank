<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rdv;
use App\Models\Reservation;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'date_of_birth',
        'blood_type_id',
        'city_id',
        'user_id',
        'has_donated',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'has_donated' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function donationCenter()
    {
        return $this->belongsTo(DonationCenter::class);
    }
    
    

}
