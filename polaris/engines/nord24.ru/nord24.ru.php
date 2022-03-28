<?php
/**
 * nord24.ru
 */
switch (EXTRA_PARAM) {
 	case 'krasnoturinsk': $city = 'a63e23442ff9b1b6c4cf2db5a65b9856';	break;
 	case 'kurgan': $city = '901773e85aaf4216021c892e116d0590';	break;
 	case 'lyantor': $city = '2a5a9519b324df8a930bd160c53d7f80';	break;
 	case 'magnitogorsk': $city = '24f4713403256626d2ee411c5c57804d';	break;
 	case 'miass': $city = 'e981f6de8e102c0880d136f276a91673';	break;
 	case 'nizhnij-tagil': $city = 'de97c06f913fccefdfd2a56b14ef64fc';	break;
 	case 'oktyabrskij': $city = '7255bd485df43f84def8ca04e88f52d1';	break;
 	case 'pervouralsk': $city = '800a13b4e0668ff0212792f13f490151';	break;
 	case 'revda': $city = '73387681bc904ed7dd0b95f50359724a';	break;
 	case 'surgut': $city = '91164d222057e3ef2841d0ed0f408c0a';	break;
 	case 'tyumen': $city = '08f4d1f6b599c3e04c055f13c8032002';	break;
 	case 'yekaterinburg': $city = 'a4eb7bd26e0e5a3a35431f1e890429b0';	break;
 	case 'chelyabinsk': $city = 'f064e8e0876d2d924010a93e90aa4926'; break;
 	default: die("Unknown region\n");   		
}

$options 			 = array(
	CURLOPT_COOKIE => 'city=' . $city,
	CURLOPT_CONNECTTIMEOUT => 20,
	CURLOPT_TIMEOUT        => 240,
	CURLOPT_AUTOREFERER     => TRUE,
	CURLOPT_FOLLOWLOCATION  => TRUE,
	CURLOPT_HEADER => true, 
	CURLOPT_SSL_VERIFYPEER => 0	

);
$urlStart 		 = 'https://www.nord24.ru/search-new?q=' . ENGINE_TYPE . '&page=';	// Адрес
$regexpAllP		 = "~<span class=\"sres_show\">(.+)<~isU";
$regexpPrices  = "~<div class=\"itempr item(.+)class=\"compare~isU";   // Все товары на странице
$regexpPrices2 = "~<a.*href=\"(.+)\".*<span class=\"price.*>(.+)<.*<div class=\"name.*>(.+)<~isU"; 			// Режем карточки товара

/**
 * МЕГАЦИКЛ
 */
for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
	if ($iGlobalLoop > 0) {
		$AC->flush_requests();
		$AC->__set('callback','callback_one');
	}		
	// Узнаем, сколько позиций в пагинации
	$AC->get($urlStart . '1', NULL, $options);
	$AC->get($urlStart . '1', NULL, $options);
	//$AC->get($urlStart . '3', NULL, $options);
	$AC->execute(WINDOW_SIZE);	

	// Наименования товара и цены
	$AC->flush_requests();
	$AC->__set('callback','callback_two');	

	echo 'Количество страниц: ' . ceil($qOfPaginationPages/20) . "\n";


	for ($i = 1; $i <= ceil($qOfPaginationPages/20); $i++) {
	  $AC->get($urlStart . $i, NULL, $options); 
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
  global $regexpAllP;  
  global $qOfPaginationPages;
  global $bad_urls;
  global $errorsArray;
  global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {            
    //if (stripos($info['url'], ENGINE_CURR)) {
   	$bad_urls[] = $request->url;
    //}
  } else {
  	echo 
		preg_match($regexpAllP, $response, $matches);
		print_r($matches);
		$temp = preg_replace('~[\D]+~', '' , $matches[1]);
		if ($qOfPaginationPages < $temp) {
			$qOfPaginationPages = $temp;
		}
  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $matches;
	global $itemsArray;
	global $errorsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {
    //if (strripos($info['url'], ENGINE_CURR) && strripos($info['url'], 'old_browser_not_support') === false) {
      $bad_urls[] = $request->url;
    //}   
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 1800) { $bad_urls = array(); }      
  } else {
    if (stripos($info['url'], ENGINE_CURR) !== false && $response && strripos($response, '</html') === false) {       
      $bad_urls[] = $info['url'];    
    } else {
  	//preg_match($regexpRegion, $response, $mregion);
  	//if (trim($mregion[1]) == $regionRu) {  // Проверка региона  	
  		//echo 'Регион сработал' . "\n";
	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); // 	

	  	foreach ($matches2 as $key) {
				preg_match($regexpPrices2, $key[1], $matches);
				if (@$matches[1]) {
					//if (strripos($key[1], 'button-orange') !== false) { // Тут дополнительно нужно проверять наличие. Если кнопка оранжевая, сканируем		
					price_change_detect('http://www.nord24.ru/'.trim($matches[1]), trim($matches[3]), preg_replace('~[\D]+~', '' , $matches[2]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['http://www.nord24.ru/'.trim($matches[1])] = array(trim($matches[3]), preg_replace('~[\D]+~', '' , $matches[2]),
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url);
					echo trim($matches[1]) . "\n";
				}					
				//}
			} 
		//}	/*elseif (trim($mregion[1]) != $regionRu && sizeof($mregion[1]) > 0) {
  		//$bad_urls[] = $info['url'];
  	//}	*/
  	}
  }
}
