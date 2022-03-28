<?php
/**
 * premier-techno.ru
 */


$urlStart = 'https://www.'.ENGINE_CURR.'/search/?q='.ENGINE_TYPE.'&PAGEN_1=';
$regexpP1 = "~class=\"navigation-pages\">(.+)</div>~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexp1  = "~class=\"product\"(.+)<hr />~isU";
$regexp2  = "~href=\"(.+)\".*>(.+)</a~isU";
$regexp3  = "~class=\"pricetools-new_price.*>(.+)<~isU";

/**
 * МЕГАЦИКЛ
 */
for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
	// Соберём ссылки на разделы с карточками и сразу определим пагинацию
	$qOfPagesArray = array(); // Создадим массив и выберем больший элемент (он будет содержать более точные данные)
	$AC->get($urlStart.'1');
	$AC->get($urlStart.'2');
	$AC->get($urlStart.'3');
	$AC->get($urlStart.'4');
	$AC->execute(4);

	$AC->flush_requests();
	$AC->__set('callback','callback_two');

	echo "\n" . 'itemsArray: ' . count($itemsArray) . "\n";

	if ($qOfPaginationPages > 1) {
		for ($i = 5; $i <= $qOfPaginationPages; $i++) {
			$AC->get($urlStart . $i);
			$AC->add_debug_msg( $urlStart . $i ); // Проверим, какие адреса записываются для выполнения    
		}
		$AC->execute(WINDOW_SIZE);

		while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
		  $AC->flush_requests(); // Чистим массив запросов
		  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
		    $AC->get($urls);
		    $AC->add_debug_msg("Bad URLs: $urls"); // LOG ⇒ Можем посмотреть сколько адресов при первом прогоне вернули пустоту        
		  }
		  unset($urls);
		  $bad_urls = array();    // Чистим массив URL-ов для следующего (возможного) цикла    
		  $AC->execute(WINDOW_SIZE);       // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
		}
		unset($urls);

	/**
	 * Callback Three
	 */
		$AC->add_debug_msg('Callback Three');
		$AC->flush_requests();
		$AC->__set('callback','callback_three');

		echo "\n" . 'itemsArray: ' . count($itemsArray) . "\n";

		foreach ($itemsArray as $aurl => $stuff) {
			$AC->get( trim($aurl) );   
		}
		$AC->execute(WINDOW_SIZE);

		echo "\n" . 'itemsArray: ' . count($itemsArray) . "\n";

		while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
		  $AC->flush_requests(); // Чистим массив запросов
		  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
		    $AC->get($urls);
		    $AC->add_debug_msg("Bad URLs: $urls"); // LOG ⇒ Можем посмотреть сколько адресов при первом прогоне вернули пустоту        
		  }
		  unset($urls);

		  $bad_urls = array();    // Чистим массив URL-ов для следующего (возможного) цикла    
		  $AC->execute(WINDOW_SIZE);       // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
		}
		unset($urls);
	}
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
}

/**
 * Формируем CSV файл
 *
 * yekaterinburg
 */
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;
  global $qOfPaginationPages;  
  global $bad_urls;
  global $errorsArray;

  if ($info['http_code'] !== 200) {                

  } else {
		preg_match($regexpP1, $response, $matches);
		//print_r($matches);
		preg_match_all($regexpP2, $matches[1], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			echo "key: " . $key . "\n";
			echo "value:" . $value . "\n";
			if (is_numeric($value)) {
				$temparrpage[] = $value;
			}
		}

		if (@max($temparrpage) > $qOfPaginationPages) {
			$qOfPaginationPages = @max($temparrpage);	    	
		}		
  }
}

function callback_two($response, $info, $request) {
	global $regexp1;
	global $regexp2;
	global $itemsArray;
	global $errorsArray;
	global $bad_urls;
	global $time_start;

  if ($info['http_code'] !== 200) {
  	$bad_urls[] = $request->url; 
    /**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 300) { $bad_urls = array(); }         
  } else {
  	preg_match_all($regexp1, $response, $matches2, PREG_SET_ORDER); //
	  foreach ($matches2 as $key) {  		
			preg_match($regexp2, $key[1], $matches);
			if ($matches[1]) {
				$itemsArray['http://www.'.ENGINE_CURR.substr(trim($matches[1]), 0, strripos($matches[1], '?'))] = array(trim(strip_tags($matches[2])), '0',
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url);
				echo 'http://www.'.ENGINE_CURR.substr(trim($matches[1]), 0, strripos($matches[1], '?')).PHP_EOL;					
			}					  		
		}	
  }
}

function callback_three($response, $info, $request) {
	global $regexp3;
	global $itemsArray;
	global $errorsArray;
	global $bad_urls;
	global $time_start;	

  if ($info['http_code'] !== 200) {
    $bad_urls[] = $request->url;
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 300) { $bad_urls = array(); }         
  } else {
		preg_match($regexp3, $response, $matches);		
		echo "\n" . $info['url'] . ' - ' . $info['http_code'] . "\n";		
		if (@$matches[1]) {
			if (strripos($response, 'Купить в 1 клик') !== false) {
				price_change_detect($request->url, $itemsArray[$request->url][0], trim(preg_replace('~[^\d]+~', '' , $matches[1])), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$request->url][1] = preg_replace('~[^\d]+~', '' , $matches[1]);	
				$itemsArray[$request->url][2] = date("d.m.y-H:i:s");	
				$itemsArray[$request->url][3] = $request->options[10004];	
				$itemsArray[$request->url][4] = $request->options[10018];	
				$itemsArray[$request->url][5] = $request->url;
				echo 'price - ' . preg_replace('~[^\d]+~', '' , $matches[1]) . "\n";		
			}
		}
	}
}
