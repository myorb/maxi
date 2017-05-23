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

    public function init($url=null) {
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
        if($url){
            $AC->load_useragent_list($this->user_agents);
            foreach($url as $u)
                $AC->get($u->url);
            $AC->execute(2);
        }else{
            $AC->load_useragent_list($this->user_agents);
            $usls =  explode("\n",Storage::get('urls.txt'));
            foreach ($usls as $value) {
                $AC->get(trim($value));
            }
            $AC->execute(5);
        }
    }

    static function callback_function($response, $info, $request)
    {
        if($info['http_code']!==200)
        {
            AngryCurl::add_debug_msg(
                "->\t" .
                // $request->options[CURLOPT_PROXY] .
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
                foreach($html->find('.elevmap_header-h1') as $div){
                    $content['title'] = $div->plaintext;
                    var_dump($div->plaintext);
                }
                foreach($html->find('.elevmap_basic-info') as $div){
                    $a1 = explode(' ', $div->plaintext);
                    $a2 = array_filter(array_map('strip_tags',array_map('trim', $a1)));
                    $s = implode(' ', $a2);
                    $content['basic_info'] = $s;

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
                foreach($html->find('.elevmap_elevator_info-stats') as $div){
                    // $content['info'] = $div->plaintext;
                    $content['additional_info'] = preg_replace('/\s+/', ' ',$div->plaintext);
                }
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
            } catch (Exception $e) {

            }

            $array = array_map("trim", $content);
            (new Elevator)->updateOrNew($array);
        }
    }

}




