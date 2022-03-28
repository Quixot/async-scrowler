<?php
	$regexpPrices = "~<article(.+)</article>~isU";
	$regexpPricesS2 = "~href=\"(.+)\".*<h3>(.+)<.*descr-price\">(.+)<~isU";

	$itemsArray = array();

	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

	function callback_two($response) {
  global $regexpPrices;
  global $regexpPricesS2;
  global $itemsArray;

		if (strlen($response) > 500) {

	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  	//print_r($matches2);

	  	foreach ($matches2 as $key) {
	  		if (strripos($key[1], 'Купить') !== false) {
					preg_match($regexpPricesS2, $key[1], $matches);
					//print_r($matches);
					$matches[1] = 'https://www.unixmart.ru'.trim($matches[1]);
		      $matches[2] = strip_tags(trim($matches[2]));
		      $matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
					if ($matches[1] && $matches[2]) {
						price_change_detect(trim($matches[1]), $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(
							$matches[2], 
							$matches[3],
							date("d.m.y-H:i:s"),
							'manual',
							'manual',
							'manual'
						);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}
	  		} else {
					preg_match($regexpPricesS3, $key[1], $matches);
					$matches[1] = 'https://www.unixmart.ru'.trim($matches[1]);
		      $matches[2] = strip_tags(trim($matches[2]));
					if ($matches[1] && $matches[2]) {
						price_change_detect(trim($matches[1]), $matches[2], '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(
							$matches[2], 
							'0',
							date("d.m.y-H:i:s"),
							'manual',
							'manual',
							'manual'
						);		
						AngryCurl::add_debug_msg($matches[2].' | 0');
					}
	  		}
			}

			return 1;
		}
}