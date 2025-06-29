<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerReview extends Model
{
    protected $table = 'customer_review';
    protected $fillable = ['booking_no', 'client_name', 'location', 'car_model_id', 'review'];

    public $timestamps = false;

    public function car_model()
    {
        return $this->belongsTo('App\Models\CarModel');
    }
}
