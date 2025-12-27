<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationHistory extends Model
{
    protected $table = 'location_history';

    protected $fillable = [
        'branch_id',
        'branch_name',
        'search_latitude',
        'search_longitude',
        'search_location_name',
        'distance_km'
    ];

    protected $casts = [
        'search_latitude' => 'decimal:8',
        'search_longitude' => 'decimal:8',
        'distance_km' => 'decimal:2'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
