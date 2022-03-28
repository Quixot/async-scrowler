<?php


$itemsArray = unserialize(file_get_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data'));
$regexpPrices  = "~class=\"pr_block0\"(.+)pr_block5~isU"; 
$regexpPrices2 = "~pr_name.*href=\"(.+)\".*>(.+)<.*class=\"left mt6\".*>(.+)<~isU";
$regexpPrices3 = "~pr_name.*href=\"(.+)\".*>(.+)<~isU";

$itemsArray = array();


	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));

	function callback_two($response) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;

	global $itemsArray;

	//file_put_contents('/var/www/engines/rbt.ru/content.txt', $response);
//die();

		if (strlen($response) > 500) {
			echo 'response ok manual'.PHP_EOL;

		  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
		  //print_r($matches2);
		  foreach ($matches2 as $key) {
				preg_match($regexpPrices2, $key[0], $matches);
				//print_r($matches);
				if (@$matches[1] && $matches[2] && stripos($key[0], 'in_cart') !== false) {
					$matches[1] = trim($matches[1]);
					
					
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
					$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
					
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
				}	else {
					preg_match($regexpPrices3, $key[0], $matches);
					if (@$matches[1] && $matches[2]) {
						$matches[1] = trim($matches[1]);
						
						
						$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
						$matches[3] = '0';

						price_change_detect(trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}
				}	
		  }
			return 1;
		}
}

include('/var/www/'.ENGINE_TYPE.'/footer.php');