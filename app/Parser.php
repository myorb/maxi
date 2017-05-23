<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Sunra\PhpSimple\HtmlDomParser;

class Parser
{
    public $AC;
    public $proxi_list;
    public $user_agents;

    function __construct()
    {
        $this->AC = new AngryCurl(__CLASS__.'::callback_function');
//        $this->proxi_list = explode("\n",Storage::get(DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR . 'proxy_list.txt'));
        $this->user_agents = explode("\n", Storage::get( DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR . 'useragent_list.txt'));

    }

    public function init() {
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
        $AC->load_useragent_list($this->user_agents);
        $usls =  explode("\n",Storage::get('urls.txt'));
        foreach ($usls as $value) {
            $AC->get(trim($value));
        }
        $AC->execute(5);
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

                // foreach ($html->find('.elevmap_basic-info',0)->find('p',2)->find('strong') as $p) {
                //     // foreach ($el->find('strong') as $e2) {
                //         var_dump($p->plaintext);
                //     // }
                // }
                // var_dump($html->find('.elevmap_basic-info p',0)->next_sibling()->next_sibling()->innertext );

                // $content['elevator_company'] = $html->find('.elevmap_basic-info',0)->find('p',0)->find('strong',0)->innertext;
                // $content['elevator_start_date'] = $html->find('.elevmap_basic-info',0)->find('p',1)->find('strong',0)->innertext;
                // $content['elevator_boss'] = $html->find('.elevmap_basic-info',0)->find('p',2)->find('strong',0)->innertext;
                // $content['elevator_type'] = $html->find('.elevmap_basic-info',0)->find('p',3)->find('strong',0)->innertext;


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


            //           foreach($html->find('.catalog  .clearfix .tech-char') as $div){
            //               $content[] = $div->plaintext;
            //               var_dump($div->plaintext);
            //           }
            //   if(count($content) == 500){
            // echo "<hr>".count($content);
            $array = array_map("trim", $content);
            $model = (new Elevator)->addOrNew($array);
            var_dump($array);
            // $fp = fopen('file.csv', 'w');
            // foreach ($array as $fields) {
            // fputcsv($fp, $array);
            // }
            // fclose($fp);
            // $str = implode ("\n", $array);
            // $str = json_encode($content);
            // $j = json_encode($array) ;
            // file_put_contents ("data.txt", $j, FILE_APPEND | LOCK_EX);
// end... if more then 500 rows
            // die('all done');
            // }
            // var_dump(json_decode($j));
        }
    }

}




