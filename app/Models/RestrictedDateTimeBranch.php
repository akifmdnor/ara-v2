<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestrictedDateTimeBranch extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'restricted_date_time_id',
        'branch_id',
    ];

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function restricted_date_time()
    {
        return $this->belongsTo('App\Models\RestrictedDateTime');
    }
}
