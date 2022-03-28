<?php
	$regexpAll 		 = "~class=\"page-subtitle\".*>(.+)<~isU";
	$regexpPrices  = "~class=\"products-listing-item(.+)hidden-block-wrap~isU";
	$regexpPrices2 = "~class=\"name-block.*href=\"(.+)\".*>(.+)<.*class=\"regular-price\">(.+)<~isU";
	$regexpPrices3 = "~class=\"name-block.*href=\"(.+)\".*>(.+)<~isU";

$itemsArray = array();

	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response);

	function callback_two($response) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpAll;
	global $qOfPaginationPages;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	preg_match($regexpAll, $response, $matches);
	$qOfPaginationPages = ceil(preg_replace('~[\D]+~', '' , $matches[1])/30);

  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
  foreach ($matches2 as $key) {
  	if (strripos($key[0], 'Купить') !== false) {
			preg_match($regexpPrices2, $key[1], $matches);
			$matches[1] = 'https://stylus.ua/'.trim($matches[1]);
			$matches[2] = str_replace('&quot;', ' ', trim($matches[2]));
			$matches[2] = str_replace('&amp;', ' ', $matches[2]);
			$matches[2] = str_replace('&apos;', ' ', $matches[2]);
			$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
			
			price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['login'].' '.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);	
			$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $useragent, $url);
			AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
		} else {
			preg_match($regexpPrices3, $key[1], $matches);
			$matches[1] = 'https://stylus.ua/'.trim($matches[1]);
			$matches[2] = str_replace('&quot;', ' ', trim($matches[2]));
			$matches[2] = str_replace('&amp;', ' ', $matches[2]);
			$matches[2] = str_replace('&apos;', ' ', $matches[2]);
			$matches[3] = '0';
			
			price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['login'].' '.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);	
			$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $useragent, $url);
			AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);

		}
  }
}