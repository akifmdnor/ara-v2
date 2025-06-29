<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageManager extends Model
{
    protected $table = 'homepage_manager';
    protected $fillable = ['type', 'picture'];

    public $timestamps = true;

}
