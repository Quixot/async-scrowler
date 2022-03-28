<?php
/**
 * unixmart.ru
 */
  $regexpP1 = "~class=\"pager\"(.+)</div>~isU";
  $regexpP2 = "~<a.*>(.+)<~isU";
	$regexpPrices = "~<article(.+)</article>~isU";
	$regexpPricesS2 = "~href=\"(.+)\".*<h3>(.+)<.*descr-price\">(.+)<~isU";
	$regexpPricesS3 = "~href=\"(.+)\".*<h3>(.+)<~isU";

	$options 			 = array(
								CURLOPT_COOKIEFILE       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
                CURLOPT_CONNECTTIMEOUT => 90,
                CURLOPT_TIMEOUT        => 90,
                CURLOPT_AUTOREFERER     => TRUE,
                CURLOPT_FOLLOWLOCATION  => TRUE,
                CURLOPT_HEADER => true, 
                CURLOPT_SSL_VERIFYPEER => 0	
	);

	// Загрузка отсканированных ссылок:
	foreach ($itemsArray as $key => $value) {
		$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
		//echo (time() - $date->format('U')).PHP_EOL; 
		if (time() - $date->format('U') <= 3800) {
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

	$AC->get('https://www.unixmart.ru/search?search_query=polaris&page=1', null, $options);
	$AC->execute(WINDOW_SIZE);	

	while ($bad_urls) {
	  $AC->flush_requests();
	  foreach ($bad_urls as $urls) {
	    $AC->get($urls);
	  }
	  unset($urls);
	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}
	unset($urls);


	if ($qOfPaginationPages > 1) {
		for ($i = 2; $i <= $qOfPaginationPages; $i++) {
			$is_any = 0;
			$urls = 'https://www.unixmart.ru/search?search_query=polaris&page='.$i;
			if (!in_array($urls, $already_scanned)) {
				echo 'сканирую адрес:'.PHP_EOL.$urls.PHP_EOL;
				$AC->get($urls, null, $options);
				$is_any = 1;
			} else {
				echo 'уже сканировал:'.PHP_EOL.$urls.PHP_EOL;
			}
		}
		if ($is_any) {
			$AC->execute(WINDOW_SIZE);
		}

		while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
		  $AC->flush_requests(); // Чистим массив запросов
		  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
		    $AC->get($urls);
		  }
		  unset($urls);
		  $bad_urls = array();    // Чистим массив URL-ов для следующего (возможного) цикла    
		  $AC->execute(WINDOW_SIZE);       // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
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
	global $regexpPrices;
	global $regexpPricesS2;
	global $regexpPricesS3;
	global $itemsArray;  
  global $qOfPaginationPages;
  global $bad_urls;
  global $errorsArray;
  global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {            
    if (stripos($info['url'], ENGINE_CURR)) {
      $bad_urls[] = $info['url'];
    }
    if (round(microtime(1) - $time_start, 0) >= 1800) { $bad_urls = array(); }
  } else {
		preg_match($regexpP1, $response, $matches);
		//print_r($matches);
		preg_match_all($regexpP2, $matches[1], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			//echo "key: " . $key . "\n";
			//echo "value:" . $value . "\n";
			if (is_numeric($value)) {
				$temparrpage[] = $value;
			}
		}

		if (@max($temparrpage) > $qOfPaginationPages) {
			//echo "Страницы: " . $temparrpage . "\n";
			$qOfPaginationPages = @max($temparrpage);	    	
		}	

		preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //

	  foreach ($matches2 as $key) {
	  		if (strripos($key[1], 'Купить') !== false) {
					preg_match($regexpPricesS2, $key[1], $matches);
					//print_r($matches);
					$matches[1] = 'https://www.unixmart.ru'.trim($matches[1]);
		      $matches[2] = strip_tags(trim($matches[2]));
		      $matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
					if ($matches[1] && $matches[2]) {
						price_change_detect(trim($matches[1]), $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
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
	  		} else {
					preg_match($regexpPricesS3, $key[1], $matches);
					$matches[1] = 'https://www.unixmart.ru'.trim($matches[1]);
		      $matches[2] = strip_tags(trim($matches[2]));
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
