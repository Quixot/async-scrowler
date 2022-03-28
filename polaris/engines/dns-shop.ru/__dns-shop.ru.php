<?php
/**
 * dns-shop.ru
 */

$bad_urls = array();
	$itemsArray = array();
	echo "New file\n";
$urlStart 		 = 'http://www.dns-shop.ru/search/?q=' . ENGINE_TYPE . '&length_1=150&p=';	// Первая часть адреса &page=
$url2					 = '?brand='.ENGINE_TYPE.'&mode=list&stock=1';
$regexpP 			 = "~<ul class=\"pager\">(.+)</ul>~isU";						// Пагинация
$regexpP2 		 = "~<a href.*>(.+)</a>~isU";												// Пагинация
$regexpPrices 	= "~class=\"product\" data-id=(.+)btn btn-compare~isU";
$regexpPrices2 	= "~data-product-param=\"name\".*href=\"(.+)\".*>(.+)<.*data-product-param=\"price\".*>(.+)<~isU";
$regexpRegion  = "~city-select w-choose-city-widget.*</i>(.+)<~isU"; // Регион
$regexpRegion2 = "~class=\"icon-left glyphicon glyphicon-map-marker\".*-->(.+)<~isU"; // Регион

callback_one(file_get_contents('/home/obolon/dns-shop.ru/'.ENGINE_TYPE.'/'.EXTRA_PARAM.'.txt'), null, null);

file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';

/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $matches;
	global $itemsArray;
	global $errorsArray;
	global $time_start;
	global $region;
	global $regionRu;
	global $regexpRegion;

  	preg_match($regexpRegion, $response, $mregion);
	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); // 	

	  	foreach ($matches2 as $key) {
				preg_match($regexpPrices2, $key[1], $matches);
				if ($matches[1] && strripos($key[1], 'class="mail"') === false) {
					if (strripos($matches[3], 'class="new"')) {
						preg_match("~<div class=\"new\">(.+)</div>~isU", $matches[3], $tempmach);
						$matches[3] = $tempmach[1];
						price_change_detect('http://' . ENGINE_CURR . trim($matches[1]), trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), null, null, null, ENGINE_CURR, ENGINE_TYPE);
						$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(
							trim($matches[2]), 
							preg_replace('~[\D]+~', '' , $matches[3]),
							date("d.m.y-H:i:s"),
							null,
							null,
							null
						); //iconv('UTF-8', 'Windows-1251', 
						echo trim($matches[1]) . "\n";
					} else {
						price_change_detect('http://' . ENGINE_CURR . trim($matches[1]), trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), null, null, null, ENGINE_CURR, ENGINE_TYPE);
						$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(
							trim($matches[2]), 
							preg_replace('~[\D]+~', '' , $matches[3]),
							date("d.m.y-H:i:s"),
							null,
							null,
							null
						); //iconv('UTF-8', 'Windows-1251', 
						echo trim($matches[1]) . "\n";
					}				
				} elseif ($matches[1] &&  strripos($key[1], 'class="mail"') !== false) {
					price_change_detect('http://' . ENGINE_CURR . trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), null, null, null, ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(
						trim($matches[2]), 
						'0',
						date("d.m.y-H:i:s"),
						null,
						null,
						null
					);  
					echo trim($matches[1]) . " Null \n";
				}
			} 
  
}


