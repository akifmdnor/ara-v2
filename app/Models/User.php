<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_name',
        'birth_date',
        'email',
        'gender',
        'nric',
        'phone_number',
        'address',
        'city',
        'postal_code',
        'country',
        'password',
        'provider',
        'provider_id'
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function picture()
    {
        return $this->hasMany('App\Models\Picture', 'model_id')->where('model_name', '=', 'customer');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            // Remove 'public/' or 'public\' from the start if present
            return config('app.v1_url') . '/storage/agent/' . ltrim($this->profile_photo, '/');
        }
        return asset('images/avatar.png');
    }
}
