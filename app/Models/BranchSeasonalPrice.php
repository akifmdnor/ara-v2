<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BranchSeasonalPrice extends Model
{
    protected $fillable = [
        'car_model_id',
        'price_day',
        'price_hours',
        'price_day_7',
        'price_day_14',
        'price_day_21',
        'price_day_28',
        'start_date',
        'end_date',
        'is_promo',

    ];


    public function car_model()
    {
        return $this->belongsTo('App\Models\CarModel');
    }
}
