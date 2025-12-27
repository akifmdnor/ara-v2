<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'rating',
        'description',
        'user_id',
        'booking_id',
    ];

    public function picture()
    {
        return $this->hasOne('App\Models\Picture', 'model_id', 'carmodel_id')->where('model_name', 'car_model');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function booking()
    {
        return $this->hasOne('App\Models\Booking');
    }

    public function car()
    {
        return $this->belongsTo('App\Models\Car');
    }

    public function carModel()
    {
        return $this->hasOne('App\Models\CarModel', 'id', 'carmodel_id');
    }

}
