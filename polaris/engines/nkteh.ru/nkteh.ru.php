<?php
/**
 * nkteh.ru
 */

/*
switch (EXTRA_PARAM) {
  case 'novosibirsk':
  	$region = '10';
  	break;		
 	default:
 		die("Unknown region\n"); 		
}
*/

//$options 			 = array(CURLOPT_COOKIE => 'region=' . $region . ';ItemsOnPage=44'); 		// Подставляем coockie региона
$urlStart 		 = 'http://nkteh.ru/khv/search?query='.ENGINE_TYPE.'&page=';			// Первая часть адреса
$urlStart = 'https://nkteh.ru/khv/search?query=polaris&page=1&items_per_page=all';
$regexpP1			 = "~class=\"paginator-wrap(.+)</div~isU";		// Пагинация
$regexpP2 		 = "~<a.*>(.+)<~isU";								// Пагинация
$regexpPrices  = "~class=\"item-card(.+)window-dialog__body~isU";
$regexpPrices2 = "~price__discounted\">(.+)<.*item-card__area_title.*href=\"(.+)\".*>(.+)<~isU";
$regexpPrices3 = "~price__fix\">(.+)<.*item-card__area_title.*href=\"(.+)\".*>(.+)<~isU";

$options 			 = array(
								//CURLOPT_COOKIE => $region,
								CURLOPT_COOKIEJAR       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        				CURLOPT_COOKIEFILE      => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT        => 20,
                CURLOPT_AUTOREFERER     => TRUE,
                CURLOPT_FOLLOWLOCATION  => TRUE,
                CURLOPT_HEADER => true, 
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0
	);

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
	$AC->get('https://nkteh.ru/khv/search/index/catalog_id/0?brand608932=on&query=polaris&was_used=0', null, $options);
	$AC->get('https://nkteh.ru/khv/search/index/catalog_id/0?brand608932=on&query=polaris&catalog_id=&items_per_page=&order_id=&was_used=0&skip=18', null, $options);
	$AC->get('https://nkteh.ru/khv/search/index/catalog_id/0?brand608932=on&query=polaris&catalog_id=&items_per_page=&order_id=&was_used=0&skip=36', null, $options);
	$AC->get('https://nkteh.ru/khv/search/index/catalog_id/0?brand608932=on&query=polaris&catalog_id=&items_per_page=&order_id=&was_used=0&skip=54', null, $options);
	$AC->get('https://nkteh.ru/khv/search/index/catalog_id/0?brand608932=on&query=polaris&catalog_id=&items_per_page=&order_id=&was_used=0&skip=72', null, $options);
	$AC->get('https://nkteh.ru/khv/search/index/catalog_id/0?brand608932=on&query=polaris&catalog_id=&items_per_page=&order_id=&was_used=0&skip=90', null, $options);
	$AC->get('https://nkteh.ru/khv/search/index/catalog_id/0?brand608932=on&query=polaris&catalog_id=&items_per_page=&order_id=&was_used=0&skip=108', null, $options);
	$AC->get('https://nkteh.ru/khv/search/index/catalog_id/0?brand608932=on&query=polaris&catalog_id=&items_per_page=&order_id=&was_used=0&skip=126', null, $options);
	$AC->get('https://nkteh.ru/khv/search/index/catalog_id/0?brand608932=on&query=polaris&catalog_id=&items_per_page=&order_id=&was_used=0&skip=144', null, $options);
	$AC->get('https://nkteh.ru/khv/search/index/catalog_id/0?brand608932=on&query=polaris&catalog_id=&items_per_page=&order_id=&was_used=0&skip=162', null, $options);
	$AC->get('https://nkteh.ru/khv/search/index/catalog_id/0?brand608932=on&query=polaris&catalog_id=&items_per_page=&order_id=&was_used=0&skip=180', null, $options);
	//$AC->get('https://nkteh.ru/khv/search/index/catalog_id/0?brand608932=on&query=polaris&catalog_id=&items_per_page=&order_id=&was_used=0&skip=198', null, $options);
	//$AC->get('https://nkteh.ru/khv/search/index/catalog_id/0?brand608932=on&query=polaris&catalog_id=&items_per_page=&order_id=&was_used=0&skip=216', null, $options);
	$AC->execute(13);	

	// Наименования товара и цены
	$AC->flush_requests();
	$AC->__set('callback','callback_two');	

	if ($qOfPaginationPages > 1) {
		for ($i = 0; $i < $qOfPaginationPages; $i++) {
		  $AC->get($urlStart.$i);
		}
		$AC->execute(WINDOW_SIZE);

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

	// Сохраним массив в переменную
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
} // МЕГАЦИКЛ
/**
 * Формируем CSV файл
 */
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;  
  global $qOfPaginationPages;
  global $bad_urls;
  global $errorsArray;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {            
    //if (stripos($info['url'], ENGINE_CURR)) {
    //  $bad_urls[] = $info['url'];
    //}
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

  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER);
  	foreach ($matches2 as $key) {
			preg_match($regexpPrices2, $key[1], $matches);
			if ($matches) {

				$matches[2] = 'http://' . ENGINE_CURR . trim($matches[2]);
				$matches[3] = trim($matches[3]);
				$matches[1] = preg_replace('~[^\d]+~', '', $matches[1]);

				if ($matches[2]) {
					price_change_detect($matches[2], $matches[3], $matches[1], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[2]] = array($matches[3], $matches[1],
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url);
					AngryCurl::add_debug_msg($matches[2].' | '.$matches[3].' | '.$matches[1]);								
				}
			} else {
				preg_match($regexpPrices3, $key[1], $matches);

				$matches[2] = 'http://' . ENGINE_CURR . trim($matches[2]);
				$matches[3] = trim($matches[3]);
				$matches[1] = preg_replace('~[^\d]+~', '', $matches[1]);

				
				if ($matches[2]) {
					price_change_detect($matches[2], $matches[3], $matches[1], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[2]] = array($matches[3], $matches[1],
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url);
					AngryCurl::add_debug_msg($matches[2].' | '.$matches[3].' | '.$matches[1]);								
				}				
			}

		} 


  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {
    if (stripos($info['url'], ENGINE_CURR)) {
      $bad_urls[] = $info['url'];
    }   
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 1800) { $bad_urls = array(); }    
  } else {
  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER);
  	foreach ($matches2 as $key) {
			preg_match($regexpPrices2, $key[1], $matches);
			if ($matches) {

				$matches[2] = 'http://' . ENGINE_CURR . trim($matches[2]);
				$matches[3] = trim($matches[3]);
				$matches[1] = preg_replace('~[^\d]+~', '', $matches[1]);

				if ($matches[2]) {
					price_change_detect($matches[2], $matches[3], $matches[1], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[2]] = array($matches[3], $matches[1],
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url);
					AngryCurl::add_debug_msg($matches[2].' | '.$matches[3].' | '.$matches[1]);								
				}
			} else {
				preg_match($regexpPrices3, $key[1], $matches);

				$matches[2] = 'http://' . ENGINE_CURR . trim($matches[2]);
				$matches[3] = trim($matches[3]);
				$matches[1] = preg_replace('~[^\d]+~', '', $matches[1]);

				
				if ($matches[2]) {
					price_change_detect($matches[2], $matches[3], $matches[1], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[2]] = array($matches[3], $matches[1],
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url);
					AngryCurl::add_debug_msg($matches[2].' | '.$matches[3].' | '.$matches[1]);								
				}				
			}

		} 	
  }
}
