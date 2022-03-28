<?php
/**
 * frau-technica.ru
 */
$regexpPrices  = "~data-id=\"product\".*>(.+)class=\"price-buttons-catalog(.+)</div>~isU";
$regexpPrices2 = "~class=\"title\".*href=\"(.+)\".*<h3>(.+)<.*data-of=\"price-total\".*>(.+)<~isU";
$regexpRegion  = "~class=\"city-select w-choose-city-widget\".*</i>(.+)<~isU";
	$itemsArray = array();
	echo "New file\n";

callback_one(file_get_contents('/home/obolon/frau-technica.ru/'.ENGINE_TYPE.'/'.EXTRA_PARAM.'.txt'));

file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';

/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpRegion;
	global $matches;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

  preg_match($regexpRegion, $response, $mregion);
  echo $mregion[1];

	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); // 	
	//print_r($matches2);
	foreach ($matches2 as $key) {
		preg_match($regexpPrices2, $key[1], $matches);
		//print_r($matches);
		if ($matches[1]) {
			if (strripos($key[2], 'data-action="cart-button"') !== false) {
				price_change_detect('http://' . ENGINE_CURR . trim($matches[1]), trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), null, null, null, null, null);
				$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), null);
				echo trim($matches[2]).' | '.preg_replace('~[\D]+~', '' , $matches[3]);
			} else {
				price_change_detect('http://' . ENGINE_CURR . trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), null, null, null, null, null);
				$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), null); //iconv('UTF-8', 'Windows-1251', 
				echo trim($matches[2]).' | 0';
			}				
		} 
  }
}
