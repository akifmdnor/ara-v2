<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SalesAgent extends Authenticatable
{
    use Notifiable;

    protected $guard = 'agent';

    protected $fillable = [
        'full_name',
        'company_name',
        'identification_card_number',
        'email',
        'gender',
        'password',
        'address',
        'zip_code',
        'city',
        'state',
        'commission_normal',
        'commission_promo',
        'profile_photo',
        'phone_number',
        'unique_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function bookings()
    {
        return $this->hasMany('App\Models\Booking');
    }
}
