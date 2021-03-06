<?php

namespace app\Http\Controllers;

use Atl\Foundation\Request;
use App\Http\Components\Controller as baseController;

class LechController extends baseController
{
    public function __construct()
    {
        parent::__construct();
        $this->userAccess();
    }

    public function lech(Request $request)
    {
        $adidas = strpos($request->get('link'), 'adidas.co.uk');
        $nike = strpos($request->get('link'), 'store.nike.com');
        $asos = strpos($request->get('link'), 'asos.com');

        if ($adidas) {
            $exAdidas = explode('/', $request->get('link'));
            if( isset( $exAdidas[4] ) ) {
                $exAdidas = explode('.', $exAdidas[4]);
               
                // $apiAdidas = file_get_contents('https://www.adidas.co.uk/api/products/'.$exAdidas[0]);
                // $apiAdidas = json_decode($apiAdidas, true);

                // echo json_encode([
                //     'title' => $apiAdidas['name'],
                //     'price' => $this->ceil($apiAdidas['pricing_information']['standard_price']),
                //     'code' => $apiAdidas['id'],
                // ]);

                echo json_encode([
                    'title' => 'Null',
                    'price' => 0,
                    'code' => 'Null',
                ]);
            }
        }
   
        if ($nike) {
            $site = $this->getSslPage($request->get('link'));

            $patternTitle = '/<h1 class="exp-product-title nsg-font-family--platform">(.*)<\/h1>/i';
            preg_match_all($patternTitle, $site, $title);

            $patternPrice = '/<span class="exp-pdp-local-price js-pdpLocalPrice">(.*)<\/span>/i';
            preg_match_all($patternPrice, $site, $price);

            echo json_encode([
                'title' => isset($title[1][0]) ? $title[1][0] : '',
                'price' => isset($price[1][0]) ? $this->ceil($price[1][0]) : '',
            ]);
        }

        if ($asos) {
            $ex = explode('prd/', $request->get('link'));
            $ex = explode('?', $ex[1]);
            $price[0] = [];

            if (isset($ex[0])) {
                $price = file_get_contents('http://www.asos.com/api/product/catalogue/v2/stockprice?productIds='.$ex[0].'&store=COM&currency=GBP');
                $priceGet = (json_decode($price));
            }

            $site = file_get_contents($request->get('link'));
            $patternTitle = '/title>(.*)<\/title>/i';
            preg_match_all($patternTitle, $site, $title);

            if (isset($title[1][0])) {
                $title[1][0] = str_replace('ASOS | ', '', $title[1][0]);
            }

            echo json_encode([
                'title' => isset($title[1][0]) ? $title[1][0] : '',
                'price' => $this->ceil($priceGet[0]->productPrice->current->value),
            ]);
        }
    }

    public function getSslPage($url)
    {
        $opts = array('http' => array(
            'method' => 'POST',
            'header' => "Content-Type: text/xml\r\n".
              'Authorization: Basic '.base64_encode("$https_user:$https_password")."\r\n",
            'content' => $body,
            'timeout' => 60,
          ),
        );

        $context = stream_context_create($opts);

        $result = file_get_contents($url, false, $context, -1, 40000);
    }

    public function ceil($number){
        $exp = explode('.',$number);

        $before = $exp[0];
        $after = '';

        if (isset( $exp[1] )) {
            if( 95 <= $exp[1] ) {
                $before = $exp[0] + 1;
            }else if( 45 <= $exp[1] && 95 > $exp[1] ) {
                $after = '.50';
            }else{
                $after = '.'.$exp[1];
            }
        }

        return $before.$after;
    }

    public function rounding(Request $request)
    {

    }

    public function checkToken($url){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}
