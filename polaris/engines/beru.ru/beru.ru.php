<?php

		$proxy_array = array(
			'/var/www/lib/proxies/16.proxy',
			'/var/www/lib/proxies/17.proxy',
		);

		//print_r($proxy_array);die();
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

if (!$_GET) {
	if (date('N') != '6' && date('N') != '7') {
		if ($currTime == '5' || $currTime == '11' || $currTime == '19') { // Обнуление 
		  $itemsArray = array();
		  $already_scanned = array();
			echo "New file\n";
		}
	}
} else {
	$itemsArray = array();
}

			//$itemsArray = array();
		  //$already_scanned = array();
		  $seller_page = '0'; // Важный костыль для второго варианта страницы
/**
 * beru.ru
 */
// Загрузка отсканированных ссылок:
foreach ($itemsArray as $key => $value) {
	$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
	//echo (time() - $date->format('U')).PHP_EOL; 
	if (time() - $date->format('U') <= 12000) {
		$already_scanned[] = $value[5];
	}	
}
if ($already_scanned) {
	$already_scanned = array_unique($already_scanned);
	$already_scanned = array_values($already_scanned);
	print_r($already_scanned); 
} else {
	$already_scanned = array();
}

if ($_GET) {
	$already_scanned = array();
}

$lr = '';
$type = 1;

switch (EXTRA_PARAM) {
  case 'moscow':
  	$type = 3;
    $region = '';
    $lr = '&lr=213&viewtype=grid';
    $regionName = 'Москва';
    break;
  case 'spb':
  	$type = 3;
    $region = 'spb.';
    $lr = '&lr=2&viewtype=grid';
    $regionName = 'Санкт-Петербург';
		break;
  case 'rostov':
  	$type = 3;
    $region = 'rostov.';
    $lr = '&lr=39&viewtype=grid';
    $regionName = 'Ростов-на-Дону';
    break;
  case 'novosibirsk':
  	$type = 3;
    $region = 'nsk.';
    $lr = '&lr=65&viewtype=grid';
    $regionName = 'Новосибирск';
    break;
  case 'yekaterinburg':
  	$type = 3;
    $region = 'ekb.';
    $lr = '&lr=54&viewtype=grid';
    $regionName = 'Екатеринбург';
    break;
  case 'vladivostok':
  	$type = 3;
    $region = 'vladivostok.';
    $lr = '&?lr=75&viewtype=grid';
    $regionName = 'Владивосток';
    break;
  case 'samara':
  	$type = 3;
    $region = 'samara.';
    $lr = '&lr=51&viewtype=grid';
    $regionName = 'Самара';
    break;
  case 'volgograd':
    $type = 3;
    $region = 'volgograd.';
    $lr = '&lr=38&viewtype=grid';
    $regionName = 'Волгоград';
    break;
  case 'chelyabinsk':
  	$type = 3;
    $region = 'chelyabinsk.';
    $lr = '&lr=56&viewtype=grid';
    $regionName = 'Челябинск';
    break;
  case 'krasnodar':
  	$type = 3;
    $region = 'krasnodar.';
    $lr = '&lr=35&viewtype=grid';
    $regionName = 'Краснодар';
    break; 
  case 'omsk':
  	$type = 3;
    $region = 'omsk.';
    $lr = '&lr=66&viewtype=grid';
    $regionName = 'Омск';
    break;
  case 'novgorod':
  	$type = 3;
    $region = '';
    $lr = '&lr=47&viewtype=grid';
    $regionName = 'Нижний Новгород';  
    break;
  case 'ufa':
  	$type = 3;
    $region = '';
    $lr = '&lr=172&viewtype=grid';
    $regionName = 'Уфа';
    break;
  case 'krasnoyarsk':
  	$type = 3;
    $region = '';
    $lr = '&lr=62&viewtype=grid';
    $regionName = 'Красноярск';
    break;
  case 'kazan':
  	$type = 3;
    $region = '';
    $lr = '&lr=43&viewtype=grid';
    $regionName = 'Казань';
    break;
  case 'habarovsk':
  	$type = 3;
    $region = '';
    $lr = '&lr=76&viewtype=grid';
    $regionName = 'Хабаровск';
    break;
  case 'naberezhnye-chelny':
  	$type = 3;
    $region = '';
    $lr = '&lr=236&viewtype=grid';
    $regionName = 'Набережные Челны';
    break;
  case 'cheboksary':
  	$type = 3;
    $region = '';
    $lr = '&lr=45&viewtype=grid';
    $regionName = 'Чебоксары';
    break;
  case 'arhangelsk':
  	$type = 3;
    $region = '';
    $regionName = 'Архангельск';
    break;
 	default:
 		die("Unknown region\n");  	 		
}


$regP = '~"totalModels":(.+),~isU';
$regP = "~найдено(.+)результат~isU";

$regexpPrices1 = "~<div data-zone-name=\"snippet(.+)</button></div></div></div></div></div>~isU";
$regexpPrices2 = "~href=\"(.+)\".*title=\"(.+)\".*<span data-tid.*>(.+)</span>~isU";

$regRegion = '~"entity":"region".*"name":"(.+)"~isU';
$regRegion = "~title=\"Регион\".*<div.*>(.+)</div~isU";



if ($type == 3) {
/**
 * Loading Cookies
 */
	//echo file_get_contents('/var/www/polaris/engines/beru.ru/cookies/'.EXTRA_PARAM.'.txt');
	//die('/var/www/polaris/engines/beru.ru/cookies/'.EXTRA_PARAM.'.txt');
	$options = array(
     	CURLOPT_COOKIEFILE      => '/var/www/polaris/engines/beru.ru/cookies/'.EXTRA_PARAM.'.txt',
     	CURLOPT_COOKIEJAR      	=> '/var/www/polaris/engines/beru.ru/xxx/cookies_'.EXTRA_PARAM.'.txt',
      CURLOPT_AUTOREFERER     => true,
      CURLOPT_FOLLOWLOCATION  => true,
      CURLOPT_CONNECTTIMEOUT => 20,
      CURLOPT_TIMEOUT        => 20, 
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_SSL_VERIFYHOST => 0   
  );

	$AC->flush_requests();
	$AC->__set('callback','callback_two');

	$qOfPaginationPages = 0;
	//$AC->get('https://market.yandex.ru/search?text=polaris&businessId=892410&page=2&local-offers-first=0?'.$lr, null, $options); // Onlinetrade
	//$AC->get('https://market.yandex.ru/search?fesh=159662&shopId=159662&allow-collapsing=0&text=polaris'.$lr, null, $options); // Техпорт
	//$AC->get('https://market.yandex.ru/search?fesh=1086757&shopId=1086757&allow-collapsing=0&text=polaris'.$lr, null, $options); // Cenam.net
	//$AC->get('https://market.yandex.ru/search?fesh=1076502&shopId=1076502&allow-collapsing=0&text=polaris'.$lr, null, $options); // Элекс
	//$AC->get('https://market.yandex.ru/search?fesh=18543&shopId=18543&allow-collapsing=0&text=polaris'.$lr, null, $options); // Технорадуга
	$AC->get('https://pokupki.market.yandex.ru/supplier/655638?'.$lr, null, $options); // Магазин Polaris
	$seller_page = '1';
	$AC->execute(10);

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

	echo 'Страниц пагинации: '.$qOfPaginationPages.PHP_EOL;

	$is_any = 0;
	for ($i=2; $i <= $qOfPaginationPages; $i++) { 
		if (!in_array('https://pokupki.market.yandex.ru/supplier/655638?page='.$i.$lr, $already_scanned)) {
			echo 'сканирую адрес:'.PHP_EOL.'https://pokupki.market.yandex.ru/supplier/655638?page='.$i.$lr.PHP_EOL;
			$AC->get('https://pokupki.market.yandex.ru/supplier/655638?page='.$i.$lr, null, $options);
			$is_any = 1;
		} else {
			echo 'уже сканировал:'.PHP_EOL.'https://pokupki.market.yandex.ru/supplier/655638?page='.$i.$lr.PHP_EOL;
		}
	}
	if ($is_any) {
		$AC->execute(10);
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

	echo 'Время bad_urls: '.(round(microtime(1) - $time_start, 0)).PHP_EOL;
} 

if (!$itemsArray) {
	die();
}
file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_two($response, $info, $request) {
  global $region;
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regP;
	global $qOfPaginationPages;
	global $itemsArray;
  global $bad_urls;
  global $time_start;
  global $regRegion;
  global $regionName;
  global $lr;
  global $seller_page;

  //file_put_contents('/var/www/polaris/engines/beru.ru/content/'.$region.'.txt', $response);

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {   
  	//if ($info['http_code'] !== 404) {
  		$bad_urls[] = $request->url;
  		echo 'bad_urls time: '.(round(microtime(1) - $time_start, 0));
  		print_r($bad_urls);
  	//} 	

		if (round(microtime(1) - $time_start, 0) >= 300) { 
			echo 'Убиваем bad_urls time: '.(round(microtime(1) - $time_start, 0));
			$bad_urls = array();

		}  	 	         
  } else {
  	$response = str_replace('&quot;', '"', $response);
  	//if (EXTRA_PARAM == 'krasnoyarsk') {
  		//file_put_contents('/var/www/polaris/engines/beru.ru/content/'.EXTRA_PARAM.'.txt', file_get_contents('/var/www/polaris/engines/beru.ru/content/'.EXTRA_PARAM.'.txt').$response);
  	//}
  	
  	if (stripos($response, 'Товары от поставщика Polaris') !== false) {
  		AngryCurl::add_debug_msg('Всё в порядке, надпись есть');
  	} else {
  		AngryCurl::add_debug_msg('Проблема, надписи нет!'); 		
  		/*
  		$bad_urls[] = $request->url;
			if (round(microtime(1) - $time_start, 0) >= 300) { 
				echo 'Убиваем bad_urls time: '.(round(microtime(1) - $time_start, 0));
				$bad_urls = array();
			}  	 	 
  		return;
  		*/
  	}

  	preg_match($regRegion, $response, $mReg);
  	
  	if (!$mReg) {
  		preg_match('~"regionName":"(.+)"~isU', $response, $mReg);
  	}
  	
  	//print_r($mReg);
  	$mReg[1] = trim(@$mReg[1]);
  	@AngryCurl::add_debug_msg($regionName.' - '.$mReg[1]);

  	if (stripos($mReg[1], $regionName) !== false) {
  		preg_match($regP, $response, $mP);
  		//print_r($mP);
  		@$qOfPaginationPages = ceil(trim($mP[1])/24);

  		AngryCurl::add_debug_msg('К-во страниц: '.$qOfPaginationPages);
/*
  		if (!$qOfPaginationPages) { // Если нет к-ва страниц значит нужно пересобрать страницу
  			$bad_urls[] = $request->url;
				if (round(microtime(1) - $time_start, 0) >= 300) { 
					echo 'Убиваем bad_urls time: '.(round(microtime(1) - $time_start, 0));
					$bad_urls = array();
				}
  		}
*/

			if ($qOfPaginationPages < 7) {
				$qOfPaginationPages = 11;
			}

			preg_match_all("~<article(.+)</article>~isU", $response, $matches2, PREG_SET_ORDER);
			//print_r($matches2);
			//file_put_contents('/var/www/polaris/engines/beru.ru/json.txt', print_r($matches2, 1));
			//die();
			$saveme = 0;

			foreach ($matches2 as $key => $value) {	
			//echo $value[0];	
				$value[0] = str_replace('&amp;', '&', $value[0]);
				preg_match("~<a href=\"(.+)\".*<img alt=\"(.+)\".*data-autotest-currency(.+)</span~isU", $value[0], $matches);
				//print_r($matches);

				$matches[1] = 'https://market.yandex.ru'.$matches[1];
				$matches[1] = substr($matches[1], 0, stripos($matches[1], '&show-uid'));
				

				if (stripos($matches[3], 'от') !== false) {
					AngryCurl::add_debug_msg('В цене есть от!!! Обнуляем цену');
					$matches[3] = '0';
					$saveme = 1;
				} else {
					$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
				}
				

				if ($matches[3] && $matches[2]) {
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(
						$matches[2], 
						$matches[3],
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url
					);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
				}
			}

			if ($saveme > 0) {
				file_put_contents('/var/www/polaris/engines/beru.ru/content/'.EXTRA_PARAM.'.txt', $response);
			}

			file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
		} else {
			@AngryCurl::add_debug_msg('не совпадает регион - '.trim($mReg[1]).' : '.$regionName);
			$bad_urls[] = $request->url;
			if (round(microtime(1) - $time_start, 0) >= 300) { $bad_urls = array(); }
			//file_put_contents('/var/www/polaris/engines/beru.ru/content.txt', $response); die();
			//echo substr(strip_tags($response), 0, 500);
		}
  }
}




function callback_two_old($response, $info, $request) {
  global $region;
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regP;
	global $qOfPaginationPages;
	global $itemsArray;
  global $bad_urls;
  global $time_start;
  global $regRegion;
  global $regionName;
  global $lr;
  global $seller_page;

  //file_put_contents('/var/www/polaris/engines/beru.ru/content/'.$region.'.txt', $response);

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {   
  	//if ($info['http_code'] !== 404) {
  		$bad_urls[] = $request->url;
  		echo 'bad_urls time: '.(round(microtime(1) - $time_start, 0));
  		print_r($bad_urls);
  	//} 	

		if (round(microtime(1) - $time_start, 0) >= 300) { 
			echo 'Убиваем bad_urls time: '.(round(microtime(1) - $time_start, 0));
			$bad_urls = array();

		}  	 	         
  } else {
  	//if (EXTRA_PARAM == 'spb') {
  		//file_put_contents('/var/www/polaris/engines/beru.ru/content.txt', $response);
  	//}
  	$response = str_replace('&quot;', '"', $response);
  	
  	preg_match($regRegion, $response, $mReg);
  	
  	if (!$mReg) {
  		preg_match('~"regionName":"(.+)"~isU', $response, $mReg);
  	}
  	
  	//print_r($mReg);
  	$mReg[1] = trim(@$mReg[1]);
  	@AngryCurl::add_debug_msg($regionName.' - '.$mReg[1]);

  	if (stripos($mReg[1], $regionName) !== false) {
  		preg_match($regP, $response, $mP);
  		//print_r($mP);
  		@$qOfPaginationPages = ceil(trim($mP[1])/24);

  		//AngryCurl::add_debug_msg('К-во страниц: '.$qOfPaginationPages);
/*
  		if (!$qOfPaginationPages) { // Если нет к-ва страниц значит нужно пересобрать страницу
  			$bad_urls[] = $request->url;
				if (round(microtime(1) - $time_start, 0) >= 300) { 
					echo 'Убиваем bad_urls time: '.(round(microtime(1) - $time_start, 0));
					$bad_urls = array();
				}
  		}
*/

			if ($qOfPaginationPages < 7) {
				$qOfPaginationPages = 11;
			}

			$variant = 1;
	  	preg_match("~<noscript data-tid=(.+)data-zone-name=\"text\"~isU", $response, $matches);
	  	if (!$matches) {
	  		preg_match("~<noscript data-tid=(.+)meta\":{\"/content/legalInfo~isU", $response, $matches);
	  		echo "Второй вариант ". count($matches).PHP_EOL;
	  		$variant = 2;
	  		//print_r($matches);
	  		//file_put_contents('/var/www/polaris/engines/beru.ru/json.txt', print_r($matches, 1)); //die();
	  		//file_put_contents('/var/www/polaris/engines/beru.ru/content.txt', $response); //die();
	  	}


	  	//preg_match_all('~"marketSku":"(.+)".*"raw":"(.+)".*"slug":"(.+)".*supplierId":(.+),.*"currentPrice":{"value":(.+),.*availableCount":(.+),.*~isU', $matches[1], $mcode, PREG_SET_ORDER);
	  	if ($variant == 1) {
	  		preg_match_all('~"slug":"(.+)".*"marketSku":"(.+)".*"raw":"(.+)".*"currentPrice":{"value":(.+),.*supplierId":(.+),.*"isAvailable":(.+),.*~isU', $matches[1], $mcode, PREG_SET_ORDER);

	  	} else {
	  		preg_match_all('~"slug":"(.+)".*"marketSku":"(.+)".*"raw":"(.+)".*"currentPrice":{"value":(.+),.*supplierId":(.+),.*"isAvailable":(.+),.*~isU', $response, $mcode, PREG_SET_ORDER);
	  	}

	  	if ($seller_page == 1) {
	  		//preg_match_all('~"marketSku":"(.+)".*"raw":"(.+)".*"slug":"(.+)".*supplierId":(.+),.*"currentPrice":{"value":(.+),.*availableCount":(.+),.*~isU', $response, $mcode, PREG_SET_ORDER);
	  		preg_match_all('~"marketSku":"(.+)".*"raw":"(.+)".*"currentPrice":{"value":(.+),.*supplierId":(.+),.*isAvailable":(.+),.*"slug":"(.+)"~isU', $response, $mcode, PREG_SET_ORDER);
  			file_put_contents('/var/www/polaris/engines/beru.ru/json.txt', $response);
  			print_r($mcode);die();
	  	}

			foreach ($mcode as $key => $valuenew) {			
/*id:
431782 - Беру
431782 - Polaris
615118 - Торговый дом БК
596441 - Миксмаркет
610615 - Ноу-Хау - магазин мобильной электроники
655638 Polaris*/
				if ($seller_page == 1) {

					if ($valuenew[5] && $valuenew[1] && $valuenew[2] && $valuenew[6] && $valuenew[3]) {
						if (stripos(trim($valuenew[4]), '572917') !== false || stripos(trim($valuenew[4]), '465852') !== false || stripos(trim($valuenew[4]), '655638') !== false) { // Только если Polaris
		
							$address = 'https://pokupki.market.yandex.ru/product/'.trim($valuenew[6]).'/'.trim($valuenew[1]);
							$name = trim($valuenew[2]);
							$price = trim($valuenew[3]);

							price_change_detect(
								$address, $name, $price, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE
							);
							$itemsArray[$address] = array(
								$name,  $price, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url, $valuenew[4]
							);			
							AngryCurl::add_debug_msg($address.' | '.$name.' | '.$price);
						}
					}


				} else {
					if ($valuenew[6] && $valuenew[2] != 'yandex-market' && $valuenew[3] && $valuenew[1] && $valuenew[4] ) {
						if (stripos(trim($valuenew[5]), '572917') !== false || stripos(trim($valuenew[5]), '465852') !== false || stripos(trim($valuenew[5]), '655638') !== false) { // Только если Polaris
		
							$address = 'https://pokupki.market.yandex.ru/product/'.trim($valuenew[1]).'/'.trim($valuenew[2]);
							$name = trim($valuenew[3]);
							$price = trim($valuenew[4]);

							price_change_detect(
								$address, $name, $price, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE
							);
							$itemsArray[$address] = array(
								$name,  $price, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url, $valuenew[5]
							);			
							AngryCurl::add_debug_msg($address.' | '.$name.' | '.$price);
						}/* else {
							$address = 'https://pokupki.market.yandex.ru/product/'.trim($valuenew[1]).'/'.trim($valuenew[2]);
							$name = trim($valuenew[3]);
							$price = '0';

							price_change_detect(
								$address, $name, $price, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE
							);
							$itemsArray[$address] = array(
								$name,  $price, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url, $valuenew[5]
							);			
							AngryCurl::add_debug_msg($address.' | '.$name.' | '.$price);						
						}*/
					}
				}
			}

			file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
		} else {
			@AngryCurl::add_debug_msg('не совпадает регион - '.trim($mReg[1]).' : '.$regionName);
			$bad_urls[] = $request->url;
			if (round(microtime(1) - $time_start, 0) >= 300) { $bad_urls = array(); }
			//file_put_contents('/var/www/polaris/engines/beru.ru/content.txt', $response); die();
			//echo substr(strip_tags($response), 0, 500);
		}
  }
}


