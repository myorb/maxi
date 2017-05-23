<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Elevator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'basic_info', 'elevator_company',
        'elevator_start_date', 'elevator_boss', 'elevator_type',
        'basic_logo', 'additional_info', 'address',
        'link', 'phone', 'email',
    ];

    public function addOrNew($atr)
    {
        if(isset($atr['pars_url'])){
            $model = static::where('pars_url', $atr['pars_url'])->first();
            if(!$model){
                self::create($atr);
            }
        }
        return $this;
    }



}
