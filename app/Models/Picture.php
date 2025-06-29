<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Picture extends Model
{
    use SoftDeletes;
    protected $fillable = ['model_id', 'model_name', 'file_name'];

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch', 'model_id');
    }
    public function car()
    {
        return $this->belongsTo('App\Models\Car', 'model_id');
    }

    public function addon()
    {
        return $this->belongsTo('App\AddOn', 'model_id');
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff', 'model_id');
    }
}
