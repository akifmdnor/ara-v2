<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddOnBookings extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'booking_id',
        'addon_id',
        'addon_price',
        'amount',
    ];

    public function car_model()
    {
        return $this->belongsTo('App\Models\Booking');
    }

    public function addon()
    {
        return $this->belongsTo('App\Models\AddOn');
    }

}
