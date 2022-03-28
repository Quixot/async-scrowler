<?php
	$regexpPrices = "~columns product-Wrap(.+)</button>~isU";
	$regexpPrice = "~class=\"card__name.*href=\"(.+)\".*>(.+)</a>.*class=\"card__price-sum.*>(.+)<~isU";
	$regexpPrice2 = "~class=\"card__name.*href=\"(.+)\".*>(.+)</a~isU";

	$avail = "Немає в наявності";

	$itemsArray = array();

	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

	function callback_two($response) {
	global $regexpPrices;
	global $regexpPrice;
	global $regexpPrice2;
	global $avail;
	global $itemsArray;

	if ($response) {
		echo 'response ok'.PHP_EOL;

	  preg_match_all($regexpPrices, $response, $matches, PREG_SET_ORDER);
		//print_r($matches);
	  foreach ($matches as $key) {
	  	preg_match($regexpPrice, $key[1], $matches2);

	  	$matches2[1] = 'https://epicentrk.ua'.trim($matches2[1]);
	  	$matches2[2] = trim(strip_tags($matches2[2]));	

	  	if (@strripos($matches2[3], '.') !== false) {
	  		$pricecl = preg_replace('~[\D]+~', '' , substr($matches2[3], 0, strripos($matches2[3], '.')));
	  	} else {
	  		$pricecl = preg_replace('~[\D]+~', '' , $matches2[3]);
	  	}
	
	  	if ($matches2[1] && $matches2[2]) {	
		  	price_change_detect($matches2[1], $matches2[2], $pricecl, date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
		  	$itemsArray[$matches2[1]] = array($matches2[2], $pricecl, date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');
				AngryCurl::add_debug_msg($matches2[1].' | '.$matches2[2].' | '.$pricecl);	
	  	}	else {
	  		preg_match($regexpPrice2, $key[1], $matches2);
	  		print_r($matches2);
		  	$matches2[1] = 'https://epicentrk.ua'.trim($matches2[1]);
		  	$matches2[2] = trim(strip_tags($matches2[2]));
		  	$pricecl = 0;
	  		if ($matches2[1] && $matches2[2]) {	
			  	price_change_detect($matches2[1], $matches2[2], $pricecl, date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
			  	$itemsArray[$matches2[1]] = array($matches2[2], $pricecl, date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');
					AngryCurl::add_debug_msg($matches2[1].' | '.$matches2[2].' | '.$pricecl);	
	  		}
	  	}	
		}
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}
