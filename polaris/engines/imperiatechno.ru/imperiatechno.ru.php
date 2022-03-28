<?php
/**
 * imperiatechno.ru
 */
if (ENGINE_LOOP == 13) {
	$regions = array('arhangelsk', 'cheboksary', 'chelyabinsk', 'habarovsk', 'kazan', 'krasnodar', 'krasnoyarsk', 'moscow', 'naberezhnye-chelny', 'novgorod', 'novosibirsk', 'petrozavodsk', 'pyatigorsk', 'omsk', 'perm', 'rostov', 'spb', 'samara', 'ufa', 'volgograd', 'vladivostok', 'yekaterinburg');

	foreach ($regions as $region) {
		$content_file_path = '/var/www/polaris/engines/imperiatechno.ru/content/'.$region.'.txt';
		if (file_exists($content_file_path) && time() - filemtime($content_file_path) < 3600) {

			$itemsArray = array();

			$AC = new AngryCurl('callback_three');
			$AC->init_console();
			$response = file_get_contents($content_file_path);

			callback_three($response, $region);

			file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . $region . '.data', serialize($itemsArray));
			unlink($content_file_path);
		} else {
			echo 'Старый файл: '.$content_file_path.PHP_EOL;
		}
	}
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';
}


function callback_three($response, $region) {
	global $itemsArray;
	global $bad_urls;
	global $region;
	global $regexpRegion;
	global $time_start;

	$regexpPrices = "~<div data-v(.+)<!----><!----></div></div>~isU";
	$regexpPricesS2 = "~href=\"(.+)\".*itemprop=\"name\">(.+)<.*itemprop=\"price\".*>(.+)<~isU";
	$regexpPricesS4 = "~href=\"(.+)\".*itemprop=\"name\">(.+)<.*itemprop=\"price\".*>(.+)<~isU";
	$regexpPricesS3 = "~href=\"(.+)\".*itemprop=\"name\">(.+)<~isU";

	if (strlen($response) > 500) {
		echo 'response ok manual'.PHP_EOL;
		preg_match('~class=\"page-header-location__link.*>(.+)<~isU', $response, $region_name);
		echo 'response region: '.$region_name[1].PHP_EOL;	

  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
  	//print_r($matches2);

  	foreach ($matches2 as $key) {
  		if (strripos($key[1], 'В наличии') !== false) {
				preg_match($regexpPricesS2, $key[1], $matches);
				if (!$matches) {
					preg_match($regexpPricesS4, $key[1], $matches);
				}
				//print_r($matches);
				if (stripos($matches[1], '?') !== false) {
					$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
				}
				$matches[1] = trim($matches[1]);
	      $matches[2] = trim($matches[2]);
				if ($matches[1] && $matches[2]) {
					price_change_detect(trim($matches[1]), $matches[2], preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(
						$matches[2], 
						preg_replace('~[\D]+~', '' , $matches[3]),
						date("d.m.y-H:i:s"),
						'manual',
						'manual',
						'manual'
					);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.preg_replace('~[\D]+~', '' , $matches[3]));
				}
  		} else {
				preg_match($regexpPricesS3, $key[1], $matches);
				if (stripos($matches[1], '?') !== false) {
					$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
				}
				$matches[1] = trim($matches[1]);
	      $matches[2] = trim($matches[2]);
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


		file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . $region . '.data', serialize($itemsArray));
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}
