<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'car_model_id',
        'car_id',
        'staff_id',
        'branch_id',
        'user_id',
        'pickup_datetime',
        'dropoff_datetime',
        'pickup_location',
        'dropoff_location',
        'driver_name',
        'driver_IC',
        'driver_license',
        'driver_mobile_number',
        'driver_age',
        'booking_status',
        'payment_status',
        'contract_status',
        'car_condition_status',
        'duration_days',
        'duration_hours',
        'amount',
        'amount_distance',
        'amount_rent',
        'amount_addon',
        'amount_addon_branch',
        'pickup_distance',
        'dropoff_distance',
        'mode',
        'pickup_latitude',
        'pickup_longitude',
        'dropoff_latitude',
        'dropoff_longitude',
        'notes',
        'amount_secd',
        'amount_paid',
        'amount_delivery',
        'amount_dropoff',
        'coupon',
        'amount_rent_per_day',
        'duration_days_real',
        'duration_hours_real',
        'offered_rental_price',
        'addon_charge_by_admin',
        'deliver_pickup_charge_by_admin',
        'assistant_staff_id',
        'amount_sst',
        'video_link_before',
        'video_link_after',
    ];

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch')->withTrashed();
    }

    public function staff()
    {
        return $this->belongsTo('App\Models\Staff')->withTrashed();
    }

    public function assistant_staff()
    {
        return $this->belongsTo('App\Models\Staff', 'assistant_staff_id')->withTrashed();
    }

    public function car()
    {
        return $this->belongsTo('App\Models\Car')->withTrashed();
    }

    public function car_model()
    {
        return $this->belongsTo('App\Models\CarModel')->withTrashed();
    }


    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
    }

    public function car_conditions()
    {
        return $this->hasMany('App\Models\CarCondition');
    }

    public function addonbookings()
    {
        return $this->hasMany('App\Models\AddOnBookings');
    }

    public function contract()
    {
        return $this->hasOne('App\Models\Contract');
    }

    public function pictures()
    {
        return $this->hasMany('App\Models\Picture', 'model_id')->where('model_name', '=', 'booking');
    }

}
