<?php
/**
 * ozon.ru
 */


//$options 			 = array(CURLOPT_COOKIE => 'BITRIX_SM_SELECTED_CITY_KLADRCODE=' . $cityid . ';BITRIX_SM_STORE_ID=' . $storeid . ';BITRIX_SM_SELECTED_CITY=' . $region); 					// Подставляем coockie региона
//$regexpPrices   = "~class=\"eOzonPrice_main.*>(.*)<.*<h1 class=\"bItemName\".*>(.+)<~isU";
//$regexpPrices2  = "~<h1 class=\"bItemName\".*>(.+)<~isU";

$regName 	= "~\"prodName\":\"(.+)\",\"~isU";
$regPrice = "~class=\"eOzonPrice_main\">(.+)<~isU";
$regAvail = "~\"itemAvailability\":\"(.+)\"~isU";

$directlinks = file_get_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'directlinks.txt');
$directlinksarray = explode("\n", $directlinks);
/**
 * МЕГАЦИКЛ
 */
for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
	foreach ($directlinksarray as $key => $value) {
	  $AC->get($value);
	  $AC->add_debug_msg( $value ); // Проверим, какие адреса записываются для выполнения    
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
	global $regName;
	global $regPrice;
	global $regAvail;
	global $regexpPrices;
  global $regexpPrices2;
	global $itemsArray;
	global $errorsArray;
	global $bad_urls;
	global $time_start;

  if ($info['http_code'] !== 200 && $info['http_code'] !== 404) {
    if (strripos($info['url'], ENGINE_CURR)) {
      $bad_urls[] = $info['url'];
    }   
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 580) { $bad_urls = array(); }      
  } else {	  
	  if (strripos($info['url'], '?from=prt_xml_facet') === false) {
	  	$info['url'] = $info['url'] . '?from=prt_xml_facet';
	  }
		preg_match($regAvail, $response, $mAvail);
		preg_match($regName, $response, $mName);
		preg_match($regPrice, $response, $mPrice);
		echo $mAvail[1] . "\n";
		echo $mName[1]  . "\n";
		echo $mPrice[1] . "\n";
    
    if ($mPrice[1] && $mName[1]) {
	    if ($mAvail[1] == 'OnStock') {
	    	if (strripos($mPrice[1], '.') !== false) {
	    	  $mPrice[1] = substr($mPrice[1], 0, strripos($mPrice[1], '.'));
	    	}
	    	if (strripos($mPrice[1], ',') !== false) {
	    	  $mPrice[1] = substr($mPrice[1], 0, strripos($mPrice[1], ','));
	    	}	    	
	    	price_change_detect($info['url'], trim(iconv('windows-1251', 'utf-8', $mName[1])), preg_replace('~[\D]+~', '' , $mPrice[1]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$info['url']] = array(trim(iconv('windows-1251', 'utf-8', $mName[1])), preg_replace('~[\D]+~', '' , $mPrice[1]),
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url);
	      echo iconv('windows-1251', 'utf-8', trim($mName[1])) . ' - ' . $mPrice[1] . "\n";
	    } else {
	    	price_change_detect($info['url'], trim(iconv('windows-1251', 'utf-8', $mName[1])), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$info['url']] = array(trim(iconv('windows-1251', 'utf-8', $mName[1])), '0',
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url);
	      echo iconv('windows-1251', 'utf-8', trim($mName[1])) . ' - ' . "0\n";
	    }
    }
  }
}
