<?php
/**
 * pleer.ru
 */
$urlStart 		 = 'http://www.pleer.ru/search_' . ENGINE_TYPE . '_page';
$urlEnd				 = '.html';
$regexpP 			 = "~total_found_count.*>(.+)<~isU";
//$regexpP2 		 = "~<a href=\".*_page(.+).html~isU";
$regexpPrices  = "~class=\"section_item(.+)</div></div></div></div></div>~isU";
$regexpPrices2 = "~href=.*href=\"(.+)\".*itemprop=\"name\".*>(.+)<.*itemprop=\"price\">(.+)<~isU";
$regexpPrices3 = "~href=.*href=\"(.+)\".*itemprop=\"name\".*>(.+)<~isU";
$options 			 = array(
								CURLOPT_COOKIEJAR       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        				CURLOPT_COOKIEFILE      => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_AUTOREFERER     => TRUE,
                CURLOPT_FOLLOWLOCATION  => TRUE,
                CURLOPT_HEADER => true, 
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0
	);

	$AC->get($urlStart.'1'.$urlEnd, NULL, $options);
	$AC->execute(4);

	if ($qOfPaginationPages > 1) { 
		for ($i = 2; $i < $qOfPaginationPages; $i++) {
		  $AC->get($urlStart . $i . $urlEnd, null, $options); 
		}
		$AC->execute(WINDOW_SIZE);

		while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
		  $AC->flush_requests(); // Чистим массив запросов
		  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
		    $AC->get($urls, null, $options);     
		  }
		  unset($urls);

		  $bad_urls = array();    // Чистим массив URL-ов для следующего (возможного) цикла    
		  $AC->execute(WINDOW_SIZE);       // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
		}
		
		unset($urls);
	}

	// Сохраним массив в переменную
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP;
  global $regexpP2;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {            
    if ($info['http_code'] !== 404) {
      $bad_urls[] = $request->url;
    }
  } else {
  	file_put_contents('/var/www/polaris/engines/pleer.ru/content.txt', $response);
		preg_match($regexpP, $response, $matches);
		print_r($matches);
		
		
 		$qOfPaginationPages = ceil(preg_replace('~[^\d]+~', '', $matches[1])/17);
		

  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); // Режем все карточки на странице
  	print_r($matches2);
  	foreach ($matches2 as $key) {
			preg_match($regexpPrices2, $key[1], $matches); // Исследуем каждую карточку в отдельности
			print_r($matches);
			if (@$matches[3]) { // Если есть "новый прайс"
				
				price_change_detect('http://www.' . ENGINE_CURR . '/' . trim($matches[1]), trim($matches[2]), $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray['http://www.' . ENGINE_CURR . '/' . trim($matches[1])] = array(trim($matches[2]), $matches[3], date("d.m.y-H:i:s"), $request->options[10004]);
				echo trim($matches[1]) . ': ' . $matches[3] . "\n";								
			} else {
				preg_match($regexpPrices3, $key[1], $matches); // Нет в наличии				
				if ($matches[1]) {
					price_change_detect('http://www.' . ENGINE_CURR . '/' . trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['http://www.' . ENGINE_CURR . '/' . trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->options[10004]);
					echo trim($matches[1]) . " - NULL\n";				
				}
			}
		}
		
  }
}
