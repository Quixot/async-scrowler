<?php
/**
 * mvideo.ru Москва Новосибирск
 */
	switch (EXTRA_PARAM) {
	  case 'cheboksary': $region = 'CityR_67'; $city = 'Чебоксары'; break;
	  case 'chelyabinsk': $region = 'CityCZ_1216'; $city = 'Челябинск'; break;
	  case 'habarovsk': $region = 'CityDE_28834'; $city = 'Хабаровск'; break;
	  case 'kazan': $region = 'CityCZ_1458'; $city = 'Казань'; break;
	  case 'krasnodar': $region = 'CityCZ_2128'; $city = 'Краснодар'; break;
	  case 'krasnoyarsk': $region = 'CityCZ_1854'; $city = 'Красноярск'; break;
	  case 'moscow': $region = 'CityCZ_975'; $city = 'Москва'; break;
	  case 'naberezhnye-chelny': $region = 'CityCZ_15563'; $city = 'Набережные Челны'; break;
	  case 'novgorod': $region = 'CityCZ_974'; $city = 'Нижний Новгород'; break;
	  case 'novosibirsk': $region = 'CityCZ_2246'; $city = 'Новосибирск'; break;
	  case 'omsk': $region = 'CityCZ_9909'; $region_name = 'Омск'; break;
		case 'rostov': $region = 'CityCZ_2446'; $city = 'Ростов-на-Дону'; break;
	  case 'samara': $region = 'CityCZ_1780'; $city = 'Самара'; break;
	  case 'spb': $region = 'CityCZ_1638'; $city = 'Санкт-Петербург'; break;    
	 	case 'ufa': $region = 'CityCZ_2534'; $city = 'Уфа'; break;
	  case 'vladivostok': $region = 'CityDE_31146'; $city = 'Владивосток'; break;  
	  case 'volgograd': $region = 'CityCZ_1272'; $city = 'Волгоград'; break;
	 	case 'yekaterinburg': $region = 'CityCZ_2030'; $city = 'Екатеринбург'; break;
	 	case 'chelyabinsk': $region = 'CityCZ_1216'; $city = 'Челябинск'; break;	
	 	default:
	 		die("Unknown region\n");    	
	}

	// Загрузка отсканированных ссылок:

	foreach ($itemsArray as $key => $value) {
		$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
		//echo (time() - $date->format('U')).PHP_EOL; 
		if (time() - $date->format('U') <= 15000) {
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

/*
		$proxy_array = glob('/var/www/lib/proxies/15.proxy');
		$alive_proxy_list = '';
		foreach ($proxy_array as $key) {
			$alive_proxy_list .= file_get_contents($key);
			$alive_proxy_list .= "\n";
		}
		$alive_proxy_list = trim($alive_proxy_list);	
		if ($alive_proxy_list) {
			$alive_proxy_list = explode("\n", $alive_proxy_list);
			shuffle($alive_proxy_list);	
			$AC->__set('array_proxy', $alive_proxy_list);
			$AC->__set('n_proxy', count($alive_proxy_list));
			$AC->add_debug_msg("Ускоренная загрузка proxy:\n");	
		}
*/

	$options 			= array(
		CURLOPT_COOKIE => 'MVID_CITY_ID=' . $region,
		//CURLOPT_COOKIEFILE      => '/var/www/polaris/engines/mvideo.ru/cook.txt',
		CURLOPT_COOKIEJAR => '/var/www/polaris/engines/mvideo.ru/xxx/1.txt',
    CURLOPT_AUTOREFERER     => true,
    CURLOPT_FOLLOWLOCATION  => true,
    CURLOPT_CONNECTTIMEOUT => 20,
    CURLOPT_TIMEOUT        => 20, 
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_SSL_VERIFYHOST => 0,
	);

	$regexpPrices = "~class=\"product-tile-picture\"(.+)<div class=\"product-tile-gift-card\">~isU"; // Все товары на странице
	$regexpPrices2 = "~class=\"product-tile-description\".*<a href=\"(.+)\".*>(.+)<.*class=\"product-price-current.*>(.+)<~isU";
	$regexpPrices3 = "~class=\"product-tile-description\".*<a href=\"(.+)\".*>(.+)<~isU"; // Режем карточки товара

	$directLinks = explode("\n", file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/links.txt'));
	array_walk($directLinks, 'trim_value');

	$is_any = 0;
	for ($i = 0; $i < count($directLinks); $i++) {
		if (!in_array($directLinks[$i], $already_scanned)) {
			echo 'сканирую адрес:'.PHP_EOL.$directLinks[$i].PHP_EOL;
			$AC->get($directLinks[$i], null, $options);
			$is_any = 1;
		} else {
			echo 'уже сканировал:'.PHP_EOL.$directLinks[$i].PHP_EOL;
		}
	}
	
	if ($is_any) {
		$AC->execute(WINDOW_SIZE);
	}

	while ($bad_urls) {
	  $AC->flush_requests();
	  foreach ($bad_urls as $urls) {
	    $AC->get($urls, NULL, $options);
	  }
	  unset($urls);
	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}
	unset($urls);

	// Сохраним массив в переменную
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';
	file_put_contents('/var/www/polaris/engines/mvideo.ru/ua.txt', print_r($usag, 1));




/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $city;
  global $bad_urls;
  global $region;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
	global $time_start;
	global $usag;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

	//file_put_contents('/var/www/polaris/engines/mvideo.ru/content.txt', $response);
	//die();

  if ($info['http_code'] !== 200) {
  	if ($info['http_code'] !== 404) {
    	$bad_urls[] = $request->url;   
    	if (round(microtime(1) - $time_start, 0) >= 800) $bad_urls = array();  
    }   
  } else {
  	
  	preg_match("~header-top-line__link-text.*>(.+)<~isU", $response, $matchesRegion);
  	//print_r($matchesRegion);
  	$matchesRegion[1] = trim($matchesRegion[1]);

  	AngryCurl::add_debug_msg($matchesRegion[1].' | '.$city);	

		if ($matchesRegion[1] == $city) {
		  preg_match("~<h1.*>(.+)<~isU", $response, $m_name);
		  //print_r($m_name);
		  $name = trim($m_name[1]);

		  preg_match("~'productPriceLocal': '(.+)\.~isU", $response, $m_price);
		  //print_r($m_price);
		  $price = trim($m_price[1]);
		  $price = preg_replace('~[\D]+~', '' , $price);

		  preg_match("~'productAvailability': '(.+)'~isU", $response, $m_avail);
		  //print_r($m_avail);
		  $avail = trim($m_avail[1]);

		  if ($avail == 'available') {
				price_change_detect($request->url, $name, $price, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$request->url] = array($name, $price, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
				AngryCurl::add_debug_msg($request->url.' | '.$name.' | '.$price);
				$usag[] = $request->options[10004];
		  } else {
				price_change_detect($request->url, $name, '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$request->url] = array($name, '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
				AngryCurl::add_debug_msg($request->url.' | '.$name.' | '.'0');	
				$usag[] = $request->options[10004];
		  }


		}
  }
}
