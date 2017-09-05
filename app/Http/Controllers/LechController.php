<?php
namespace App\Http\Controllers;
use Atl\Foundation\Request;

use App\Http\Components\Controller as baseController;

class LechController extends baseController{

	public function __construct(){
		parent::__construct();
		$this->userAccess();

	}

	public function lech( Request $request ){
		$site = file_get_contents($request->get('link'));

		$patternTitle = '/<h1 class="title-32 vmargin8" itemprop="name">(.*)<\/h1>/i';
		preg_match_all($patternTitle, $site , $title);

		$patternPrice= '/data-sale-price="(.*)" (.*)/i';
		preg_match_all($patternPrice, $site , $price);

		pr($price);

	
	}

}