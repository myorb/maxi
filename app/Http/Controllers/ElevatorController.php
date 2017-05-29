<?php

namespace App\Http\Controllers;

use Mail;
use App\Elevator;
use App\Parser;
use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ElevatorController extends Controller
{
    public function index(Request $request){
        $parser = new Parser();
        $t = Url::where('status','')->paginate(1);
//        var_dump($t['0']->url);die();
        foreach($t as $u){
            $urls[] = $u->url;
            $u->status = 'in_work';
                $u->save();
        }
        try {
            $parser->init($urls);
        } catch (Exception $e) {

        }

        $elevators = Elevator::all();
//        foreach($elevators as $elevator){
//            $ec = mb_ereg_replace('Компания:','',$elevator->elevator_company);
//            $elevator->elevator_company = trim($ec);
//            $eb = mb_ereg_replace('Директор:','',$elevator->elevator_boss);
//            $elevator->elevator_boss = trim($eb);
//            $et = mb_ereg_replace('Тип элеватора:','',$elevator->elevator_type);
//         do   $elevator->elevator_type = trim($et);
//            $es = mb_ereg_replace('Сдача в эксплуатацию:','',$elevator->elevator_start_date);
//            $elevator->elevator_start_date = trim($es);
//            $elevator->save();
//
////            var_dump($e);
//        }
        var_dump(true);

//        $url = new Url();




//        (new Parser)->init();
//        var_dump('ok');
//        var_dump((new Parser)->test());
//        $model = new Elevator();
//        response($model->count)
//        return response(json_encode($model->all()));
    }

    public function mail(){
//        Mail::send('emails.reminder', ['user' => 'ok'], function ($m) {

//            $m->from(env('MAIL_USERNAME'), 'Your Application');

//            $m->to("itdep24@gmail.com", "someone")->subject('Your Reminder!');


//            $message->from(env('MAIL_USERNAME'));
//            $message->to("itdep24@gmail.com", "someone");
//            $message->subject("hi checking");
//            $message->getSwiftMessage();
//        });


//        $port['host'] = env('MAIL_HOST');
//        $port['number'] = env('MAIL_PORT');
//
//        $to      = 'itdep24@gmail.com';
//        $subject = 'the subject';
//        $message = 'hello';
//        $headers = 'From: test@agroxy.com' . "\r\n" .
//            'Reply-To: test@agroxy.com' . "\r\n" .
//            'X-Mailer: PHP/' . phpversion();
//
//        mail($to, $subject, $message, $headers);

var_dump(true);

//        \Mail::send(
//            'textxtt',
//            function ($m) {
//                $m->from([env('MAIL_USERNAME')]);
//                $m->to(['itdep24@gmail.com']);
//                $m->subject('Crash Report');
//            }
//        );
//        var_dump(Mail::failures());
    }

    public function create($atr){
        if(isset($atr['pars_url'])){
            $model = Elevator::where('pars_url', $atr['pars_url'])->first();
            if(!$model){
                $model->create($atr);
            }
        }
    }


    public function urls(){
        $usls =  explode("\n",Storage::get('urls.txt'));
        $counter = 0;
        foreach (array_filter(array_map('trim',$usls)) as $value) {
            Url::create(['url'=>$value]);
            $counter++;
        }
        var_dump($counter);
    }

//    public function

}
