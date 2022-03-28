<?php
/**
 * 21vek.ru
 */
$options = array(
								CURLOPT_COOKIEJAR       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        				CURLOPT_COOKIEFILE      => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        				//CURLOPT_REFERER       => 'https://elex.ru/',
                CURLOPT_CONNECTTIMEOUT 	=> 45,
                CURLOPT_TIMEOUT        	=> 45,
                CURLOPT_AUTOREFERER     => TRUE,
                CURLOPT_FOLLOWLOCATION  => TRUE,
                CURLOPT_HEADER 					=> true, 
                CURLOPT_SSL_VERIFYPEER 	=> 0	
	); 

$urlStart = 'https://www.21vek.ru/search/?term=polaris&sa=';

$regexpP = "~b-recipes__item__link.*href=\"(.+)\"~isU";

$regexpPrices1 = "~<li class=\"result__item cr-result__simple(.+)</li>~isU";
$regexpPrices2 = "~href=\"(.+)\".*class=\"result__name\">(.+)<.*content=\"(.+)\"~isU";
$regexpPrices3 = "~href=\"(.+)\".*class=\"result__name\">(.+)<~isU";

/**
 * МЕГАЦИКЛ
 */
for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
	if ($iGlobalLoop > 0) {
		$AC->flush_requests();
		$AC->__set('callback','callback_one');
	}	
	// Узнаем, сколько позиций в пагинации
	$AC->get($urlStart, null, $options);
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

	print_r($links);
/*
	$links = array(
		'https://www.21vek.ru/search/?term=polaris&sa=&category_id=41',
		'https://www.21vek.ru/search/?term=polaris&sa=&category_id=51',
		'https://www.21vek.ru/search/?term=polaris&sa=&category_id=49',
		'https://www.21vek.ru/search/?term=polaris&sa=&category_id=35',
		'https://www.21vek.ru/search/?term=polaris&sa=&category_id=38',
		);
*/

	if ($links) {
		//$qOfPaginationPages = 15; // КОСТЫЛЬ
		$AC->flush_requests();
		$AC->__set('callback','callback_two');				
		
		foreach ($links as $url) {
			$AC->get($url, NULL, $options);
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

	}

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));

} // МЕГАЦИКЛ
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP;

	global $regexpPrices1;
	global $regexpPrices2;
	global $itemsArray;
	global $errorsArray;
  global $links;
  global $bad_urls;
  global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {    
 		$bad_urls[] = $info['url']; 
 		if (round(microtime(1) - $time_start, 0) >= 300) { $bad_urls = array(); }       
  } else {
  	//file_put_contents('filename', $response);
		preg_match_all($regexpP, $response, $matches2);
		//print_r($matches2);
		if (!$matches2) {
			$bad_urls[] = $info['url'];
		} else {
			$matches2 = $matches2[1];
			foreach ($matches2 as $value) {
				$links[] = trim($value);
			}

			$links = array_unique($links);
		}
  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
	global $errorsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {
    $bad_urls[] = $info['url'];
		if (round(microtime(1) - $time_start, 0) >= 300) { $bad_urls = array(); }       
  } else {
	  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
	  //print_r($matches);
		foreach ($matches as $key) {
			preg_match($regexpPrices2, $key[1], $matches2);
			//print_r($matches2);
			if (strripos($key[1], 'В корзину') !== false) {
				if ($matches2[1] && $matches2[2]) {
					if (strripos($matches2[3], '.') !== false) {
						$matches2[3] = preg_replace('~[^\d.]+~', '', $matches2[3]);
						$matches2[3] = substr($matches2[3], 0, -3);
					} else {
						$matches2[3] = preg_replace('~[^\d.]+~', '', $matches2[3]);
					}
					
					price_change_detect(trim($matches2[1]), trim($matches2[2]), $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches2[1])] = array(
						trim($matches2[2]), 
						$matches2[3],
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url
					);			
					AngryCurl::add_debug_msg($matches2[2].' | '.preg_replace('~[^\d.]+~', '', $matches2[3]));	
				}
			} else {
				preg_match($regexpPrices3, $key[1], $matches2);
				if ($matches2[1] && $matches2[2]) {
					price_change_detect(trim($matches2[1]), trim($matches2[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches2[1])] = array(
							trim($matches2[2]),
							'0',
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url
						);			
					AngryCurl::add_debug_msg($matches2[2].' | 0');
				}					
			}
		}
  }
}
