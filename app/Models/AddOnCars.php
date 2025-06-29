<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddOnCars extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'car_model_id',
        'addon_id',
        'addon_price',
    ];

    public function car_model()
    {
        return $this->belongsTo('App\Models\CarModel');
    }

    public function addon()
    {
        return $this->belongsTo('App\AddOn');
    }


}
