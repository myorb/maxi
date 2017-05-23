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
        'link', 'phone', 'email','pars_url','note',
    ];

    public function updateOrNew($atr)
    {
//        if(isset($atr['pars_url']) && $atr['pars_url']){
        $model = static::where('pars_url','=', $atr['pars_url'])->first();

        if(!$model){
            $url = Url::where('url','=',$atr['pars_url'])->first();
            $model = new Elevator();
            $atr['note'] = $url->id;
            $model::create($atr);
            $url->status = 'done';
            $url->note = $model->id;
            $url->save();
        }

        return $this;
    }



}
