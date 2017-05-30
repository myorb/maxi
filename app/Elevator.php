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
        'basic_info',
        'additional_info',
        'note',
        'html',
        'url_id',
        "pars_url",
        "html",
        "title",
        "elevator_company",
        "elevator_start_date",
        "elevator_boss",
        "elevator_type",
        "basic_logo",
        "address",
        "link",
        "phone",
        "email",
        "storage",
        "storage-type",
        "metal-sylos",
        "dryers",
        "dryer-power",
        "filter",
        "filter-power",
        "transport",
        "transport-power",
        "aspiration",
        "car-reception",
        "car-reception-power",
        "rail-reception",
        "rail-reception-power",
        "embarkation",
        "embarkation-power",
        "loader-icon",
        "fumigation",
        "certification",
        "developer",
        "automatization",
        "building",
    ];

    public function updateOrNew($atr)
    {
//        if(isset($atr['pars_url']) && $atr['pars_url']){
        $model = static::where('pars_url','=', $atr['pars_url'])->first();

        if(!$model){
            $url = Url::where('url','=',$atr['pars_url'])->first();
            $model = new Elevator();
            $atr['url_id'] = $url->id;
            $model::create($atr);
            $url->status = 'done';
            $url->note = $model->id;
            $url->save();
        }

        return $this;
    }



}
