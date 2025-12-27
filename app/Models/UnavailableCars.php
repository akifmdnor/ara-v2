<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnavailableCars extends Model
{
    protected $fillable = [
        'car_id',
        'start',
        'end',
        'reason',
        'booking_id'
    ];

    public function car()
    {
        return $this->belongsTo('App\Models\Car');
    }

    public function booking()
    {
        return $this->belongsTo('App\Models\Booking');
    }


}
