<?php
/**
 * nk.ru
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
$urlStart 		 = 'http://nk.ru/im/search/?srch='.ENGINE_TYPE.'&page=';			// Первая часть адреса
$regexpP1			 = "~class=\"list_navbar--pages\"(.+)</div~isU";		// Пагинация
$regexpP2 		 = "~<a.*>(.+)<~isU";								// Пагинация
$regexpPrices  = "~<a href=\"/im/r0/g0/(.+)</label>~isU";
$regexpPrices2 = "~href=\"(.+)\".*<em>(.+)<.*class=\"cost\">.*<b>(.+)<~isU";


/**
 * МЕГАЦИКЛ
 */
for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
	if ($iGlobalLoop > 0) {
		$AC->flush_requests();
		$AC->__set('callback','callback_one');
	}		
	// Узнаем, сколько позиций в пагинации
	$AC->get($urlStart . '6');
	
	$AC->execute(4);	

	// Наименования товара и цены
	$AC->flush_requests();
	$AC->__set('callback','callback_two');	

	if ($qOfPaginationPages > 1) {
		for ($i = 1; $i <= $qOfPaginationPages; $i++) {
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
	global $itemsArray;  
  global $qOfPaginationPages;
  global $bad_urls;
  global $errorsArray;
  global $time_start;

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
  	//print_r($matches2);
  	foreach ($matches2 as $key) {
			preg_match($regexpPrices2, $key[0], $matches);
			print_r($matches);
			$matches = parser_clean($matches, 2, 3);
			if ($matches[2]) {
				price_change_detect('http://' . ENGINE_CURR . trim($matches[1]), iconv('windows-1251', 'utf-8', $matches[2]), $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(iconv('windows-1251', 'utf-8', $matches[2]), $matches[3],
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url);
				echo iconv('windows-1251', 'utf-8', $matches[2]) . "\n";								
			}
		} 


  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
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
			preg_match($regexpPrices2, $key[0], $matches);
			$matches = parser_clean($matches, 2, 3);
			if ($matches[2]) {
				price_change_detect('http://' . ENGINE_CURR . trim($matches[1]), iconv('windows-1251', 'utf-8', $matches[2]), $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(iconv('windows-1251', 'utf-8', $matches[2]), $matches[3],
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url);
				echo iconv('windows-1251', 'utf-8', $matches[2]) . "\n";								
			}
		} 	
  }
}
