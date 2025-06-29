<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeaturedPicture extends Model
{
    use SoftDeletes;
    protected $fillable = ['file_name', 'model_id'];



}
