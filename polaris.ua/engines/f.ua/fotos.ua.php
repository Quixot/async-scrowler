<?php
/**
 * fotos.ua
 */
	$reg_1 = "~class=\"credit_block_credit\">.*</a>(.+)".iconv('utf-8', 'windows-1251', 'грн')."~isU";
	$reg_2 = "~class=\"product_code\".*<h1.*>(.+)<~isU";
	$reg_3 = "~itemprop=\"price\" content=\"(.+)\"~isU";

	$regexpSecrepKeyAll = "~<body.*<style>(.+)</style>~isU";
	$regexpSecrepKeyByOne = "~\.(.+){~isU";
	$regexpSecrepKey  = "~<div class=\"price_block\">(.+)<div class=\"clr\"></div>~isU";
	$regexpSecrepKey2 = "~<div class=\"price (.+)\"~isU";


	$regexpPrices2_1 = "~<div class=\"price ";
	$regexpPrices2_2 = "\".*class=\"main product_price_main.*content=\"(.+)\"~isU";
	$regexpPrices3_2 = "\".*class=\"action product_price_action.*content=\"(.+)\"~isU";
	$regexpName = "~<h1.*>(.+)</h1>~isU";


	$directLinks = explode("\n", file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/links/'.ENGINE_LOOP.'.txt'));
	array_walk($directLinks, 'trim_value');
	print_r($directLinks);

	// Загрузка отсканированных ссылок:
	foreach ($itemsArray as $key => $value) {
		$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
		//echo (time() - $date->format('U')).PHP_EOL; 
		if (time() - $date->format('U') <= 36000) {
			$already_scanned[] = $value[5];
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
	//print_r($already_scanned);


	$i = 1;
	foreach ($directLinks as $url) {
		if (!in_array($url, $already_scanned)) {
			if (file_exists(AC_DIR.'/engines/'.ENGINE_CURR.'/data_split/'.date("d.m.y").'/'.ENGINE_LOOP.'.data')) {
				$itemsArray = unserialize(file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data_split/'.date("d.m.y").'/'.ENGINE_LOOP.'.data'));
			}
			while ( regular_one($url)<1 && $i<4 ) {
				$i++;
			}
			
			file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data_split/'.date("d.m.y").'/'.ENGINE_LOOP.'.data', serialize($itemsArray));
		} else {
			$AC->add_debug_msg('уже сканировал:'.PHP_EOL.$url);
		}
	}

	

/**
 * Формируем CSV файл
 *
 */
//$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */

function regular_one($url) {
	global $reg_1;
	global $reg_2;
	global $reg_3;
	global $regexpSecrepKeyAll;
	global $regexpSecrepKeyByOne;
	global $regexpSecrepKey;
	global $regexpSecrepKey2;	

	global $regexpPrices2_1;
	global $regexpPrices2_2;
	global $regexpPrices3_2;
	global $regexpName;
	global $itemsArray;

	global $proxy_ok;
  global $proxarr;

	
	//if (!$proxy_ok) {
  	$proxarr = get_proxy_and_ua('/var/www/lib/proxies/16.proxy', '/var/www/lib/useragents_short.txt');
  	AngryCurl::add_debug_msg('Использую новый прокси'); 
  //} else {
  //	AngryCurl::add_debug_msg('Использую тот же прокси'); 
  //	sleep(10);
  //}


	if (!count($itemsArray[$url])) {
		$cmd = 'timeout -k 40s 41s casperjs /var/www/philips/engines/fotos.ua/casper.js '.escapeshellarg($url).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'].' '.$region.' '.$pagin.' '.ENGINE_TYPE;

		AngryCurl::add_debug_msg($cmd);die();
		$response = exec($cmd, $out, $err);
		$response = stripcslashes(implode(" ", $out));

		
		//die();
	} else {
		AngryCurl::add_debug_msg($url.' already scanned');
		return 0;
	}
	if (strlen($response) > 500) {
		AngryCurl::add_debug_msg('response ok');
		

		preg_match($regexpSecrepKeyAll, $response, $matches_keyAll);
		AngryCurl::add_debug_msg('Все ключи: '.$matches_keyAll[1]);
		
		preg_match_all($regexpSecrepKeyByOne, $matches_keyAll[1], $matches_secret_one);
		print_r($matches_secret_one[1]);
		
		preg_match($regexpSecrepKey, $response, $matches_key);
		AngryCurl::add_debug_msg($matches_key[1]);
		
		preg_match_all($regexpSecrepKey2, $matches_key[1], $matches_secret);
		AngryCurl::add_debug_msg($matches_secret[1]);
		
		$result = array_diff($matches_secret[1], $matches_secret_one[1]);
		$result = array_values($result);
		print_r($result);
		
		$tempclass = trim($result[0]);

		AngryCurl::add_debug_msg('The secret key is: '.$tempclass);

		preg_match($regexpPrices2_1 . $tempclass . $regexpPrices2_2, $response, $matches);
		if (!preg_replace('~[\D]+~', '', $matches[1])) {
			preg_match($regexpPrices2_1 . $tempclass . $regexpPrices3_2, $response, $matches);
		}		
		//print_r($matches); // Цена

		preg_match($regexpName, $response, $matchesName);
		//print_r($matchesName);

		if (trim(@$matches[1])) {
			$vowels = array("\n", "\r", "\t", "\x0B", "&#8203;", "&nbsp;", "&emsp;", "&ensp;");
			$matchesName[1] = str_replace($vowels, ' ', $matchesName[1]);
			$matchesName[1] = str_replace(';', '', $matchesName[1]);
			$matchesName[1] = strip_tags(trim($matchesName[1]));
			$matches[1] = preg_replace('~[\D]+~', '', $matches[1]);
			price_change_detect($url, $matchesName[1], $matches[1], date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['login'].':'.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
			$itemsArray[$url] = array($matchesName[1], $matches[1], date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['ua'], $url);		
			AngryCurl::add_debug_msg($url.' | '.$matchesName[1]." | ".$matches[1]);
			$proxy_ok = 1;
		}	elseif (stripos($response, '/ajax/availability_product/') !== false) {
			$vowels = array("\n", "\r", "\t", "\x0B", "&#8203;", "&nbsp;", "&emsp;", "&ensp;");
			$matchesName[1] = str_replace($vowels, ' ', $matchesName[1]);
			$matchesName[1] = str_replace(';', '', $matchesName[1]);
			$matchesName[1] = strip_tags(trim($matchesName[1]));
			price_change_detect($url, $matchesName[1], '0', date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['login'].':'.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
			$itemsArray[$url] = array($matchesName[1], '0', date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['ua'], $url);		
			AngryCurl::add_debug_msg($url.' | '.$matchesName[1].' | 0');			
			$proxy_ok = 1;
		} else {
			$proxy_ok = 0;
			return 0;
		}

		if (!file_exists(AC_DIR.'/engines/'.ENGINE_CURR.'/data_split/'.date("d.m.y"))) {
			mkdir(AC_DIR.'/engines/'.ENGINE_CURR.'/data_split/'.date("d.m.y"));
		}
		
		file_put_contents('/var/www/philips/engines/fotos.ua/content.txt', $response);
		
		return 1;
	} else {
		AngryCurl::add_debug_msg('bad response');
		$proxy_ok = 0;
		return 0;
	}
}
