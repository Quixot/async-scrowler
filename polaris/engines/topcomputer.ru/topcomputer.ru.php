<?php
/**
 * topcomputer.ru
 */
switch (EXTRA_PARAM) {
 	case 'moscow': 
 		$city = 'Москва';
		$region = '';
 		break;
 	default:
 		die("Unknown region\n");  	 		
}

	$options = array(
       	//CURLOPT_COOKIEFILE      => '/var/www/polaris/engines/beru.ru/cookiessss_'.EXTRA_PARAM.'.txt',
       	CURLOPT_COOKIEJAR      	=> '/var/www/polaris/engines/xxx/cookies_'.EXTRA_PARAM.'.txt',
        CURLOPT_AUTOREFERER     => true,
        CURLOPT_FOLLOWLOCATION  => true,
				CURLOPT_CONNECTTIMEOUT => 20,
				CURLOPT_TIMEOUT        => 20, 
				CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 0   
    );
	//$options 			= array(CURLOPT_COOKIE => 'BITRIX_SM_CITY=' . $region); 	// Подставляем coockie региона

	$url 		= 'http://topcomputer.ru/search/?q=polaris&where=iblock_catalogs&PAGEN_1=';
	
	//$reg_region = "~data-target=\"#change_cur_region\">.*<span>(.+)<~isU";

	$regexpP1 = "~class=\"nav-title\".*".iconv('utf-8', 'windows-1251', 'из ')."(.+)<~isU";

	$regexpPrices = "~class=\"media item\">(.+)<div class=\"media-body\">.*</div>~isU";
	$regexpPricesS2 = "~href=\".*href=\"(.+)\".*>(.+)</a.*class=\"item-price\">(.+)<~isU";
	$regexpPricesS3 = "~href=\".*href=\"(.+)\".*>(.+)<~isU";


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
	
	// Соберём ссылки на разделы с карточками и сразу определим пагинацию
	
	$AC->get('http://topcomputer.ru/search/?q=polaris&where=iblock_catalogs', NULL, $options);
	$AC->get('http://topcomputer.ru/search/?q=polaris&where=iblock_catalogs', NULL, $options);
	$AC->execute(WINDOW_SIZE);


	while ($bad_urls) {
		$AC->flush_requests();
		foreach ($bad_urls as $urls) {
		  $AC->get($urls, NULL, $options);
		}
		unset($urls);
		$bad_urls = array();
		$AC->execute(WINDOW_SIZE);
		unset($urls);
	}

	if ($qOfPaginationPages > 1) {

					for ($i=2; $i <= $qOfPaginationPages; $i++) { 
						if (!in_array($url.$i, $already_scanned)) {
							echo 'сканирую адрес:'.PHP_EOL.$url.$i.PHP_EOL;
							$AC->get($url.$i, NULL, $options);
						} else {
							echo 'уже сканировал:'.PHP_EOL.$url.$i.PHP_EOL;
						}
					}
					$AC->execute(WINDOW_SIZE);

					while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
						  $AC->flush_requests(); // Чистим массив запросов
						  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
						    $AC->get($urls, NULL, $options);
						  }
						  unset($urls);
						  $bad_urls = array();       // Чистим массив URL-ов для следующего (возможного) цикла    
						  $AC->execute(WINDOW_SIZE); // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
						}	
					unset($urls);
					
	}

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';

/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP1;

  global $regexpPrices;
  global $regexpPricesS2;
  global $regexpPricesS3;

  global $qOfPaginationPages;

  global $itemsArray;
  global $time_start;
  //global $region;
	//global $reg_region;
	//global $city;
	//global $site_links;


	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]); 

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 540) $bad_urls=array();
  } else {
  	//file_put_contents('/var/www/polaris/engines/azbuka-techniki.ru/content.txt', $response);


				preg_match($regexpP1, $response, $matches);
				print_r($matches);

				$qOfPaginationPages = ceil($matches[1]/50);

	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  	//print_r($matches2);

	  	foreach ($matches2 as $key) {
	  		if (strripos($key[0], 'item-available') !== false) {
					preg_match($regexpPricesS2, $key[0], $matches);
					//print_r($matches);
					if (stripos($matches[1], '?') !== false) {
						$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
					}
					$matches[1] = 'http://topcomputer.ru'.trim($matches[1]);
					$matches[2] = trim(iconv('windows-1251', 'utf-8', $matches[2]));
		      $matches[2] = trim(strip_tags($matches[2]));
		      $matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
					if ($matches[1] && $matches[2]) {
						price_change_detect(trim($matches[1]), $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(
							$matches[2], 
							preg_replace('~[\D]+~', '' , $matches[3]),
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url
						);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.preg_replace('~[\D]+~', '' , $matches[3]));
					}
	  		} else {
					preg_match($regexpPricesS3, $key[0], $matches);
					if (stripos($matches[1], '?') !== false) {
						$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
					}
					$matches[1] = 'http://topcomputer.ru'.trim($matches[1]);
					$matches[2] = trim(iconv('windows-1251', 'utf-8', $matches[2]));
					$matches[2] = trim(strip_tags($matches[2]));
					if ($matches[1] && $matches[2]) {
						price_change_detect(trim($matches[1]), $matches[2], '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(
							$matches[2], 
							'0',
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url
						);		
						AngryCurl::add_debug_msg($matches[2].' | 0');
					}
	  		}
			}

	}
}
