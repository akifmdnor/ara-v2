<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class RecentBooking extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'model_name',
        'price_per_day',
        'location',
        'model_specification_id',
        'rental_days',
    ];

    public function model_specification()
    {
        return $this->belongsTo('App\Models\ModelSpecification')->withTrashed();
    }


}
