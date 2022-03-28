<?php
/**
 * technohit.ru
 */
switch (EXTRA_PARAM) {
	case 'moscow': $city = 'Москва и Московская обл.';  $domain = ''; break; // Москва
	case 'spb': 	 $city = 'Санкт-Петербург и область'; $domain = 'spb.'; break; // Санкт-Петербург
  default:
    die("Unknown region\n");    
}

	$options = array(
       	//CURLOPT_COOKIEFILE      => '/var/www/polaris/engines/beru.ru/cookiessss_'.EXTRA_PARAM.'.txt',
       	CURLOPT_COOKIEJAR      	=> '/var/www/polaris/engines/xxx/cookies_'.EXTRA_PARAM.'.txt',
        CURLOPT_AUTOREFERER     => true,
        CURLOPT_FOLLOWLOCATION  => true,
				CURLOPT_CONNECTTIMEOUT => 60,
				CURLOPT_TIMEOUT        => 60, 
				CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 0   
    );

	//$options 			= array(CURLOPT_COOKIE => '_space=' . $region); 	// Подставляем coockie региона
	$urlStart 		= 'https://'.$domain.'technohit.ru/search/page/';				// Первая часть адреса
	$urlEnd				= '/?FIND=polaris&ARTICUL=N';							 				// Вторая часть адреа и поисковая строка
	$regexpLinks = "~category-content__title.*href=\"(.+)\"~isU";
	$regexpP1	= "~id=\"pager\"(.*)</div>~isU";
	$regexpP2 = "~<a.*>(.+)<~isU";
	$regexpPrices = "~class=\"product\"(.+)</form>~isU";
	$regexpPricesS2 ="~href=\"(.+)\".*>(.+)</a>.*class=\"price\">(.+)<span>~isU";
	$regexpPricesS3 ="~href=\"(.+)\".*>(.+)</a>~isU";


	if (EXTRA_PARAM == 'spb') {

		$regexpP1	= "~id=\"pager\"(.*)</div>~isU";
		$regexpP2 = "~<a.*>(.+)<~isU";
		$regexpPrices = "~class=\"product\"(.+)</form>~isU";
		$regexpPricesS2 ="~class=\"name\".*href=\"(.+)\".*>(.+)</a>.*class=\"price\">(.+)</span>~isU";
		$regexpPricesS3 ="~class=\"name\".*href=\"(.+)\".*>(.+)</a~isU";
	}


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
	$already_scanned = array();
	
	// Соберём ссылки на разделы с карточками и сразу определим пагинацию
	
	if (EXTRA_PARAM == 'spb') {
		$AC->flush_requests();
		$AC->__set('callback','callback_two');	
		$AC->get('https://spb.technohit.ru/search/?FIND=polaris', NULL, $options);
		//$AC->get('https://spb.technohit.ru/search/page/2/?FIND=polaris&ARTICUL=N', NULL, $options);
	} else {
		$AC->get($urlStart.'1'.$urlEnd, NULL, $options);
		//$AC->get($urlStart.'2'.$urlEnd, NULL, $options);
		//$AC->get($urlStart.'3'.$urlEnd, NULL, $options);
		//$AC->get($urlStart.'4'.$urlEnd, NULL, $options);
	}
	$AC->execute(4);

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

	if (1 == 2) {//$qOfPaginationPages > 3
		for ($i=3; $i <= $qOfPaginationPages; $i++) { 
			if (!in_array($urlStart.$i.$urlEnd, $already_scanned)) {
				echo 'сканирую адрес:'.PHP_EOL.$urlStart.$i.$urlEnd.PHP_EOL;
				$AC->get($urlStart.$i.$urlEnd, NULL, $options);
			} else {
				echo 'уже сканировал:'.PHP_EOL.$urlStart.$i.$urlEnd.PHP_EOL;
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
	global $regexpP2;
	global $regexpLinks;
	global $directLinks;
	global $regexpPrices;
	global $regexpPricesS2;
	global $regexpPricesS3;
	global $itemsArray;
	global $qOfPaginationPages;
	global $city;
	global $time_start;
	global $bad_urls;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]); 

  if ($info['http_code'] !== 200) {            
    // (stripos($info['url'], ENGINE_CURR)) {
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 540) $bad_urls=array();
    //}
  } else {
  	$response = str_replace('<!------------------------------------------->', '', $response);
  	file_put_contents('/var/www/polaris/engines/technohit.ru/content.txt', $response);


		preg_match("~itemprop=\"addressLocality\">(.+)<~isU", $response, $region);
		$region[1] = trim(iconv('windows-1251', 'utf-8', $region[1]));
		echo 'request  region: '.$city.PHP_EOL;
		echo 'response region: '.$region[1].PHP_EOL;	
	

		if (trim($region[1]) == $city) {

				preg_match($regexpP1, $response, $matches);
				//print_r($matches);
				preg_match_all($regexpP2, $matches[1], $matches2);
				//print_r($matches2);
				$temparrpage = array();
				foreach ($matches2[1] as $key => $value) {
					//echo "key: " . $key . "\n";
					echo "value:" . $value . "\n";
					if (is_numeric($value)) {
						$temparrpage[] = $value;
					}
				}

				if (@max($temparrpage) > $qOfPaginationPages) {
					$qOfPaginationPages = @max($temparrpage);	    	
				}

	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
//print_r($matches2);
	  	foreach ($matches2 as $key) {
	  		if (stripos($key[1], 'class="available-y"') !== false) {
					preg_match($regexpPricesS2, $key[1], $matches);
					//print_r($matches);
		      $matches[2] = trim(iconv('windows-1251', 'utf-8', $matches[2]));
					if ($matches[1] && $matches[2]) {
						price_change_detect(trim($matches[1]), $matches[2], preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(
							$matches[2], 
							preg_replace('~[\D]+~', '' , $matches[3]),
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url
						);
						AngryCurl::add_debug_msg($matches[2].' | '.preg_replace('~[\D]+~', '' , $matches[3]));
					}
	  		} else {
					preg_match($regexpPricesS3, $key[1], $matches);
		      $matches[2] = trim(iconv('windows-1251', 'utf-8', $matches[2]));
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
}


function callback_two($response, $info, $request) {
	global $regexpP1;
	global $regexpP2;
	global $regexpLinks;
	global $directLinks;
	global $regexpPrices;
	global $regexpPricesS2;
	global $regexpPricesS3;
	global $itemsArray;
	global $qOfPaginationPages;
	global $city;
	global $time_start;
	global $bad_urls;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]); 

  if ($info['http_code'] !== 200) {            
    // (stripos($info['url'], ENGINE_CURR)) {
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 540) $bad_urls=array();
    //}
  } else {
  	file_put_contents('/var/www/polaris/engines/technohit.ru/content.txt', $response);

		preg_match("~itemprop=\"addressLocality\">(.+)<~isU", $response, $region);
		$region[1] = trim(iconv('windows-1251', 'utf-8', $region[1]));
		echo 'request  region: '.$city.PHP_EOL;
		echo 'response region: '.$region[1].PHP_EOL;

		if (trim($region[1]) == $city) {
				preg_match($regexpP1, $response, $matches);
				//print_r($matches);
				preg_match_all($regexpP2, $matches[1], $matches2);
				//print_r($matches2);
				$temparrpage = array();
				foreach ($matches2[1] as $key => $value) {
					//echo "key: " . $key . "\n";
					echo "value:" . $value . "\n";
					if (is_numeric($value)) {
						$temparrpage[] = $value;
					}
				}

				if (@max($temparrpage) > $qOfPaginationPages) {
					$qOfPaginationPages = @max($temparrpage);	    	
				}
				$qOfPaginationPages = 10;

	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
//print_r($matches2);die();
	  	foreach ($matches2 as $key) {
	  		preg_match($regexpPricesS2, $key[0], $matches);
//print_r($matches);
	  		$matches[1] = trim($matches[1]);
	  		$matches[2] = trim(iconv('windows-1251', 'utf-8', $matches[2]));
	  		$matches[3] = substr($matches[3], 0, stripos($matches[3], '.'));
	  		$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
	  		
	  		if ($matches[1]) {
		    
					if (strripos($key[0], 'available-y') !== false) {

						price_change_detect(trim($matches[1]), $matches[2], preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(
							$matches[2], 
							preg_replace('~[\D]+~', '' , $matches[3]),
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url
						);
						AngryCurl::add_debug_msg($matches[2].' | '.$matches[3]);
					}
	  		}
			}
		}	
	}
}
