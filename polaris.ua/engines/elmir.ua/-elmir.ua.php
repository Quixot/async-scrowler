<?php
/**
 * elmir.ua
 */
$url = 'http://elmir.ua/?q='.ENGINE_TYPE.'&size=9999&view=list';

$regexpPrices  = "~class=\"item\">(.+)</tr>~isU";
$regexpPrices2 = "~class=\"name\".*href=\"(.+)\".*>(.+)<.*class=\"price cost\">(.+)<~isU";
$regexpPrices3 = "~class=\"name\".*href=\"(.+)\".*>(.+)<~isU";


// Загрузка отсканированных ссылок:

foreach ($itemsArray as $key => $value) {
	$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
	echo (time() - $date->format('U')).PHP_EOL; 
	if (time() - $date->format('U') <= 18000) {
		$already_scanned[] = trim($value[5]);
		//echo $value[5].PHP_EOL;
	}
}

if ($already_scanned) {
	$already_scanned = array_unique($already_scanned);
	$already_scanned = array_values($already_scanned);
	//print_r($already_scanned); 
} else {
	$already_scanned = array();
}
//$already_scanned = array();
//print_r($already_scanned);die();
//file_put_contents('/var/www/philips/engines/elmir.ua/scanned.txt', print_r($already_scanned,1));


	$directLinks = explode("\n", file_get_contents('/var/www/philips/engines/'.ENGINE_CURR.'/links.txt'));
	array_walk($directLinks, 'trim_value');


foreach ($directLinks as $url) {
	if (!in_array(trim($url), $already_scanned)) {
		echo 'сканирую адрес:'.PHP_EOL.$url.PHP_EOL;
		$i = 1;
		while ( regular_one($url)<1 && $i<4 ) {
			$i++;
		}
	} else {
		echo 'уже сканировал:'.PHP_EOL.$url.PHP_EOL;
	}
}
//die();
file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';

/** 
 *              Callback Functions           
 */
function regular_one($url) {
	global $reg1;
	global $reg2;

	global $reg3;
	global $reg4;

	global $itemsArray;
	global $city;

  global $proxy_ok;
  global $proxarr;

  if (!$proxy_ok) {
  		$proxarr = get_proxy_and_ua('/var/www/lib/proxies/16.proxy', '/var/www/lib/useragents_short.txt');
  		AngryCurl::add_debug_msg('Использую новый прокси'); 
  	} else {
  		AngryCurl::add_debug_msg('Использую тот же прокси'); 
  		sleep(2);
  	}


		$cmd = 'timeout -k 45s 46s casperjs /var/www/philips/engines/elmir.ua/script.js --ignore-ssl-errors=true '.escapeshellarg($url).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'];
		echo 'request: '.$cmd.PHP_EOL;
		$response = exec($cmd, $out, $err);
		$response = implode(" ", $out);
		//echo $response;

		file_put_contents('/var/www/philips/engines/elmir.ua/content.txt', $response);


		if (strlen($response) > 500) {
			echo 'response ok'.PHP_EOL;

			preg_match("~id=\"page-title\">(.+)<~isU", $response, $matchesName); 		// name
	  	preg_match("~itemprop=\"price\">(.+)<~isU", $response, $matchesPrice); 	// price
	  	//print_r($matchesName);
	  	//print_r($matchesPrice);
	  	
	  	$matchesPrice[1] = trim($matchesPrice[1]);
	  	$matchesPrice[1] = preg_replace('~[\D]+~', '' , $matchesPrice[1]);

	  		if (strripos($response, 'нет в наличии') === false) {
					
					if ($matchesPrice[1] && $matchesName[1]) {
						price_change_detect($url, $matchesName[1], $matchesPrice[1], date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['login'].':'.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$url] = array($matchesName[1], $matchesPrice[1], date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['ua'], $url);
						AngryCurl::add_debug_msg($url.' | '.$matchesName[1].' | '.$matchesPrice[1]);
					}	
	  		} else {	  			
					if ($matchesName[1]) {
						price_change_detect($url, $matchesName[1], '0', date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['login'].':'.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$url] = array($matchesName[1], '0', date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['ua'], $url);
						AngryCurl::add_debug_msg($matchesName[1]);
					}	  			
	  		}								
			
			if ($matchesName[1]) {
				file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
				$proxy_ok = 1;
			} else {
				$proxy_ok = 0;
			}
			return 1;
		} else {
			echo 'bad response'.PHP_EOL;
			$proxy_ok = 0;
			return 0;
		}
	
}

