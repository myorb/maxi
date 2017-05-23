<?php

namespace App\Http\Controllers;

use App\Elevator;
use App\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ElevatorController extends Controller
{
    public function index(Request $request){
//        $user_agents = explode("\n", Storage::get( DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR . 'useragent_list.txt'));
//        var_dump($user_agents);



        (new Parser)->init();
//        var_dump((new Parser)->test());
        $model = new Elevator();
        return response(json_encode($model->all()));
    }

    public function create($atr){
        if(isset($atr['pars_url'])){
            $model = Elevator::where('pars_url', $atr['pars_url'])->first();
            if(!$model){
                $model->create($atr);
            }
        }
    }

}
