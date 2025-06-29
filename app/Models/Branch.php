<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Branch extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $guard = 'branch';

    protected $fillable = [
        'branch_name',
        'phone_number',
        'city',
        'country',
        'email',
        'address',
        'postal_code',
        'address_latitude',
        'address_longitude',
        'price_per_km',
        'percentage_sale',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function pictures()
    {
        return $this->hasMany('App\Models\Picture', 'model_id')->where('model_name', '=', 'branch');
    }
    public function car_models()
    {
        return $this->hasMany('App\Models\CarModel');
    }



}

