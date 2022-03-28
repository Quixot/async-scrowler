<?php
/**
 * foxtrot.com.ua
 */
switch (EXTRA_PARAM) {
  case 'kiev': $region = ''; break;
  case 'kharkov': $region = 'kharkiv.'; break;    
  case 'dnepropetrovsk': $region = 'dnepropetrovsk.'; break;
  case 'odessa': $region = 'odessa.'; break;
  case 'lvov': $region = 'lviv.'; break;
 	default:
 		die("Unknown region\n");  	 		
}

$regexpP	= "~class=\"pagination-list\"(.+)</ul>~isU";
$regexpP2 = "~<a.*>.*>(.+)<~isU";
$regexpPrices1 = "~class=\"card js-card(.+)card__footer-detail~isU";
$regexpPrices2 = "~class=\"card__body.*href=\"(.+)\".*>(.+)<.*class=\"card-price\">(.+)<~isU";
$regexpPrices3 = "~class=\"card__body.*href=\"(.+)\".*>(.+)<.*class=\"card-price\">(.+)<~isU";
$regexpPrices4 = "~class=\"card__body.*href=\"(.+)\".*>(.+)<~isU";

if (ENGINE_LOOP == 13) {
	$regions = array('kiev');

	foreach ($regions as $region) {

		$content_file_path = '/var/www/polaris.ua/engines/foxtrot.com.ua/content/'.$region.'.txt';
		if (file_exists($content_file_path) && time() - filemtime($content_file_path) < 3600) {

			$itemsArray = array();

			$AC = new AngryCurl('callback_three');
			$AC->init_console();
			$response = file_get_contents($content_file_path);

			callback_three($response, $region);

			if (!$itemsArray) {
				die();
			}
			file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '.ua_' . $region . '.data', serialize($itemsArray));
			$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '.ua_' . EXTRA_PARAM . '.csv';
		} else {
			echo 'Старый файл: '.$content_file_path.PHP_EOL;
		}
	}
	

} else {	
	$i = 1;
	echo 'сканирую адрес:'.PHP_EOL.$url.PHP_EOL;
	while ( regular_one('https://www.foxtrot.com.ua/ru/brand/polaris')<1 && $i<5 ) {
		$i++;
	}
	file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
	$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';
	unlink($cookfilepath);
}



/** 
 *              Callback Functions           
 */
function callback_three($response, $region) {
	global $itemsArray;
	global $bad_urls;
	global $region;
	global $city;
	global $regexpRegion;
	global $time_start;
	global $content_file_path;

	$regexpPrices1 = "~class=\"card js-card(.+)card__footer-detail~isU";
	$regexpPrices2 = "~class=\"card__body.*href=\"(.+)\".*>(.+)<.*class=\"card-price\">(.+)<~isU";
	$regexpPrices3 = "~class=\"card__body.*href=\"(.+)\".*>(.+)<.*class=\"card-price\">(.+)<~isU";
	$regexpPrices4 = "~class=\"card__body.*href=\"(.+)\".*>(.+)<~isU";

	if ($response) {
		//echo 'response ok'.PHP_EOL;
		//file_put_contents('/var/www/polaris.ua/engines/foxtrot.com.ua/content.txt', $response);
  	preg_match($regexpRegion, $response, $mregion);
  	$mregion[1] = trim($mregion[1]);
  	echo 'Регион: '.$mregion[1].' | '.$region.PHP_EOL;

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
		//file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '.ua_' . $region . '.data', serialize($itemsArray));
		unlink($content_file_path);
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}


function regular_one($url) {
  global $regexpP;
  global $regexpP2;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $itemsArray;
	global $bad_urls;
	global $time_start;
	global $cookfilepath;

	// Переделаем кукисы в правильный стандарт
	$cookfilepath = AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/'.EXTRA_PARAM.'.txt';
	if (!file_exists($cookfilepath) || time() - filemtime($cookfilepath) > 3600) {
		die('нет кукисов или старый файл '.$cookfilepath.PHP_EOL);
	}

	/**
	 * Блок выбора прокси
	 */
	$useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';
		  
	$proxy_auth = file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/proxy/'.EXTRA_PARAM.'.txt');	  
	preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	if (!$matches_proxy) {
	 	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	}
	
	/**
	 * Блок выбора прокси
	 */
	$cmd = 'timeout -k 50s 51s casperjs /var/www/polaris.ua/engines/foxtrot.com.ua/script.js '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4].' '.EXTRA_PARAM;

	echo $cmd.PHP_EOL;
	$response = exec($cmd, $out, $err);
	$response = implode(" ", $out);

	file_put_contents('/var/www/polaris.ua/engines/foxtrot.com.ua/content.txt', $response);

	if (strlen($response) > 500) {
		echo 'response ok'.PHP_EOL;
	  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
	  //print_r($matches);
		foreach ($matches as $key) {
			if (strripos($key[1], 'Купить') !== false) {
				if (strripos($key[1], 'price__not-relevant') !== false) {
					preg_match($regexpPrices3, $key[1], $matches2);
					$matches2 = parser_clean($matches2, 2, 3);
					price_change_detect('https://www.' . ENGINE_CURR . $matches2[1], $matches2[2], $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://www.' . ENGINE_CURR . $matches2[1]] = array($matches2[2], $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);			
					AngryCurl::add_debug_msg($matches2[2].' | '.$matches2[3]);
				} else {
					preg_match($regexpPrices2, $key[1], $matches2);
					$matches2 = parser_clean($matches2, 2, 3);
					price_change_detect('https://www.' . ENGINE_CURR . $matches2[1], $matches2[2], $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://www.' . ENGINE_CURR . $matches2[1]] = array($matches2[2], $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);			
					AngryCurl::add_debug_msg($matches2[2].' | '.$matches2[3]);
				}
			}	else {
				preg_match($regexpPrices3, $key[1], $matches2);
				if ($matches2[1] && strripos($matches2[1], 'price__not-relevant') === false) {
					$matches2 = parser_clean($matches2, 2, 3);
					price_change_detect('https://www.' . ENGINE_CURR . $matches2[1], $matches2[2], '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://www.' . ENGINE_CURR . $matches2[1]] = array($matches2[2], '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);			
					AngryCurl::add_debug_msg($matches2[2].' | 0');	
				}
			}
		} 
		return 1;
	}	else {
		return 0;
	}	
}

function callback_one($response, $info, $request) {
  global $regexpP;
  global $regexpP2;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	file_put_contents('/var/www/polaris.ua/engines/foxtrot.com.ua/content.txt', $response);

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {            
    if (stripos($info['url'], ENGINE_CURR)) {
      $bad_urls[] = $info['url'];
      if (round(microtime(1) - $time_start, 0) >= 120) $bad_urls = array();
    }
  } else {
		preg_match($regexpP, $response, $matches);
		preg_match_all($regexpP2, $matches[0], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			if (is_numeric($value)) {
				$temparrpage[] = $value;
			}
		}
		if (@max($temparrpage) > $qOfPaginationPages) {
			$qOfPaginationPages = @max($temparrpage);		    	
		}

	  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
	  //print_r($matches);
		foreach ($matches as $key) {
			if (strripos($key[1], 'Купить') !== false) {
				if (strripos($key[1], 'price__not-relevant') !== false) {
					preg_match($regexpPrices3, $key[1], $matches2);
					$matches2 = parser_clean($matches2, 2, 3);
					price_change_detect('https://www.' . ENGINE_CURR . $matches2[1], $matches2[2], $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://www.' . ENGINE_CURR . $matches2[1]] = array($matches2[2], $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);			
					AngryCurl::add_debug_msg($matches2[2].' | '.$matches2[3]);
				} else {
					preg_match($regexpPrices2, $key[1], $matches2);
					$matches2 = parser_clean($matches2, 2, 3);
					price_change_detect('https://www.' . ENGINE_CURR . $matches2[1], $matches2[2], $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://www.' . ENGINE_CURR . $matches2[1]] = array($matches2[2], $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);			
					AngryCurl::add_debug_msg($matches2[2].' | '.$matches2[3]);
				}
			}	else {
				preg_match($regexpPrices3, $key[1], $matches2);
				if ($matches2[1] && strripos($matches2[1], 'price__not-relevant') === false) {
					$matches2 = parser_clean($matches2, 2, 3);
					price_change_detect('https://www.' . ENGINE_CURR . $matches2[1], $matches2[2], '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://www.' . ENGINE_CURR . $matches2[1]] = array($matches2[2], '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);			
					AngryCurl::add_debug_msg($matches2[2].' | 0');	
				}
			}
		} 
  }
}
