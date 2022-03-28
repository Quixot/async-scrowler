<?php
//aleco.com.ua
$regexpPrices  = "~product-item product-item__tile column(.+)data-product-id~isU"; 
$regexpPrices2 = "~href=.*href=\"(.+)\".*>(.+)</a.*class=\"price--title.*<span.*>(.+)</span~isU";
$regexpPrices3 = "~href=.*href=\"(.+)\".*>(.+)</a~isU";

$itemsArray = array();


	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

function callback_two($response) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);
	  foreach ($matches2 as $key) {
	  	if (strripos(mb_strtolower($key[0]), 'уценка') === false) {
	  		preg_match($regexpPrices2, $key[1], $matches);

	  		if (@$matches[1] && $matches[2]) {
					$matches[1] = trim($matches[1]);
					$matches[2] = trim(strip_tags($matches[2]));
					$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);

					if (@$matches[1] && $matches[2]) {
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}						
	  		} else {
					preg_match($regexpPrices3, $key[1], $matches);
					//print_r($matches);
					if (@$matches[1] && $matches[2]) {
						$matches[1] = trim($matches[1]);
						$matches[2] = trim(strip_tags($matches[2]));
						$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
						
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}			
	  		}	
	  	} // Уценка
	  }
	 }

