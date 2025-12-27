<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $fillable = [
        'first_name',
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
    ];

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function picture()
    {
        return $this->hasMany('App\Models\Picture', 'model_id')->where('model_name', '=', 'customer');
    }

}
