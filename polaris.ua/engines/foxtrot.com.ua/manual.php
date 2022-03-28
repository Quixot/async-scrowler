<?php
$itemsArray = unserialize(file_get_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data'));
$regexpPrices1 = "~class=\"card js-card(.+)card__footer-detail~isU";
$regexpPrices2 = "~class=\"card__body.*href=\"(.+)\".*>(.+)<.*class=\"card-price\">(.+)<~isU";
$regexpPrices3 = "~class=\"card__body.*href=\"(.+)\".*>(.+)<.*class=\"card-price\">(.+)<~isU";
$regexpPrices4 = "~class=\"card__body.*href=\"(.+)\".*>(.+)<~isU";

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

		if (strlen($response) > 500) {
			echo 'response ok manual'.PHP_EOL;

	  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
	  //print_r($matches);
		foreach ($matches as $key) {
			if (strripos($key[1], 'Купить') !== false) {
				if (strripos($key[1], 'price__not-relevant') !== false) {
					preg_match($regexpPrices3, $key[1], $matches2);
					$matches2 = parser_clean($matches2, 2, 3);
					price_change_detect('https://www.' . ENGINE_CURR . $matches2[1], $matches2[2], $matches2[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://www.' . ENGINE_CURR . $matches2[1]] = array($matches2[2], $matches2[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');			
					AngryCurl::add_debug_msg($matches2[2].' | '.$matches2[3]);
				} else {
					preg_match($regexpPrices2, $key[1], $matches2);
					$matches2 = parser_clean($matches2, 2, 3);
					price_change_detect('https://www.' . ENGINE_CURR . $matches2[1], $matches2[2], $matches2[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://www.' . ENGINE_CURR . $matches2[1]] = array($matches2[2], $matches2[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');			
					AngryCurl::add_debug_msg($matches2[2].' | '.$matches2[3]);
				}
			}	else {
				preg_match($regexpPrices3, $key[1], $matches2);
				if ($matches2[1] && strripos($matches2[1], 'price__not-relevant') === false) {
					$matches2 = parser_clean($matches2, 2, 3);
					price_change_detect('https://www.' . ENGINE_CURR . $matches2[1], $matches2[2], '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://www.' . ENGINE_CURR . $matches2[1]] = array($matches2[2], '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');			
					AngryCurl::add_debug_msg($matches2[2].' | 0');	
				}
			}
		}
			return 1;
		}
}

include('/var/www/'.ENGINE_TYPE.'/footer.php');