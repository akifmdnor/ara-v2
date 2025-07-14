<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelSpecification extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'model_name',
        'doors',
        'seats',
        'luggage',
        'fuel_type',
        'fuel_tank',
        'transmission_type',
        'included',
        'group',
        'brand_logo',
        'brand',
        'model_code',
    ];

    protected $appends = ['picture_url'];

    public function pictures()
    {
        return $this->hasMany('App\Models\Picture', 'model_id')->where('model_name', '=', 'model_specification');
    }

    public function featured_pictures()
    {
        return $this->hasMany('App\FeaturedPicture', 'model_id');
    }

    public function car_models()
    {
        return $this->hasMany('App\Models\CarModel');
    }

    public function car_model()
    {
        return $this->belongsTo('App\Models\CarModel');
    }

    public function car_models_lowest()
    {
        return $this->hasOne('App\Models\CarModel')->orderBy('price_day', 'asc')->oldest();
    }

    public function getPictureUrlAttribute()
    {
        $file = optional($this->pictures()->first())->file_name;
        if ($file) {
            // Remove 'public/' or 'public\' from the start if present
            $file = preg_replace('#^public[\/]+#', '', $file);
            return config('app.v1_url') . '/storage/' . ltrim($file, '/');
        }
        return '/car.png';
    }


}
