<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Sunra\PhpSimple\HtmlDomParser;

class Parser
{
    public $AC;
    public $proxi_list;
    public $user_agents;
    static $total;

    function __construct()
    {
        $this->AC = new AngryCurl(__CLASS__.'::callback_function');
        $this->user_agents = explode("\n", Storage::get( DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR . 'useragent_list.txt'));
//        $this->proxi_list = explode("\n",Storage::get(DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR . 'proxy_list.txt'));
    }

    public function init(array $url=[]) {
        $AC = $this->AC;
        $AC->init_console();
        if($this->proxi_list) {
            $AC->load_proxy_list(
                $this->proxi_list,
                400,
                'http',
                'http://google.com',
                'title>G[o]{2}gle'
            );
        }
        //
//        curl 'http://elevatorist.com/karta-elevatorov-ukrainy/elevator/81-elevator-pk-podole'
//    -H 'Accept-Encoding: gzip, deflate, sdch'
//    -H 'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4'
//    -H 'Upgrade-Insecure-Requests: 1'
//    -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
//    -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'
//    -H 'Cache-Control: max-age=0'
//    -H 'Cookie: _ym_uid=1494845904427412157; PHPSESSID=hdbmnj8qsbti17r4fth1valis0; YII_CSRF_TOKEN=b6fd6b5eb26e04cf138383ef5e05542970bd57b7; path_current=yes; _ga=GA1.2.1986844944.1494845903; _gid=GA1.2.2029246849.1496086686'
//    -H 'Connection: keep-alive'
//    --compressed

        $AC->load_useragent_list($this->user_agents);
            foreach($url as $u)
                $AC->get(trim($u),[
                    'Accept-Encoding: gzip, deflate, sdch',
                    'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4',
                    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                ]);
            $AC->execute(2);
    }

    static function callback_function($response, $info, $request)
    {
        if($info['http_code']!==200)
        {
//            var_dump($request);
//            var_dump($info);
            AngryCurl::add_debug_msg(
                "->\t" .
//                 $request->options[CURLOPT_PROXY] .
                "\tFAILED\t" .
                $info['http_code'] .
                "\t" .
                $info['total_time'] .
                "\t" .
                $info['url']
            );
//            (new Elevator)->updateOrNew(['pars_url' => $info['url']]);
        }else{
            $html = HtmlDomParser::str_get_html($response);
            try {
                $content['pars_url'] = $info['url'];
                $content['html'] = $html->find('body',0);
                foreach($html->find('.elevmap_header-h1') as $div){
                    $content['title'] = $div->plaintext;
//                    var_dump($div->plaintext);
                }
                foreach($html->find('.elevmap_basic-info') as $div){
                    $a1 = explode(' ', $div->plaintext);
                    $a2 = array_filter(array_map('strip_tags',array_map('trim', $a1)));
                    $s = implode(' ', $a2);
//                    $content['basic_info'] = $s;

                    $n1 = strrpos($s,'Компания:');
                    $n2 = strrpos($s,'Сдача');
                    $n3 = strrpos($s,'Директор:');
                    $n4 = strrpos($s,'Тип элеватора:');
                    $n5 = strrpos($s,'Техническая');

                    $content['elevator_company']    = substr($s,$n1,$n2-$n1);
                    $content['elevator_start_date'] = substr($s,$n2,$n3-$n2);
                    $content['elevator_boss']       = substr($s,$n3,$n4-$n3);
                    $content['elevator_type']       = substr($s,$n4,$n5-$n4);

                }

                foreach($html->find('.elevmap_basic-logo') as $div){
                    $content['basic_logo'] = $div->innertext;
                }
//                foreach($html->find('.elevmap_elevator_info-stats') as $div){
//                    // $content['info'] = $div->plaintext;
//                    $content['additional_info'] = preg_replace('/\s+/', ' ',$div->plaintext);
//                }
                foreach($html->find('.address') as $div){
                    $content['address'] = $div->plaintext;
                }
                foreach($html->find('.link') as $div){
                    $content['link'] = $div->plaintext;
                }
                foreach($html->find('.phone') as $div){
                    $content['phone'] = $div->plaintext;
                }
                foreach($html->find('.email') as $div){
                    $content['email'] = $div->plaintext;
                }

                foreach($html->find('.storage') as $div){
                    $content['storage'] = $div->plaintext;
                }
                foreach($html->find('.storage-type') as $div){
                    $content['storage-type'] = $div->plaintext;
                }
                foreach($html->find('.metal-sylos') as $div){
                    $content['metal-sylos'] = $div->plaintext;
                }
                foreach($html->find('.dryers') as $div){
                    $content['dryers'] = $div->plaintext;
                }
                foreach($html->find('.dryer-power') as $div){
                    $content['dryer-power'] = $div->plaintext;
                }



                foreach($html->find('.filter') as $div){
                    $content['filter'] = $div->plaintext;
                }foreach($html->find('.filter-power') as $div){
                    $content['filter-power'] = $div->plaintext;
                }foreach($html->find('.transport') as $div){
                    $content['transport'] = $div->plaintext;
                }foreach($html->find('.transport-power') as $div){
                    $content['transport-power'] = $div->plaintext;
                }foreach($html->find('.aspiration') as $div){
                    $content['aspiration'] = $div->plaintext;
                }foreach($html->find('.car-reception') as $div){
                    $content['car-reception'] = $div->plaintext;
                }foreach($html->find('.car-reception-power') as $div){
                    $content['car-reception-power'] = $div->plaintext;
                }foreach($html->find('.rail-reception') as $div){
                    $content['rail-reception'] = $div->plaintext;
                }foreach($html->find('.rail-reception-power') as $div){
                    $content['rail-reception-power'] = $div->plaintext;
                }foreach($html->find('.embarkation') as $div){
                    $content['embarkation'] = $div->plaintext;
                }foreach($html->find('.embarkation-power') as $div){
                    $content['embarkation-power'] = $div->plaintext;
                }foreach($html->find('.loader-icon') as $div){
                    $content['loader-icon'] = $div->plaintext;
                }foreach($html->find('.fumigation') as $div){
                    $content['fumigation'] = $div->plaintext;
                }foreach($html->find('.certification') as $div){
                    $content['certification'] = $div->plaintext;
                }foreach($html->find('.developer') as $div){
                    $content['developer'] = $div->plaintext;
                }foreach($html->find('.automatization') as $div){
                    $content['automatization'] = $div->plaintext;
                }foreach($html->find('.building') as $div){
                    $content['building'] = $div->plaintext;
                }




            } catch (Exception $e) {

            }

            $array = array_map("trim", $content);
            foreach($array as $k=>$v){
                echo '$table->string("'.$k."\");\r\n";
//                $b[$k] = preg_replace('/\s+/', ' ',$v);
            }
            var_dump($array);
//            (new Elevator)->updateOrNew($array);
        }
    }

}




