<?php
// DonationCenterHour.php model


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rdv;

class DonationCenterHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_center_id',
        'day_of_week',
        'opening_time',
        'closing_time',
        'is_closed'
    ];

    public function donationCenter()
    {
        return $this->belongsTo(DonationCenter::class);
    }

   
   
}
