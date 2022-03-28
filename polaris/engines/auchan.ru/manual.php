<?php
	$regexpPrices  = "~<article(.+)</article~isU";
	$regexpPrices2 = '~"description":"(.+)".*"price":"(.+)".*href="(.+)"~isU';

	$regjson = "~</path></svg>(.+)</span><button type=\"button\" id=\"checkAddressHeader\"~isU";

	$name = "~<h1.*>(.+)<~isU";
	$price = "~data-bind=\"text:formatedPrice\">(.+)<~isU";
	$regexpRegion = "~data-bind=\"text:cityName\">(.+)<~isU";

	$isInstock = "~itemprop=\"availability\" href=\"(.+)\"~isU";

	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);
	

function callback_two($response) {
  global $regexpPagin;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;
	global $regjson;

	global $time_start;
	global $itemsArray;
$itemsArray = array();
	//file_put_contents('/var/www/engines/rbt.ru/content.txt', $response);
//die();
	if ($response) {



  	preg_match_all($regexpPrices, $response, $matches_items, PREG_SET_ORDER);
  	//print_r($matches_items);

		//file_put_contents('/var/www/polaris/engines/auchan.ru/print.txt', print_r($matches_items, 1));

  	foreach ($matches_items as $key) {
  		preg_match($regexpPrices2, $key[1], $matches);
  		//print_r($matches);
  		if ($matches[1] && $matches[2]) {
	  		$url = 'https://www.auchan.ru'.trim($matches[3]);
	  		$name = trim($matches[1]);
	  		if (stripos($matches[2], '.') !== false) {
	  			$matches[2] = substr($matches[2], 0, stripos($matches[2], '.'));
	  			$price = preg_replace('~[^\d]+~', '' , $matches[2]);
	  		} else {
	  			$price = preg_replace('~[^\d]+~', '' , $matches[2]);
	  		}
	  		
				price_change_detect($url, $name, $price, date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$url] = array($name, $price, date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');		
				AngryCurl::add_debug_msg($matches[1].' | '.$name.' | '.$price);	
  		}			
		}

		return 1;
		
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}
