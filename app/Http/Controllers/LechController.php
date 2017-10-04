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
            $site = file_get_contents($request->get('link'));

            $patternTitle = '/<h1 class="title-32 vmargin8" itemprop="name">(.*)<\/h1>/i';
            preg_match_all($patternTitle, $site, $title);

            $patternPrice = '/data-sale-price="(.*)" (.*)/i';
            preg_match_all($patternPrice, $site, $price);

            echo json_encode([
                'title' => isset($title[1][0]) ? $title[1][0] : '',
                'price' => isset($price[1][0]) ? $price[1][0] : '',
            ]);
        }

        if ($nike) {
            $site = $this->getSslPage($request->get('link'));

            $patternTitle = '/<h1 class="exp-product-title nsg-font-family--platform">(.*)<\/h1>/i';
            preg_match_all($patternTitle, $site, $title);

            $patternPrice = '/<span class="exp-pdp-local-price js-pdpLocalPrice">(.*)<\/span>/i';
            preg_match_all($patternPrice, $site, $price);

            echo json_encode([
                'title' => isset($title[1][0]) ? $title[1][0] : '',
                'price' => isset($price[1][0]) ? $price[1][0] : '',
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
                'price' => $priceGet[0]->productPrice->current->value,
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
}
