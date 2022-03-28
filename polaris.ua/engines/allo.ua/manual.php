<?php
$regexpPrices  = "~<li class=\"item\" id.*(.+)</li>~isU"; 
$regexpPrices2 = "~<a.*class=\"product-name\".*href=\"(.+)\".*>(.+)<.*<span.*class=\"sum\".*>(.+)<.*template=\"buy_small\"(.+)>~isU"; // Режем карточки товара
$regexpPrices3 = "~<a.*class=\"product-name\".*href=\"(.+)\".*>(.+)<.*<span.*class=\"new_sum\".*>(.+)<.*template=\"buy_small\"(.+)>~isU"; // Перечёркнутая цена
$regexpPrices4 = "~<a.*class=\"product-name\".*href=\"(.+)\".*>(.+)<~isU"; // Режем карточки товара


	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

	function callback_two($response) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $itemsArray;
	global $bad_urls;
	global $time_start;
	global $region;
	global $regionRu;
	global $regexpRegion;

	AngryCurl::add_debug_msg(PHP_EOL.'manual');
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg('manual'); 

  if ($info['http_code'] !== 200) {
    $bad_urls[] = 'manual'; 	
		if (round(microtime(1) - $time_start, 0) >= 380) { $bad_urls = array(); }      
  } else {
		preg_match("~class=\"city-name.*>(.+)<~isU", $response, $region);
		AngryCurl::add_debug_msg('request  region: '.$city);
		AngryCurl::add_debug_msg('response region: '.trim($region[1])); 

		sleep(2);

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);
	  foreach ($matches2 as $key) {
	  	if (strripos(mb_strtolower($key[0]), 'уценка') === false) {
	  		if (strripos($key[1], 'new_sum') !== false) {
					preg_match($regexpPrices3, $key[1], $matches);

					$matches[1] = trim($matches[1]);
					if (stripos($matches[1], 'http') === false) $matches[1] = 'https:'.$matches[1];
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
					$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);

					if (@$matches[1] && $matches[2]) {
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}						
	  		} else {
					preg_match($regexpPrices2, $key[1], $matches);
					//print_r($matches);
					if (@$matches[1] && $matches[2]) {
						$matches[1] = trim($matches[1]);
						if (stripos($matches[1], 'http') === false) $matches[1] = 'https:'.$matches[1];
						$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
						$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
						
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}	else {
						preg_match($regexpPrices4, $key[1], $matches);
						if (@$matches[1] && $matches[2]) {
							$matches[1] = trim($matches[1]);
							if (stripos($matches[1], 'http') === false) $matches[1] = 'https:'.$matches[1];
							$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
							$matches[3] = '0';

							price_change_detect(trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
							$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');
							AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
						}
					}				
	  		}	
	  	} // Уценка
	  }
  }
}