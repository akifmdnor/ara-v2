<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'plat_number',
        'car_model_id',
        'roadtax_expiry_date',
        'owner_name',
        'owner_ic',
        'added_by',
        'year',
        'status',
        'reference_id',
    ];


    protected $appends = ['isAvailable'];

    public function pictures()
    {
        return $this->hasMany('App\Models\Picture', 'model_id')->where('model_name', '=', 'car');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function car_model()
    {
        return $this->belongsTo('App\Models\CarModel');
    }

    public function unavailablePeriods()
    {
        return $this->hasMany('App\Models\UnavailableCars', 'car_id');
    }

    public function scopeAvailable($query)
    {
        $now = now()->toDateTimeString();
        return $query->whereDoesntHave('unavailablePeriods', function ($query) use ($now) {
            $query->where('start', '<=', $now)
                ->where('end', '>=', $now);
        });
    }

    public function scopeNotAvailable($query)
    {
        $now = now()->toDateTimeString();
        return $query->whereHas('unavailablePeriods', function ($query) use ($now) {
            $query->where('start', '<=', $now)
                ->where('end', '>=', $now);
        });
    }

    public function getIsAvailableAttribute()
    {
        $now = now()->toDateTimeString();
        $unavailable = $this->unavailablePeriods()->where('start', '<=', $now)
            ->where('end', '>=', $now)
            ->exists();
        return !$unavailable;
    }

    //is car available for booking between 2 date (unavailalecars date must not overlap with the date)
    public function scopeIsAvailableForBooking($query, $start, $end)
    {
        return $query->whereDoesntHave('unavailablePeriods', function ($query) use ($start, $end) {
            $query->where(function ($query) use ($start, $end) {
                $query->whereBetween('start', [$start, $end])
                    ->orWhereBetween('end', [$start, $end])
                    ->orWhere(function ($query) use ($start, $end) {
                        $query->where('start', '<=', $start)
                            ->where('end', '>=', $end);
                    });
            });
        });
    }

}
