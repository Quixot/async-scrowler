<?php
/**
 * elmir.ua
 */
	$reg_css = "~<link rel=\"stylesheet\".*<link rel=\"stylesheet\".*<link rel=\"stylesheet\".*href=\"(.+)\"~isU";

	//$reg_hidden_style = "~(.+),~isU";

	$regexpPrices  = "~<li class=\"vit-item(.+)</li>~isU";
	$regexpPrices2 = "~vit-info.*href=\"(.+)\".*>(.+)<.*class=\"price.*>(.+)грн~isU";
	//$regexpPrices3 = "~class=\"name\".*href=\"(.+)\".*>(.+)<~isU";

	$csspath = regular_one();

	sleep(5);

	$styles_array = regular_two($csspath);
	print_r($styles_array);

	sleep(5);
	
	regular_three($styles_array);

	file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
	$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';


function regular_one() {
	global $reg_css;
	global $cookfilepath;

	// Переделаем кукисы в правильный стандарт
	$cookfilepath = AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/'.EXTRA_PARAM.'.txt';
	if (!file_exists($cookfilepath)) { // || time() - filemtime($cookfilepath) > 3600
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
	$cmd = 'timeout -k 30s 31s casperjs /var/www/polaris.ua/engines/elmir.ua/css.js --ignore-ssl-errors=true --ssl-protocol=any "https://elmir.ua/household_scales/" '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4];

	echo 'request: '.$cmd.PHP_EOL;
	$response = exec($cmd, $out, $err);
	$response = implode(" ", $out);
	
	if ($response) {
		preg_match($reg_css, $response, $matches);
		echo 'Путь к файлу со стилями: '.$matches[1].PHP_EOL;

		return $matches[1];
	} else {
		return 0;
	}
}


function regular_two($url) {
	//global $reg_hidden_style;
	global $cookfilepath;

	// Переделаем кукисы в правильный стандарт
	$cookfilepath = AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/'.EXTRA_PARAM.'.txt';
	if (!file_exists($cookfilepath)) { // || time() - filemtime($cookfilepath) > 3600
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
	$cmd = 'timeout -k 30s 31s casperjs /var/www/polaris.ua/engines/elmir.ua/css2.js --ignore-ssl-errors=true --ssl-protocol=any "'.$url.'" '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4];

	echo 'request: '.$cmd.PHP_EOL;
	$response = exec($cmd, $out, $err);
	$response = implode(" ", $out);
	
	if ($response) {
		//echo $response.PHP_EOL;
		$response = trim($response);
		$response = substr($response, 0, strripos($response, '{'));
		$response = substr($response, strripos($response, '>')+1);
		$styles_array = explode(',', $response);
		print_r($styles_array);

		return $styles_array;
	} else {
		return 0;
	}
}


function regular_three($styles_array) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
	global $cookfilepath;

	// Переделаем кукисы в правильный стандарт
	$cookfilepath = AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/'.EXTRA_PARAM.'.txt';
	if (!file_exists($cookfilepath)) { // || time() - filemtime($cookfilepath) > 3600
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
	$glob = glob('/var/www/polaris.ua/engines/elmir.ua/content/*.txt');

	$baselinks = array('https://elmir.ua/?q=polaris&size=144,https://elmir.ua/?p=2&q=polaris&size=144,https://elmir.ua/?p=3&q=polaris&size=144');//

	$baselinksID = array();
	foreach ($baselinks as $bsurl) {
		$baselinksID[] = preg_replace('/[^a-zA-Z0-9&]/', '', $bsurl);;
	}

	for ($i=0; $i < count($baselinks); $i++) { 
		//echo '/var/www/polaris.ua/engines/elmir.ua/content/'.$i.'.txt'.PHP_EOL;
		if (!in_array('/var/www/polaris.ua/engines/elmir.ua/content/'.$baselinksID[$i].'.txt', $glob)) {
			$links .= $baselinks[$i].',';
			//$linksid .= $baselinksID[$i].',';
		}
	}
	$links = substr($links, 0, -1);
	//$linksid = substr($linksid, 0, -1);

	$cmd = 'timeout -k 330s 331s casperjs /var/www/polaris.ua/engines/elmir.ua/casper.js --ignore-ssl-errors=true --ssl-protocol=any "'.$links.'" '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4];
	if ($links) {
		echo 'request: '.$cmd.PHP_EOL;
	
		$response = exec($cmd, $out, $err);
		$response = implode(" ", $out);
	}

	
	if ($glob) {
		$count_all_items = 0;
		foreach ($glob as $addr) {
			preg_match('~'.EXTRA_PARAM.'(.+).txt~isU', $addr, $mReqUrl);
			$request_url = $mReqUrl[1];
			AngryCurl::add_debug_msg($request_url);
			
			$response = file_get_contents($addr);

			if ($response) {
		  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
		  	//print_r($matches2);

		  	foreach ($matches2 as $key) {
		  		if (strripos($key[1], 'status stat-1') !== false || strripos($key[1], 'status stat-2') !== false) {
						preg_match($regexpPrices2, $key[1], $matches);

						$matches[1] = 'https://elmir.ua'.trim($matches[1]);
						$matches[2] = trim(strip_tags($matches[2]));

						// Разложим в два массива теги и цифры
						preg_match_all("~<(.+)>(.+)<~isU", $matches[3], $matches_price, PREG_SET_ORDER);
						//print_r($matches_price);
						
						$real_price = '';
						foreach ($matches_price as $inf) {
							if (!in_array(trim($inf[1]), $styles_array)) { // Если нет в списке, значит стиль visible
								$real_price .= trim($inf[2]); 
							}
						}
						 						

						if (trim($matches[1]) && $matches[2]) {
							price_change_detect($matches[1], $matches[2], $real_price, date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
							$itemsArray[$matches[1]] = array($matches[2], $real_price, date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent, $request_url);
							AngryCurl::add_debug_msg($matches[1]." | ".$matches[2]." | ".$real_price);
						}	
		  		}							
				}
			}
			unlink($addr);
		}
		echo 'Позиций: '.$count_all_items.PHP_EOL;
		return 1;
	} else {
		return 0;
	}
}

