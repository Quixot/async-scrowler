<?php
/**
 * top-shop.ru
 */
$urlStart 		 = 'http://www.top-shop.ru/brand/9-polaris/';  // Первая часть адреса
$urlEnd				 = '';
$regexpP	 = "~class=\"pagination\"(.+)</ul>~isU";
$regexpP2  = "~<a.*>(.+)<~isU";
$regexpPrices1 = "~class=\"col-md-2 col-sm-5(.+)end start minicard-->~isU";				 // Все карточки на странице
$regexpPrices2 = "~itemprop=\"name.*href=\"(.+)\".*>(.+)<.*itemprop=\"price\".*class=\"mc_price_value\".*>(.+)<~isU"; // Карточки товара
$regexpPrices3 = "~itemprop=\"name.*href=\"(.+)\".*>(.+)<.*itemprop=\"price\".*class=\"mc_from_price\".*/span.*>(.+)<~isU";

/**
 * МЕГАЦИКЛ
 */
for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
	if ($iGlobalLoop > 0) {
		$AC->flush_requests();
		$AC->__set('callback','callback_one');
	}	
	// Узнаем, сколько позиций в пагинации
	$AC->get($urlStart);
	$AC->get($urlStart);
	$AC->execute(2);

	if ($qOfPaginationPages > 1) {
		$AC->flush_requests();
		$AC->__set('callback','callback_two');	
		for ($i = 1; $i <= $qOfPaginationPages; $i++) {
		  $AC->get($urlStart.'?page='.$i.'#paging_1_js');
		}
		$AC->execute(WINDOW_SIZE);

		while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
		  $AC->flush_requests(); // Чистим массив запросов
		  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
		    $AC->get($urls, NULL, $options);
		    $AC->add_debug_msg("Bad URLs: $urls"); // LOG ⇒ Можем посмотреть сколько адресов при первом прогоне вернули пустоту        
		  }
		  unset($urls);

		  $bad_urls = array();    // Чистим массив URL-ов для следующего (возможного) цикла    
		  $AC->execute(WINDOW_SIZE);       // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
		}
		
		unset($urls);
	}
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
  global $regexpP;
  global $regexpP2;
	global $regexpPrices1;
	global $regexpPrices2;  
	global $regexpPrices3;
	global $itemsArray;	
  global $qOfPaginationPages;
  global $bad_urls;
  global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->info;
  } else {
		preg_match($regexpP, $response, $matches);
		//print_r($matches);
		preg_match_all($regexpP2, $matches[0], $matches2);
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

	  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
		foreach ($matches as $key) {
			preg_match($regexpPrices2, $key[1], $matches2);
			//print_r($matches2);
			if (!preg_replace('~[\D]+~', '' , $matches2[3])) {
				preg_match($regexpPrices3, $key[1], $matches2);
				//print_r($matches2);
			}
			$matches2 = parser_clean($matches2, 2, 3);
			if ($matches2[1]) {											
				$itemsArray['http://' . ENGINE_CURR . trim($matches2[1])] = array(trim($matches2[2]), preg_replace('~[\D]+~', '' , $matches2[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
				AngryCurl::add_debug_msg($matches2[2].' | '.preg_replace('~[\D]+~', '' , $matches2[3]));					
			}
		}

  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices1;
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
		if (round(microtime(1) - $time_start, 0) >= 1200) { $bad_urls = array(); }       
  } else {
	  	preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
			foreach ($matches as $key) {
				preg_match($regexpPrices2, $key[1], $matches2);
				if (!preg_replace('~[\D]+~', '' , $matches2[3])) {
					preg_match($regexpPrices3, $key[1], $matches2);
					//print_r($matches2);
				}
				$matches2 = parser_clean($matches2, 2, 3);
				if ($matches2[1]) {											
					$itemsArray['http://' . ENGINE_CURR . trim($matches2[1])] = array(trim($matches2[2]), preg_replace('~[\D]+~', '' , $matches2[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
					echo $matches2[2] . "\n";
					AngryCurl::add_debug_msg($matches2[2].' | '.preg_replace('~[\D]+~', '' , $matches2[3]));					
				}
			}
		 		
  }
}
