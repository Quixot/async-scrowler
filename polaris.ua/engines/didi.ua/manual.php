<?php
$regexpPrices  = "~<section(.+)</section>~isU"; 
$regexpPrices2 = "~href=\"(.+)\".*itemprop=\"name\">(.+)</.*itemprop=\"price\">(.+)<~isU";
$regexpPrices3 = "~href=\"(.+)\".*itemprop=\"name\">(.+)</~isU";

$itemsArray = array();

	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response);

	function callback_two($response) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;


	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);
	  foreach ($matches2 as $key) {
	  	if (strripos(mb_strtolower($key[0]), 'уценка') === false) {
	  		if (strripos($key[1], 'Add to cart') !== false) {
					preg_match($regexpPrices2, $key[1], $matches);

					$matches[1] = 'https://didi.ua/'.trim($matches[1]);
					
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
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
						$matches[1] = 'https://didi.ua/'.trim($matches[1]);
						
						$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
						$matches[3] = '0';
						
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}		
	  		}	
	  	} // Уценка
	  }
  }
