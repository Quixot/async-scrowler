<?php
/**
 * vstroyka-solo.ru
 */
	//$url_1 = 'https://vstroyka-solo.ru/moskva/search/?search=polaris'; //&page=
	$reg_region = "~id=\"city\".*>(.+)<~isU";
	$regexpPrices = "~<div class=\"thumbnail\"(.+)/button>~isU";
	$regexpPricesS2 = "~href=\"(.+)\".*class=\"title.*>(.+)</div.*class=\"priceDigits\">(.+)<~isU";
	//$regexpPricesS3 = "~href=\"(.+)\".*class=\"title.*>(.+)</div~isU";

	$directLinks = explode("\n", file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/links.txt'));
	array_walk($directLinks, 'trim_value');

	// Загрузка отсканированных ссылок:
	foreach ($itemsArray as $key => $value) {
		$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
		//echo (time() - $date->format('U')).PHP_EOL; 
		if (time() - $date->format('U') <= 5400) {
			$already_scanned[] = trim($value[5]);
		}	
	}
	
	if ($already_scanned) {
		$already_scanned = array_unique($already_scanned);
		$already_scanned = array_values($already_scanned);
		print_r($already_scanned); 
	} else {
		$already_scanned = array();
	}
	//$already_scanned = array();

	foreach ($directLinks as $url) {
		if (!in_array($url, $already_scanned)) {
			echo 'сканирую адрес:'.PHP_EOL.$url.PHP_EOL;
			$i = 1;
			while ( regular_one($url)<1 && $i<3 ) {
				$i++;
			}
		} else {
			echo 'уже сканировал:'.PHP_EOL.$url.PHP_EOL;
		}
	}

/*
	$casper = array(	
		'123.js',
		'11011.js',	
		'145.js',
		'167.js',
		'189.js',
		'11012.js',
		'11013.js',
		'11014.js',
		'11015.js',
		);
	foreach ($casper as $filenum) {
		if (!in_array($filenum, $already_scanned)) {
			echo 'сканирую адрес:'.PHP_EOL.$filenum.PHP_EOL;
			$i = 1;
			while ( regular_one($filenum)<1 && $i<3 ) {
				$i++;
			}
		} else {
			echo 'уже сканировал:'.PHP_EOL.$filenum.PHP_EOL;
		}
	}
*/
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';

/** 
 *              Callback Functions           
 */
function regular_one($url) {
  global $regexpPrices;
  global $regexpPricesS2;
  global $regexpPricesS3;

  global $qOfPaginationPages;

  global $itemsArray;
  global $region;
	global $reg_region;
	global $city;

	$proxarr = get_proxy_and_ua('/var/www/lib/proxies/16.proxy', '/var/www/lib/useragents_short.txt');
	

	//$cmd = 'timeout -k 60s 61s casperjs /var/www/polaris/engines/vstroyka-solo.ru/'.$filenum.' '.escapeshellarg('https://vstroyka-solo.ru/').' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'].' '.$region.' '.$pagin.' '.ENGINE_TYPE;

	$cmd = 'timeout -k 60s 61s casperjs /var/www/polaris/engines/vstroyka-solo.ru/casper.js '.escapeshellarg($url).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'].' '.$region.' '.$pagin.' '.ENGINE_TYPE;

	echo $cmd.PHP_EOL;
	$response = exec($cmd, $out, $err);
	$response = implode(" ", $out);

	file_put_contents('/var/www/polaris/engines/vstroyka-solo.ru/content/'.$filenum.'.txt', $response);
	//die();
	if (strlen($response) > 1000) {
		echo 'response ok'.PHP_EOL;
			//echo substr($response, 0, 500);
	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  	//print_r($matches2);

	  	foreach ($matches2 as $key) {
	  		if (strripos($key[1], 'icon-shopping-cart') !== false) {
					preg_match($regexpPricesS2, $key[1], $matches);
					//print_r($matches);
					if (stripos($matches[1], 'https://vstroyka-solo.ru') === false) {
						$matches[1] = 'https://vstroyka-solo.ru'.trim($matches[1]);
					}
		      $matches[2] = strip_tags(trim($matches[2]));
		      $matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
					if ($matches[1] && $matches[2]) {
						price_change_detect(trim($matches[1]), $matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['login'].':'.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(
							$matches[2], 
							$matches[3],
							date("d.m.y-H:i:s"),
							$proxarr['address'].':'.$proxarr['port'],
							$proxarr['ua'],
							$url
						);
						//AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}
	  		} else {
					preg_match($regexpPricesS3, $key[1], $matches);
					if (stripos($matches[1], 'https://vstroyka-solo.ru') === false) {
						$matches[1] = 'https://vstroyka-solo.ru'.trim($matches[1]);
					}
		      $matches[2] = strip_tags(trim($matches[2]));
		      $matches[3] = '0';
					if ($matches[1] && $matches[2]) {
						price_change_detect(trim($matches[1]), $matches[2], '0', date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['login'].':'.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(
							$matches[2], 
							$matches[3],
							date("d.m.y-H:i:s"),
							$proxarr['address'].':'.$proxarr['port'],
							$proxarr['ua'],
							$url
						);		
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}
	  		}

			
		}
		echo PHP_EOL;
		return 1;
	} else {
		echo substr($response, 0, 500);
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}
