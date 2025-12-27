<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;
    protected $fillable = ['booking_id', 'file_name'];

    public function booking()
    {
        return $this->belongsTo('App\Models\Booking');
    }
}
