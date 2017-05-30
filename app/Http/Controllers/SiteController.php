<?php

namespace App\Http\Controllers;

use App\Elevator;
use Geocoder\Laravel\Facades\Geocoder;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index(Request $request){
//        var_dump(true);
//        return view('map');

        $elevators = Elevator::paginate(3);
        foreach($elevators as $el){
            var_dump($el->address);
            $place = array_map('trim',explode(',',$el->address));

            try {
            $g = Geocoder::geocode($place[1].', '.$place[2])->get();
//                var_dump($g[0]);
                foreach($g as $v){
                    var_dump( $v->getLatitude() );
                    var_dump( $v->getLongitude() );
                }
//
            } catch (\Exception $e) {
                var_dump($e->getMessage());
//                throw new Exception(1143, null, $e);
            }

        }
//        $place = explode(',',$el->address);
//        var_dump($place);
//        var_dump('Украина '.$place[0].', '.$place[1]);

//        $g = Geocoder::geocode('Ukraine, '.$el->address)->all();
//        var_dump($g);
//        $g = Geocoder::geocode('Ukraine '.$place[1])->all();
//        var_dump($g);
    }


}
