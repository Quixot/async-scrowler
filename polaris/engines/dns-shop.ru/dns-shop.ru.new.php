<?php
/**
 * dns-shop.ru
 */
	$itemsArray = array();
	echo "New file\n";

$regexpBrand   = "~one-brand-submit.*>(.+)<~isU";
$regexpPrices  = "~class=\"product\" data-id=(.+)btn btn-compare~isU";
$regexpPrices2 = "~data-product-param=\"name\".*href=\"(.+)\".*>(.+)<.*data-product-param=\"price\".*>(.+)<~isU";
$regexpRegion  = "~city-select w-choose-city-widget.*</i>(.+)<~isU"; // Регион
$regexpRegion2 = "~class=\"icon-left glyphicon glyphicon-map-marker\".*-->(.+)<~isU"; // Регион

callback_one(file_get_contents('/home/xeon/dns-shop.ru/'.ENGINE_TYPE.'/'.EXTRA_PARAM.'.txt'));

/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $itemsArray;
	global $region;
	global $regionRu;
	global $regexpRegion;


  	preg_match($regexpRegion, $response, $mregion);
  	echo $mregion[1].PHP_EOL;

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER);
	  //print_r($matches2);
		foreach ($matches2 as $key) {
			preg_match($regexpPrices2, $key[1], $matches);
			print_r($matches);
			if (strripos($key[1], 'Добавить в корзину') === false) {
				$matches[3] = 0;
			}

			$matches[1] = 'http://'.ENGINE_CURR.trim($matches[1]);
			$matches = clean_info($matches, array(1,2,3));
			if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), null, null, null, ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), null);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}
		}
  
}
