<?php
switch (EXTRA_PARAM) {
case 'moscow': $region = '8'; break;
case 'spb': $region = '2'; break;
case 'kazan': $region = '4'; break;
case 'novgorod': $region = '3'; break;
case 'samara': $region = '6'; break;
case 'ufa': $region = '7'; break;
case 'yekaterinburg': $region = '5'; break;
 	default:
 		die("Unknown region\n");  	 		
}

	$regexpPrices  = "~<article(.+)</article~isU";
	$regexpPrices2 = "~<a itemprop=\"name\" href=\"(.+)\".*>(.+)<.*itemprop=\"price\">(.+)<~isU";
	$regexpRegion = "~class=\"city.*>(.+)</a~isU";

//$itemsArray = array();

	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

	function callback_two($response) {
	global $regexpPrices;
	global $regexpPrices2;

	global $regexpRegion;


	global $itemsArray;
	global $city;

	//file_put_contents('/var/www/engines/rbt.ru/content.txt', $response);
//die();

		if (strlen($response) > 500) {
			echo 'response ok manual'.PHP_EOL;
			preg_match($regexpRegion, $response, $region);

			echo 'request  region: '.$city.PHP_EOL;
			echo 'response region: '.trim($region[1]).PHP_EOL;

			if (stripos(trim($region[1]), $city) === false) {
				//die('Неправильный регион!<br>');
			}

		  preg_match_all($regexpPrices, $response, $matches_items, PREG_SET_ORDER);

			foreach ($matches_items as $key) {
		  	if (strripos($key[1], 'В наличии') !== false) {
		  		preg_match($regexpPrices2, $key[1], $matches);
		  		if ($matches[1] && $matches[2]) {
			  		$matches[1] = 'https://www.maxidom.ru'.trim($matches[1]);
			  		$matches[2] = trim($matches[2]);
			  		$matches[3] = preg_replace('~[^\d]+~', '' , $matches[3]);
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');		
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);	
		  		}			
				}
			}
			echo 'Общее к-во: '.count($matches2).PHP_EOL;

			return 1;
		}
}