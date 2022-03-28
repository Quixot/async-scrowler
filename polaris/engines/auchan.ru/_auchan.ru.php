<?php
/**
 * auchan.ru
 */
	switch (EXTRA_PARAM) {
		case 'moscow': 
			$param1 = '%25D0%259C%25D0%25BE%25D1%2581%25D0%25BA%25D0%25B2%25D0%25B0'; $param2 = '1'; $param3 = '1';  $param4 = '12'; $city = 'Москва';
			break;
		case 'spb': 
			$param1 = '%25D0%25A1%25D0%25B0%25D0%25BD%25D0%25BA%25D1%2582-%25D0%259F%25D0%25B5%25D1%2582%25D0%25B5%25D1%2580%25D0%25B1%25D1%2583%25D1%2580%25D0%25B3'; $param2 = '201'; $param3 = '201';  $param4 = '13'; $city = 'Санкт-Петербург';
			break;
		case 'arhangelsk': 
			$param1 = '%25D0%2590%25D1%2580%25D1%2585%25D0%25B0%25D0%25BD%25D0%25B3%25D0%25B5%25D0%25BB%25D1%258C%25D1%2581%25D0%25BA'; $param2 = '436'; $param3 = '436';  $param4 = '21'; $city = 'Архангельск (Архангельская обл.)';
			break;
		case 'chelyabinsk': 
			$param1 = '%25D0%25A7%25D0%25B5%25D0%25BB%25D1%258F%25D0%25B1%25D0%25B8%25D0%25BD%25D1%2581%25D0%25BA'; $param2 = '229'; $param3 = '229'; $param4 = '17'; $city = 'Челябинск';
			break;
		case 'habarovsk': 
			$param1 = '%25D0%25A5%25D0%25B0%25D0%25B1%25D0%25B0%25D1%2580%25D0%25BE%25D0%25B2%25D1%2581%25D0%25BA'; $param2 = '3986'; $param3 = '3986'; $param4 = '22'; $city = 'Хабаровск';
			break;
		case 'kazan': 
			$param1 = '%25D0%259A%25D0%25B0%25D0%25B7%25D0%25B0%25D0%25BD%25D1%258C'; $param2 = '156'; $param3 = '156'; $param4 = '16'; $city = 'Казань';
			break;
		case 'krasnodar': 
			$param1 = '%25D0%259A%25D1%2580%25D0%25B0%25D1%2581%25D0%25BD%25D0%25BE%25D0%25B4%25D0%25B0%25D1%2580'; $param2 = '165'; $param3 = '165'; $param4 = '18'; $city = 'Краснодар';
			break;
		case 'krasnoyarsk': 
			$param1 = '%25D0%259A%25D1%2580%25D0%25B0%25D1%2581%25D0%25BD%25D0%25BE%25D1%258F%25D1%2580%25D1%2581%25D0%25BA'; $param2 = '1945'; $param3 = '1945'; $param4 = '23'; $city = 'Красноярск';
			break;
		case 'novgorod': 
			$param1 = '%25D0%259D%25D0%25B8%25D0%25B6%25D0%25BD%25D0%25B8%25D0%25B9%2520%25D0%259D%25D0%25BE%25D0%25B2%25D0%25B3%25D0%25BE%25D1%2580%25D0%25BE%25D0%25B4'; $param2 = '237'; $param3 = '237'; $param4 = '20'; $city = 'Нижний Новгород';
			break;
		case 'novosibirsk': 
			$param1 = '%25D0%259D%25D0%25BE%25D0%25B2%25D0%25BE%25D1%2581%25D0%25B8%25D0%25B1%25D0%25B8%25D1%2580%25D1%2581%25D0%25BA'; $param2 = '3'; $param3 = '3'; $param4 = '11'; $city = 'Новосибирск';
			break;
		case 'omsk': 
			$param1 = '%25D0%259E%25D0%25BC%25D1%2581%25D0%25BA'; $param2 = '186'; $param3 = '186'; $param4 = '24'; $city = 'Омск';
			break;
		case 'perm': 
			$param1 = '%25D0%259F%25D0%25B5%25D1%2580%25D0%25BC%25D1%258C'; $param2 = '192'; $param3 = '192'; $param4 = '25'; $city = 'Пермь';
			break;
		case 'petrozavodsk': 
			$param1 = '%25D0%259F%25D0%25B5%25D1%2582%25D1%2580%25D0%25BE%25D0%25B7%25D0%25B0%25D0%25B2%25D0%25BE%25D0%25B4%25D1%2581%25D0%25BA'; $param2 = '2952'; $param3 = '2952'; $param4 = '26'; $city = 'Петрозаводск';
			break;
		case 'pyatigorsk': 
			$param1 = '%25D0%259F%25D1%258F%25D1%2582%25D0%25B8%25D0%25B3%25D0%25BE%25D1%2580%25D1%2581%25D0%25BA'; $param2 = '3166'; $param3 = '3166'; $param4 = '27'; $city = 'Пятигорск';
			break;
		case 'rostov': 
			$param1 = '%25D0%25A0%25D0%25BE%25D1%2581%25D1%2582%25D0%25BE%25D0%25B2-%25D0%25BD%25D0%25B0-%25D0%2594%25D0%25BE%25D0%25BD%25D1%2583'; $param2 = '197'; $param2 = '197'; $param4 = '28'; $city = 'Ростов-на-Дону';
			break;
		case 'samara': 
			$param1 = '%25D0%25A1%25D0%25B0%25D0%25BC%25D0%25B0%25D1%2580%25D0%25B0'; $param2 = '200'; $param3 = '200'; $param4 = '29'; $city = 'Самара';
			break;
		case 'ufa': 
			$param1 = '%25D0%25A3%25D1%2584%25D0%25B0'; $param2 = '224'; $param3 = '224'; $param4 = '30'; $city = 'Уфа';
			break;
		case 'vladivostok': 
			$param1 = '%25D0%2592%25D0%25BB%25D0%25B0%25D0%25B4%25D0%25B8%25D0%25B2%25D0%25BE%25D1%2581%25D1%2582%25D0%25BE%25D0%25BA'; $param2 = '875'; $param3 = '875'; $param4 = '30'; $city = 'Владивосток'; 
			break;
		case 'volgograd': 
			$param1 = '%25D0%2592%25D0%25BE%25D0%25BB%25D0%25B3%25D0%25BE%25D0%25B3%25D1%2580%25D0%25B0%25D0%25B4'; $param2 = '143'; $param3 = '143'; $param4 = '14'; $city = 'Волгоград';
			break;
		case 'voronezh': 
			$param1 = '%25D0%2592%25D0%25BE%25D1%2580%25D0%25BE%25D0%25BD%25D0%25B5%25D0%25B6'; $param2 = '147'; $param3 = '147'; $param4 = '15'; $city = 'Воронеж';
			break;
		case 'yekaterinburg': 
			$param1 = '%25D0%2595%25D0%25BA%25D0%25B0%25D1%2582%25D0%25B5%25D1%2580%25D0%25B8%25D0%25BD%25D0%25B1%25D1%2583%25D1%2580%25D0%25B3'; $param2 = '152'; $param3 = '152'; $param4 = '19'; $city = 'Екатеринбург';
			break;		
	 	default:
 		die("Unknown region\n");  	 		
	}	

	$directLinks = array(
			'https://www.auchan.ru/pokupki/yandexsearch/result/index/q/polaris'
		);
	$regexpPrices  = "~<article(.+)</article~isU";
	$regexpPrices2 = "~class=\"products__item-link\" href=\"(.+)\".*>(.+)<.*current-price\">.*class=\"price-val\">(.+)<~isU";
	$regexpRegion  = "~data-bind=\"text:cityName\">(.+)<~isU";

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

	foreach ($directLinks as $url) {
		if (!in_array($url, $already_scanned)) {
			echo 'сканирую адрес:'.PHP_EOL.$url.PHP_EOL;
			$i = 1;
			while ( regular_one($url)<1 && $i<4 ) {
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
	global $regexpPrices;
	global $regexpPrices2;
	global $itemsArray;
	global $bad_urls;
	global $param1;
	global $param2;
	global $param3;
	global $param4;
	global $city;
	global $regexpRegion;
	global $time_start;

	$proxarr = get_proxy_and_ua('/var/www/lib/proxies/', '/var/www/lib/useragents_short.txt');

	$cmd = 'timeout -k 30s 31s casperjs --ignore-ssl-errors=true --ssl-protocol=any /var/www/polaris/engines/auchan.ru/script.js '.escapeshellarg(trim($url)).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'].' '.escapeshellarg($param1).' '.escapeshellarg($param2).' '.escapeshellarg($param3).' '.escapeshellarg($param4);// 

	echo $cmd.PHP_EOL;
	$response = exec($cmd, $out, $err);
	$response = stripcslashes($response);

	
	if (strlen($response) > 500) {
		echo 'response ok'.PHP_EOL;
		//file_put_contents('/var/www/polaris/engines/dns-shop.ru/content.txt', $response);
  	preg_match($regexpRegion, $response, $mregion);
  	$mregion[1] = trim($mregion[1]);
  	echo 'Регион: '.$mregion[1].' | '.$city.PHP_EOL;

  	// Проверка региона
  	if (stripos($mregion[1], $city)  === false ) {
  		echo 'Регионы не совпадают'.PHP_EOL;
  		return 0;
  	}

  	preg_match_all($regexpPrices, $response, $matches_items, PREG_SET_ORDER);
  	//print_r($matches_items);
  	foreach ($matches_items as $key) {
	  	if (strripos($key[1], 'В корзину') !== false) {
	  		preg_match($regexpPrices2, $key[1], $matches);
	  		if ($matches[1] && $matches[2]) {
		  		$matches[1] = trim($matches[1]);
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




function callback_one($response, $info, $request) {
  global $regexpPagin;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $time_start;
	global $itemsArray;

	//proxy_statistics($response, $info, $request);
	//file_put_contents('/var/www/polaris/engines/auchan.ru/'.time(), $response);

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200 || strlen($response) < 500) {            
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 540) $bad_urls=array();
  } else {
    preg_match($regexpPagin, $response, $matches);
    //file_put_contents(AC_DIR.'/items/'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.txt', preg_replace('~[^\d]+~', '' , $matches[1]));

    $temp = ceil(preg_replace('~[^\d]+~', '' , $matches[1]) / 96);
    if ($temp > $qOfPaginationPages) {      
	    $qOfPaginationPages = $temp;
    }

  	preg_match_all($regexpPrices, $response, $matches_items, PREG_SET_ORDER);
  	//print_r($matches_items);
  	foreach ($matches_items as $key) {
	  	if (strripos($key[1], 'В корзину') !== false) {
	  		preg_match($regexpPrices2, $key[1], $matches);
	  		if ($matches[1] && $matches[2]) {
		  		$matches[1] = trim($matches[1]);
		  		$matches[2] = trim($matches[2]);
		  		$matches[3] = preg_replace('~[^\d]+~', '' , $matches[3]);
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);	
	  		}			
			}
		}
  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $itemsArray;
	global $bad_urls;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);
    if (round(microtime(1) - $time_start, 0) >= 540) $bad_urls=array();
  } else {	
  	preg_match_all($regexpPrices, $response, $matches_items, PREG_SET_ORDER);
  	foreach ($matches_items as $key) {
	  	if (strripos($key[1], 'old_price')) {
				preg_match($regexpPrices2, $key[1], $matches);
			} else {
				preg_match($regexpPrices2, $key[1], $matches);
				if (@!$matches[1]) {
					preg_match($regexpPrices4, $key[1], $matches);
				}
			}
			$matches = clean_info($matches, array(1,2,3), 'utf-8');
	  	if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}
		}
  }
}





