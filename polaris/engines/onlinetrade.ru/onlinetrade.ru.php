<?php
/**
 * onlinetrade.ru
 */
	switch (EXTRA_PARAM) {
	  case 'moscow': $region = '1;user_c=14'; break;
	  case 'spb': $region = '2;user_c=60'; break;
	  case 'rostov':$region = '15;user_c=57'; break;
	  case 'novosibirsk':$region = '24;user_c=52'; break;
	 	case 'yekaterinburg':$region = '5;user_c=35'; break;
	 	case 'chelyabinsk':$region = '7;user_c=42'; break; 
	 	case 'kazan':$region = '12;user_c=39'; break;
	 	case 'krasnodar':$region = '9;user_c=43'; break;
	 	case 'novgorod':$region = '4;user_c=47'; break; 
	 	case 'perm':$region = '16;user_c=55'; break; 	
	 	case 'samara':$region = '19;user_c=59'; break;
	 	case 'ufa':$region = '18;user_c=66'; break;
	 	case 'volgograd':$region = '28;user_c=31'; break;
	 	case 'voronezh':$region = '27;user_c=32'; break; 
		case 'bryansk': $region = '34;user_c=28'; break;
		case 'velikijnovgorod': $region = '35;user_c=29'; break;
		case 'vladimir': $region = '17;user_c=30'; break;
		case 'izhevsk': $region = '8;user_c=36'; break;
		case 'joshkar-ola': $region = '33;user_c=38'; break;
		case 'kaluga': $region = '14;user_c=40'; break;
		case 'lipeck': $region = '25;user_c=45'; break;
		case 'naberezhnye-chelny': $region = '21;user_c=46'; break;
		case 'orel': $region = '29;user_c=53'; break;
		case 'penza': $region = '31;user_c=54'; break;
		case 'ryazan': $region = '20;user_c=58'; break;
		case 'saratov': $region = '30;user_c=61'; break;
		case 'tver': $region = '10;user_c=63'; break;
		case 'tolyatti': $region = '26;user_c=64'; break;
		case 'tula': $region = '3;user_c=50'; break;
		case 'tyumen': $region = '22;user_c=65'; break;
		case 'cheboksary': $region = '13;user_c=67'; break;
	 	default:
	 		die("Unknown region\n"); 		
	}

	$options 			 = array(
									CURLOPT_COOKIE => 'user_city=' . $region,
									CURLOPT_COOKIEJAR       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
	        				//CURLOPT_COOKIEFILE      => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
	        				CURLOPT_RETURNTRANSFER => true,
	                CURLOPT_CONNECTTIMEOUT => 40,
	                CURLOPT_TIMEOUT        => 60,
	                CURLOPT_AUTOREFERER     => TRUE,
	                CURLOPT_FOLLOWLOCATION  => TRUE,
	                CURLOPT_HEADER => true, 
	                CURLOPT_SSL_VERIFYPEER => 0,
	                CURLOPT_SSL_VERIFYHOST => 0
		);

	$urlStart 		 = 'https://www.onlinetrade.ru/sitesearch.html?query=' . ENGINE_TYPE;				// Первая часть адреса
	$urlEnd				 = '';							 				// Вторая часть адреа и поисковая строка
	$regexpP1 		 = "~class=\"paginator\"(.*)</div>~isU";
	$regexpP2 		 = "~<a.*>(.+)<~isU";
	$regexpPrices  = "~<div class=\"indexGoods__item\">(.+)</div></div></div></div>~isU";
	$regexpPrices2 = "~indexGoods__item__descriptionCover.*href=\"(.+)\".*>(.+)</a.*class=\"price regular\">(.+)<~isU";
	$regexpRegion  = "~header__citySelectLink js__ajaxExchange.*>(.+)<~isU";

	foreach ($itemsArray as $key => $value) {
		$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
		//echo (time() - $date->format('U')).PHP_EOL; 
		if (time() - $date->format('U') <= 1800) {
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

	if (!in_array('https://www.onlinetrade.ru/sitesearch.html?query=polaris', $already_scanned)) {
		echo 'сканирую адрес:'.PHP_EOL.'https://www.onlinetrade.ru/sitesearch.html?query=polaris'.PHP_EOL;
		$i = 1;
		while ( regular_one('https://www.onlinetrade.ru/sitesearch.html?query=polaris')<1 && $i<3 ) {
			$i++;
		}
	} else {
		echo 'уже сканировал:'.PHP_EOL.'https://www.onlinetrade.ru/sitesearch.html?query=polaris'.PHP_EOL;
	}

	sleep(20);

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

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));	
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function regular_one($url) {
  global $regexpP1;
  global $regexpP2;
  global $regexpRegion;
  global $qOfPaginationPages;  
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;
	global $itemsArray;
	global $subdomen;
	global $time_start;

	$proxarr = get_proxy_and_ua('/var/www/lib/proxies/16.proxy', '/var/www/lib/useragents_short.txt');
	

	//$cmd = 'timeout -k 60s 61s casperjs /var/www/polaris/engines/vstroyka-solo.ru/'.$filenum.' '.escapeshellarg('https://vstroyka-solo.ru/').' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'].' '.$region.' '.$pagin.' '.ENGINE_TYPE;

	$cmd = 'timeout -k 60s 61s casperjs /var/www/polaris/engines/onlinetrade.ru/casper.js '.escapeshellarg($url).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'].' '.EXTRA_PARAM;

	echo $cmd.PHP_EOL;die();
	$response = exec($cmd, $out, $err);
	$response = implode(" ", $out);

	file_put_contents("/var/www/polaris/engines/onlinetrade.ru/content.txt", $response);
	//die();
	if (strlen($response) > 1000) {
		echo 'response ok'.PHP_EOL;

		preg_match($regexpRegion, $response, $mReg);
		AngryCurl::add_debug_msg('Регион: '.iconv('windows-1251', 'utf-8', $mReg[1]));

		preg_match($regexpP1, $response, $matches);
		////print_r($matches);
		preg_match_all($regexpP2, $matches[1], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			////echo"key: " . $key . "\n";
			////echo"value:" . $value . "\n";
			if (is_numeric($value)) {
				$temparrpage[] = $value;
			}
		}

		if (@max($temparrpage) > $qOfPaginationPages) {
			////echo"Страницы: " . $temparrpage . "\n";
			$qOfPaginationPages = @max($temparrpage);	    	
		}

  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
  	foreach ($matches2 as $key) {
  		if (strripos($key[1], 'button button__orange js__ajaxExchange') !== false) {
				preg_match($regexpPrices2, $key[1], $matches);
				if (@$matches[1]) {
					$matches[1] = 'https://'.ENGINE_CURR.trim($matches[1]);
					$matches[2] = strip_tags(trim(iconv('windows-1251', 'utf-8', $matches[2])));
					$matches[3] = preg_replace('~[^\d.]+~', '', $matches[3]);
					
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['login'].':'.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['ua'], $url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);		  			
	  		}
			} else {
				preg_match($regexpPrices2, $key[1], $matches);
				if (@$matches[1]) {
					$matches[1] = 'https://'.ENGINE_CURR.trim($matches[1]);
					$matches[2] = strip_tags(trim(iconv('windows-1251', 'utf-8', $matches[2])));

					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['login'].':'.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], '0', date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['ua'], $url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | 0');	  			
	  		}
			}
		}
		return 1;
	} else {
		echo substr($response, 0, 500);
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}



function callback_one($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;
  global $regexpRegion;
  global $qOfPaginationPages;  
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;
	global $itemsArray;
	global $subdomen;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

	file_put_contents("/var/www/polaris/engines/onlinetrade.ru/content.txt", $response);

  if ($info['http_code'] !== 200) {            
    if (stripos($info->request, ENGINE_CURR)) {
      $bad_urls[] = $info->request;
    }
    if (round(microtime(1) - $time_start, 0) >= 60) { $bad_urls = array(); }
  } else {
		preg_match($regexpRegion, $response, $mReg);
		AngryCurl::add_debug_msg('Регион: '.iconv('windows-1251', 'utf-8', $mReg[1]));

		preg_match($regexpP1, $response, $matches);
		////print_r($matches);
		preg_match_all($regexpP2, $matches[1], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			////echo"key: " . $key . "\n";
			////echo"value:" . $value . "\n";
			if (is_numeric($value)) {
				$temparrpage[] = $value;
			}
		}

		if (@max($temparrpage) > $qOfPaginationPages) {
			////echo"Страницы: " . $temparrpage . "\n";
			$qOfPaginationPages = @max($temparrpage);	    	
		}

  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
  	foreach ($matches2 as $key) {
  		if (strripos($key[1], 'button button__orange js__ajaxExchange') !== false) {
				preg_match($regexpPrices2, $key[1], $matches);
				if (@$matches[1]) {
					$matches[1] = 'https://'.ENGINE_CURR.trim($matches[1]);
					$matches[2] = strip_tags(trim(iconv('windows-1251', 'utf-8', $matches[2])));
					$matches[3] = preg_replace('~[^\d.]+~', '', $matches[3]);
					
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);		  			
	  		}
			} else {
				preg_match($regexpPrices2, $key[1], $matches);
				if (@$matches[1]) {
					$matches[1] = 'https://'.ENGINE_CURR.trim($matches[1]);
					$matches[2] = strip_tags(trim(iconv('windows-1251', 'utf-8', $matches[2])));

					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | 0');	  			
	  		}
			}
		}
  }
}
