<?php
//mta.ua
$itemsArray = array();

$regexpPrices  = "~data-category_id=(.+)filterBlockForItemsInCatalog~isU"; 
$regexpPrices2 = "~class=\"product__name.*href=\"(.+)\".*>(.+)</a.*class=\"product__price.*>(.+)</~isU";
$regexpPrices3 = "~class=\"product__name.*href=\"(.+)\".*>(.+)</a~isU";

$AC = new AngryCurl('callback_two');
$AC->init_console();
callback_two($response, $info, $request);

file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));

function callback_two($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;  
  global $bad_urls;
	global $time_start;

	//echo $response;

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url; 	
		if (round(microtime(1) - $time_start, 0) >= 2700) { $bad_urls = array(); } 
  } else {
		//file_put_contents('/var/www/polaris.ua/engines/mta.ua/content.txt', $response);die($response);

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //file_put_contents('/var/www/polaris.ua/engines/mta.ua/1.txt', print_r($matches2, 1));
	  //print_r($matches2);
	  foreach ($matches2 as $key) {
	  	//if (strripos(mb_strtolower($key[0]), 'уценка') === false) {
	  		if (strripos($key[1], 'addToBasket') !== false) {
					preg_match($regexpPrices2, $key[1], $matches);
					//print_r($matches);

					$matches[1] = trim($matches[1]);
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
					$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);

					if (@$matches[1] && $matches[2]) {
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', $request->url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}									
	  		}	else {
					preg_match($regexpPrices3, $key[1], $matches);

					$matches[1] = trim($matches[1]);
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
					$matches[3] = '0';

					if (@$matches[1] && $matches[2]) {
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', $request->url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}		  			
	  		}
	  	//} // Уценка
	  }
  }
}
