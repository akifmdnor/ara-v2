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
        'commision_in_house',
        'commision_out_sourced',
        'profile_photo',
        'phone_number',
        'unique_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
