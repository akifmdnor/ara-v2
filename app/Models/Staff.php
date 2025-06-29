<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
class Staff extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $guard = 'staff';

    protected $table = 'staffs';

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'position',
        'email',
        'joined_date',
        'gender',
        'nric',
        'phone_number',
        'branch_id',
        'address',
        'city',
        'postal_code',
        'country',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function pictures()
    {
        return $this->hasMany('App\Models\Picture', 'model_id')->where('model_name', '=', 'staff');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('hasBranch', function (Builder $builder) {
            $builder->whereHas('branch');
        });
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

}
