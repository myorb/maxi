<?php

namespace App\Http\Controllers;

use App\Elevator;
use App\Parser;
use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ElevatorController extends Controller
{
    public function index(Request $request){
        $parser = new Parser();
        $t = Url::where('status','')->paginate(300);
        foreach($t as $u){
                $u->status = 'in_work';
                $u->save();
        }
        try {
            $parser->init($t);
        } catch (Exception $e) {

        }

//        $url = new Url();




//        (new Parser)->init();
//        var_dump('ok');
//        var_dump((new Parser)->test());
//        $model = new Elevator();
//        response($model->count)
//        return response(json_encode($model->all()));
    }

    public function create($atr){
        if(isset($atr['pars_url'])){
            $model = Elevator::where('pars_url', $atr['pars_url'])->first();
            if(!$model){
                $model->create($atr);
            }
        }
    }

//    public function

}
