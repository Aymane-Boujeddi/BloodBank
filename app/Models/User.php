<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function donor()
    {
        return $this->hasOne(Donor::class);
    }

    public function donationCenter()
    {
        return $this->hasOne(DonationCenter::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function isDonor()
    {
        return $this->role === 'donor';
    }

    public function isDonationCenter()
    {
        return $this->role === 'donation_centre';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
