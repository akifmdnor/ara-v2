<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class CarModel extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'model_name',
        'category',
        'security_deposit',
        'branch_id',
        'price_day',
        'price_hours',
        'price_day_2',
        'price_day_3',
        'price_day_4',
        'price_day_5',
        'price_day_6',
        'price_day_7',
        'price_day_14',
        'price_day_21',
        'price_day_28',
        'price_day_after_month',
        'price_day_branch',
        'price_hours_branch',
        'price_day_7_branch',
        'price_day_14_branch',
        'price_day_21_branch',
        'price_day_28_branch',
        'model_specification_id',
        'is_deactive',
        'added_by',
        'is_require_review',
    ];

    public function cars()
    {
        return $this->hasMany('App\Models\Car');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function pictures()
    {
        return $this->hasMany('App\Models\Picture', 'model_id')->where('model_name', '=', 'car_model');
    }

    public function addoncars()
    {
        return $this->hasMany('App\Models\AddOnCars');
    }

    // get addon name and price as array
    public function getAddonsAttribute()
    {
        return $this->addoncars->pluck('addon.title', 'addon.price')->toArray();
    }

    public function model_specification()
    {
        return $this->belongsTo('App\Models\ModelSpecification')->withTrashed();
    }

    public function seasonal_prices()
    {
        return $this->hasMany('App\Models\SeasonalPrice');
    }

    public function branch_seasonal_prices()
    {
        return $this->hasMany('App\Models\BranchSeasonalPrice');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('hasBranchAndCars', function (Builder $builder) {
            $builder->where(function ($query) {
                $query->where('added_by', 'HQ') // Always show HQ
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('added_by', 'BRANCH')
                            ->whereHas('cars'); // Ensure BRANCH has at least one car
                    });
            });
        });
    }

}
