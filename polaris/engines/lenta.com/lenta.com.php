<?php
/**
 * lenta.com
 */
	switch (EXTRA_PARAM) {
		case 'moscow': $region = 'msk'; $store = '0124'; $city = 'Москва'; $store_array = array('0124'); break;
		case 'spb': $region = 'spb'; $store = '0009'; $city = 'Санкт-Петербург'; $store_array = array('0006', '0718', '0018', '0726', '0710', '0717', '0210', '0737', '0004', '0013', '0005', '0703', '0007', '0719', '0727', '0725', '0709', '0049', '0701', '0707', '0010', '0019', '0734', '0265', '0017', '0267', '0268', '0011', '0002', '0271', '0702', '0272', '0012', '0713', '0003', '0266', '0716', '0001', '0273', '0704'); break;
		case 'arhangelsk': $region = 'arh'; $store = '0218'; $city = 'Архангельск'; break;
		case 'chelyabinsk': $region = 'chlb'; $store = '0069'; $city = 'Челябинск'; break;
		case 'kazan': $region = 'kazan'; $store = '0219'; $city = 'Казань'; break;
		case 'krasnodar': $region = 'krasnodar'; $store = '0038'; $city = 'Краснодар'; break;
		case 'krasnoyarsk': $region = 'krsn'; $store = '0087'; $city = 'Красноярск'; break;
		case 'novgorod': $region = 'nnvgrd'; $store = '0051'; $city = 'Нижний Новгород'; break;
		case 'novosibirsk': $region = 'nsk'; $store = '0173'; $city = 'Новосибирск'; break;
		case 'omsk': $region = 'omsk'; $store = '0082'; $city = 'Омск'; break;
		case 'perm': $region = 'prm'; $store = '0297'; $city = 'Пермь'; break;
		case 'petrozavodsk': $region = 'karelia'; $store = '0016'; $city = 'Петрозаводск'; break;
		case 'rostov': $region = 'rnd'; $store = '0191'; $city = 'Ростов-на-Дону'; break;
		case 'samara': $region = 'smr'; $store = '0217'; $city = 'Самара'; break;
		case 'ufa': $region = 'ufa'; $store = '0200'; $city = 'Уфа'; break;
		case 'volgograd': $region = 'vlg'; $store = '0136'; $city = 'Волгоград'; break;
		//case 'voronezh': $region = 'vrn'; $store = ''; $city = 'Воронеж'; break;
		case 'yekaterinburg': $region = 'ekat'; $store = '0229'; $city = 'Екатеринбург'; break;		
	 	default:
 		die("Unknown region\n");  	 		
	}	

	$options = array(
				CURLOPT_COOKIE => 'Store='.$store.';CityCookie='.$region,
        CURLOPT_COOKIEFILE      => 'xxx',
        CURLOPT_AUTOREFERER     => TRUE,
        CURLOPT_FOLLOWLOCATION  => TRUE
		);

	$urlStart  = 'https://lenta.com/search/?searchText=polaris';
	$regRegion = "~js-default-store-notice.*>(.+)<~isU";
	$regexpPrices  = "~class=\"sku-card-small.*>(.+)</button>~isU";
	$regexpPrices2 = "~href=\"(.+)\".*__title\">(.+)<.*class=\"sku-price__integer\">(.+)<~isU";



	// Загрузка отсканированных ссылок:
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
	if ($_GET) {
		$already_scanned = array();
	}

	$links = array(
'https://lenta.com/search/?searchText=polaris',
'https://lenta.com/search/?searchText=polaris',
/*
'https://lenta.com/catalog/bytovaya-tehnika-i-elektronika/prigotovlenie-napitkov/elektricheskie-chajjniki/?BrandName=POLARIS',
'https://lenta.com/catalog/bytovaya-tehnika-i-elektronika/krasota-i-zdorove/ukladka-volos/?BrandName=POLARIS',
'https://lenta.com/catalog/bytovaya-tehnika-i-elektronika/prigotovlenie-napitkov/termopoty/?BrandName=POLARIS',
'https://lenta.com/catalog/bytovaya-tehnika-i-elektronika/melkaya-bytovaya-tehnika-dlya-gotovki/?BrandName=POLARIS',
'https://lenta.com/catalog/posuda/?BrandName=POLARIS',
'https://lenta.com/catalog/bytovaya-tehnika-i-elektronika/tehnika-dlya-doma/?BrandName=POLARIS',
'https://lenta.com/catalog/bytovaya-tehnika-i-elektronika/?BrandName=POLARIS',
'https://lenta.com/catalog/bytovaya-tehnika-i-elektronika/krasota-i-zdorove/vesy-napolnye/?BrandName=POLARIS',
*/
		);

	$is_in = 0;
	foreach ($links as $url) {
		if (!in_array($url, $already_scanned)) {
			echo 'сканирую адрес:'.PHP_EOL.$url.PHP_EOL;
			$AC->get($url, null, $options);
			$is_in = 1;
		} else {
			echo 'уже сканировал:'.PHP_EOL.$url.PHP_EOL;
		}
	}
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
	  $AC->flush_requests(); // Чистим массив запросов
	  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
	    $AC->get($urls, NULL, $options);  
	  }
	  unset($urls);

	  $bad_urls = array();    // Чистим массив URL-ов для следующего (возможного) цикла    
	  $AC->execute(WINDOW_SIZE);       // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
	}
	unset($urls);	

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;
	global $regexpPrices;
	global $regexpPrices2;
	global $city;
	global $itemsArray;
	global $errorsArray;
  global $qOfPaginationPages;
  global $bad_urls;
  global $time_start;
  global $avail;
  global $regRegion;

  //file_put_contents('/var/www/polaris/engines/lenta.com/content.txt', $response);
  //echo $response;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);  

  if ($info['http_code'] !== 200) {
    $bad_urls[] = $request->url;
		if (round(microtime(1) - $time_start, 0) >= 160) { $bad_urls = array(); } 
  } else {

  	preg_match($regRegion, $response, $mReg);
  	$mReg[1] = trim(strip_tags($mReg[1]));
  	AngryCurl::add_debug_msg($mReg[1].' | '.$city);


  	if (stripos($response, 'class="search-results-container"') !== false) {
  		preg_match("~class=\"search-results-container\"(.+)<div~isU", $response, $matches);
  		//print_r($matches);
  		if ($matches[1]) {
  			preg_match_all("~title&quot;:&quot;(.+)&quot;.*cardPrice.*integerPart&quot;:&quot;(.+)&quot;.*skuUrl&quot;:&quot;(.+)&quot;~isU", $response, $matches2, PREG_SET_ORDER);
  			//print_r($matches2);
  			foreach ($matches2 as $key => $value) {
  				if ($value[1] && $value[2] && $value[3]) {
  					$value[2] = preg_replace('~[^\d.]+~', '', $value[2]);
						price_change_detect(
							'https://'.ENGINE_CURR.trim($value[3]), trim($value[1]), trim($value[2]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE
							);
						$itemsArray['https://'.ENGINE_CURR.trim($value[3])] = array(
							trim($value[1]), trim($value[2]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url
						);			
						AngryCurl::add_debug_msg('https://'.ENGINE_CURR.trim($value[3]).' | '.trim($value[1]).' | '.trim($value[2]));
  				}
  			}
  		}
  	}


  	if (2 == 2) { //$mReg[1] == $city
		  preg_match_all($regexpPrices, $response, $matches, PREG_SET_ORDER);
		  //print_r($matches);
			foreach ($matches as $key) {
				preg_match($regexpPrices2, $key[1], $matches2);
				if ($matches2[1] && $matches2[2]) {
							$price = str_replace('&#160;', '', $matches2[3]);
							$price = preg_replace('~[^\d.]+~', '', $price);

							price_change_detect('https://'.ENGINE_CURR.$matches2[1], trim($matches2[2]), $price, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
							$itemsArray['https://'.ENGINE_CURR.$matches2[1]] = array(
								trim($matches2[2]), 
								$price,
								date("d.m.y-H:i:s"),
								$request->options[10004],
								$request->options[10018],
								$request->url
							);			
							AngryCurl::add_debug_msg(trim($matches2[2]).' | '.$price);
				}
			}
		} 
  }
}


function callback_one_arch($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $city;
	global $itemsArray;
	global $errorsArray;
  global $qOfPaginationPages;
  global $bad_urls;
  global $time_start;
  global $avail;
  global $regRegion;

  //file_put_contents('/var/www/polaris/engines/lenta.com/content.txt', $response, 1);
  //echo $response;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);  

  if ($info['http_code'] !== 200) {
    $bad_urls[] = $request->url;
		if (round(microtime(1) - $time_start, 0) >= 60) { $bad_urls = array(); } 
  } else {
  	/*
  	preg_match($regRegion, $response, $mReg);
  	$mReg[1] = trim(strip_tags($mReg[1]));
  	AngryCurl::add_debug_msg($mReg[1].' | '.$city);
		*/
  	if (2 == 2) { //$mReg[1] == $city
  		$json = json_decode($response);

			foreach ($json as $key) {
				/*
				AngryCurl::add_debug_msg($key->skuUrl);
				AngryCurl::add_debug_msg($key->title);
				AngryCurl::add_debug_msg($key->cardPrice->value);
				AngryCurl::add_debug_msg($key->quantity);
				*/
				
							price_change_detect('http://'.ENGINE_CURR.$key->skuUrl, trim($key->title), $key->cardPrice->value, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
							$itemsArray['http://'.ENGINE_CURR.$key->skuUrl] = array(
								trim($key->title), 
								$key->cardPrice->value,
								date("d.m.y-H:i:s"),
								$request->options[10004],
								$request->options[10018],
								$request->url
							);			
							AngryCurl::add_debug_msg(trim($key->title).' | '.$key->cardPrice->value);
				
			}
		} 
  }
}


function regular_one($url) {
	global $regexpPrices;
	global $regexpPrices2;
	global $itemsArray;
	global $bad_urls;
	global $city;
	global $regexpRegion;
	global $time_start;

	$proxarr = get_proxy_and_ua('/var/www/lib/proxies/*', '/var/www/lib/useragents_short.txt');

	$cmd = 'timeout -k 120s 121s casperjs /var/www/polaris/engines/lenta.com/script.js '.escapeshellarg($url).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'];// .' '.escapeshellarg($param1).' '.escapeshellarg($param2).' '.escapeshellarg($param3).' '.escapeshellarg($param4)

	echo $cmd.PHP_EOL;
	
	$response = exec($cmd, $out, $err);
	$response = stripcslashes($response);
	//$response = stripcslashes(implode(' ', $out));
	//print_r($out);
	file_put_contents('/var/www/polaris/engines/lenta.com/content.txt', print_r($response, 1));

	
	if (strlen($response) > 1500) {
		echo 'response ok'.PHP_EOL;
		
  	/*
  	preg_match($regexpRegion, $response, $mregion);
  	$mregion[1] = trim($mregion[1]);
  	echo 'Регион: '.$mregion[1].' | '.$city.PHP_EOL;  	
  	// Проверка региона
  	if (stripos($mregion[1], $city)  === false ) {
  		echo 'Регионы не совпадают'.PHP_EOL;
  		return 0;
  	}
		*/
  	preg_match_all($regexpPrices, $response, $matches_items, PREG_SET_ORDER);
  	print_r($matches_items);
  	foreach ($matches_items as $key) {
	  	if (strripos($key[1], 'Добавить в список покупок') !== false) {
	  		preg_match($regexpPrices2, $key[1], $matches);
	  		if ($matches[1] && $matches[2]) {
		  		$matches[1] = 'https://lenta.com'.trim($matches[1]);
		  		$matches[2] = trim($matches[2]);
		  		$matches[3] = preg_replace('~[^\d]+~', '' , $matches[3]);
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['login'].':'.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].':'.$proxarr['port'], $proxarr['ua'], $url);		
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);	
	  		}			
			}
		}
		return 1;
	} else {
		echo substr($response, 0, 500);
		echo PHP_EOL.'bad response'.PHP_EOL;
		return 0;
	}
}
