<?php
	$regexpPrices  = "~class=\"sku-card-small\">(.+)</button>~isU";
	$regexpPrices2 = "~href=\"(.+)\".*__title\">(.+)<.*class=\"price__primary.*>(.+)<~isU";
	//$itemsArray = array();

	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response);

	function callback_two($response) {
	global $regexpPrices;
	global $regexpPrices2;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	if ($response) {
		echo 'response ok'.PHP_EOL;
		//file_put_contents('/var/www/polaris/engines/dns-shop.ru/content.txt', $response);

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER);
	  //print_r($matches2);
  	preg_match_all($regexpPrices, $response, $matches_items, PREG_SET_ORDER);
  	//print_r($matches_items);
  	foreach ($matches_items as $key) {
	  	if (strripos($key[1], 'Добавить в список покупок') !== false) {
	  		preg_match($regexpPrices2, $key[1], $matches);
	  		if ($matches[1] && $matches[2]) {
		  		$matches[1] = 'https://lenta.com'.trim($matches[1]);
		  		$matches[2] = trim($matches[2]);
		  		$matches[3] = preg_replace('~[^\d]+~', '' , $matches[3]);
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');		
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);	
	  		}			
			}
		}
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}