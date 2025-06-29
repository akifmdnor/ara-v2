<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeasonalDateTime extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'start_datetime',
        'end_datetime',
        'title',
        'price_day'
    ];

    public function seasonal_date_time_cars()
    {
        return $this->hasMany('App\SeasonalDateTimeCar');
    }

}
