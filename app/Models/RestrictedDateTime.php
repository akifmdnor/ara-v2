<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestrictedDateTime extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'start_datetime',
        'end_datetime',
        'title',
    ];

    public function restricted_date_time_branches()
    {
        return $this->hasMany('App\RestrictedDateTimeBranch');
    }
}
