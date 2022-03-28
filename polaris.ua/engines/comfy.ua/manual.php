<?php


$itemsArray = unserialize(file_get_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data'));
$regexpPrices1 = "~data-product-url=(.+)product-options__more~isU";
$regexpPrices2 = "~product-item__name.*href=\"(.+)\".*>(.+)</a.*class=\"price-value.*>(.+)<~isU";
$regexpPrices3 = "~product-item__name.*href=\"(.+)\".*>(.+)</a~isU";
$regexpPricesSpecial = "~product-item__name.*href=\"(.+)\".*>(.+)</a.*price-box__content_special.*class=\"price-value.*>(.+)<~isU";

$itemsArray = array();


	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));

	function callback_two($response) {
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPricesSpecial;
	global $regexpPrices3;

	global $itemsArray;

	//file_put_contents('/var/www/engines/rbt.ru/content.txt', $response);
//die();
//echo $response;
		if (strlen($response) > 500) {
			echo 'response ok manual'.PHP_EOL;

	  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER); // Все карточки товара		
	  //print_r($matches);

		foreach ($matches as $key) {
			if (stripos($key[0], 'data-add-to-cart-url=') !== false) {
				if (stripos($key[0], 'price-box__content_special') !== false) {
					preg_match($regexpPricesSpecial, $key[1], $matches2);
					//print_r($matches2);
					$matches2 = parser_clean($matches2, 2, 3);
					
					price_change_detect($matches2[1], trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches2[1]] = array(trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), 'manual', 'manual');			
					AngryCurl::add_debug_msg($matches2[2].' | '.$matches2[3]);					
				} else {
					preg_match($regexpPrices2, $key[1], $matches2);
					//print_r($matches2);
					$matches2 = parser_clean($matches2, 2, 3);
					
					price_change_detect($matches2[1], trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches2[1]] = array(trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), 'manual', 'manual');
					AngryCurl::add_debug_msg($matches2[2].' | '.$matches2[3]);
				}
			}	else {
				preg_match($regexpPrices3, $key[1], $matches2);
				//print_r($matches2);
				price_change_detect($matches2[1], trim($matches2[2]), '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
				
				$itemsArray[trim($matches2[1])] = array(trim($matches2[2]), '0', date("d.m.y-H:i:s"), 'manual', 'manual');			
				
				AngryCurl::add_debug_msg(trim($matches2[2]).' | 0');	
				
					
			}
		}
			return 1;
		}
}

include('/var/www/'.ENGINE_TYPE.'/footer.php');