	<?php
/**
 * technopoint.ru
 */
defined('_JEXEC') or die('Silentium videtur confessio');

switch (EXTRA_PARAM) {
  case 'moscow': 				$zone = 'Москва'; 					$PHPSESSID = '79'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 moscow
  case 'spb': 					$zone = 'Санкт-Петербург'; 	$PHPSESSID = '282';break; //  sudo screen php app.php technopoint.ru vitek 2 10 spb
  case 'rostov': 				$zone = 'Ростов-на-Дону'; 	$PHPSESSID = '35'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 rostov
  case 'novosibirsk': 	$zone = 'Новосибирск'; 			$PHPSESSID = '20'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 novosibirsk
 	case 'yekaterinburg': $zone = 'Екатеринбург'; 		$PHPSESSID = '31'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 yekaterinburg
 	case 'chelyabinsk': 	$zone = 'Челябинск'; 				$PHPSESSID = '36'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 chelyabinsk
 	case 'volgograd': 		$zone = 'Волгоград'; 				$PHPSESSID = '47'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 volgograd
 	case 'perm': 					$zone = 'Пермь'; 						$PHPSESSID = '42'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 perm
 	case 'kazan': 				$zone = 'Казань'; 					$PHPSESSID = '43'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 kazan
 	case 'novgorod': 			$zone = 'Нижний Новгород'; 	$PHPSESSID = '44'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 novgorod
 	case 'omsk': 					$zone = 'Омск'; 						$PHPSESSID = '30'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 omsk
 	case 'samara': 				$zone = 'Самара'; 					$PHPSESSID = '39'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 samara
 	case 'ufa': 					$zone = 'Уфа'; 							$PHPSESSID = '41'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 ufa
 	case 'krasnoyarsk': 	$zone = 'Красноярск'; 			$PHPSESSID = '18'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 krasnoyarsk
 	case 'krasnodar': 		$zone = 'Краснодар'; 				$PHPSESSID = '38'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 krasnodar
 	case 'voronezh': 			$zone = 'Воронеж'; 					$PHPSESSID = '63'; break; //  sudo screen php app.php technopoint.ru vitek 2 10 voronezh
 	case 'vladivostok': 	$zone = 'Владивосток'; 			$PHPSESSID = '1';  break; //  sudo screen php app.php technopoint.ru vitek 2 10 vladivostok
 	default:
 		die("Unknown region\n"); 		
}
$options 			 = array(CURLOPT_COOKIE => '__CITY__=' . $PHPSESSID); 				// Подставляем coockie региона
//$options 			 = array(CURLOPT_COOKIE => 'tp_session=' . $PHPSESSID); 				// Подставляем coockie региона
$urlStart 		 = 'http://technopoint.ru/search?SphinxForm%5Bquery%5D=' . ENGINE_TYPE . '&page=';		// Первая часть адреса
$urlStart 		 = 'http://technopoint.ru/search?q=' . ENGINE_TYPE . '&page=';		// Первая часть адреса
//$regexpP 			 = "~<ul class=\"pager\">(.+)</ul>~isU";	// Пагинация
//$regexpP2 		 = "~<li><a href=\".*>(.+)</a>~isU";			// Пагинация
$regexpPrices 	= "~<tr class=\"product.*\"(.+)</tr>~isU";
$regexpPrices2 	= "~class=\"info\".*<a.*href=\"(.+)\".*>(.+)<.*<span class=\"price-ru nowrap\">(.+)</~isU";
$regexpZone = "~<a href=\"#\" class=\"city\" data-role=\"choose-city\".*>(.+)<~isU";
$directLinks = explode("\n", file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/links.txt'));

/**
 * МЕГАЦИКЛ
 */
for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
	if ($iGlobalLoop > 0) {
		$AC->flush_requests();
		$AC->__set('callback','callback_one');
	}		
	$qOfPaginationPages = 4; // Костыль

	for ($i = 1; $i <= $qOfPaginationPages; $i++) {
	  $AC->get($urlStart . $i, NULL, $options);
	  //$AC->get($urlStart . $i, NULL, $options);
	  $AC->add_debug_msg( $urlStart . $i ); // Проверим, какие адреса записываются для выполнения    
	}

	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
	  $AC->flush_requests(); // Чистим массив запросов
	  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
	    $AC->get($urls, NULL, $options);
	    //$AC->get($urls, NULL, $options);
	    $AC->add_debug_msg("Bad URLs: $urls"); // LOG ⇒ Можем посмотреть сколько адресов при первом прогоне вернули пустоту        
	  }
	  unset($urls);
	  $bad_urls = array();    // Чистим массив URL-ов для следующего (возможного) цикла    
	  $AC->execute(WINDOW_SIZE);       // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
	}
	unset($urls);

	$AC->flush_requests();
	$AC->__set('callback','callback_two');	

	for ($i = 0; $i < count($directLinks); $i++) {
	  $AC->get($directLinks[$i], null, $options);
	  $AC->add_debug_msg( $directLinks[$i] ); // Проверим, какие адреса записываются для выполнения    
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

	// Сохраним массив в переменную
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
} // МЕГАЦИКЛ

/**
 * Формируем CSV файл
 */
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';

/** 
 * Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $itemsArray;
	global $bad_urls;
	global $time_start;
	global $zone;
	global $regexpZone;
	global $iswritefile;

  echo "HTTP CODE: " . $info['http_code'] . "\n";
  if ($info['http_code'] !== 200 AND $info['http_code'] !== 404) {

    if (stripos($info['url'], ENGINE_CURR)) {
      $bad_urls[] = $info['url'];
    }   
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 1800) { $bad_urls = array(); }    
  } else {
  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); // Режем все карточки на странице
  	foreach ($matches2 as $key) {
			
			preg_match($regexpPrices2, $key[1], $matches); // Исследуем каждую карточку в отдельности
			/*
			if (strripos($matches[3], '<div class="new">')) { // Если есть "новый прайс"
				preg_match("~<div class=\"new\">(.+)</div>~isU", $matches[3], $matchesprice);
				$matches[3] = $matchesprice[1];
				$matches = parser_clean($matches, 2, 3);
				$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(iconv('UTF-8', 'Windows-1251',$matches[2]), $matches[3]);
				echo trim($matches[1]) . "\n";								
			} else {
				$matches = parser_clean($matches, 2, 3);
				$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(iconv('UTF-8', 'Windows-1251',$matches[2]), $matches[3]);
				echo trim($matches[1]) . "\n";				
			}
			*/
			preg_match($regexpZone, $response, $matchesZone);
			//print_r($matchesZone);
			if ($matches[3] > 0 AND $matchesZone[1] == $zone) {
				//echo 'Зона совпала - это ' . $zone . "\n";
				$iswritefile = 1; // Писать ли файл?
				$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(trim(iconv('utf-8', 'windows-1251', $matches[2])), preg_replace('~[^\d.]+~', '' , $matches[3]));
				echo trim($matches[1]) . ":" . $matches[3] . "\n";
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
	global $zone;
	global $regexpZone;
	global $iswritefile;

  echo $info['url'] . "\n";
  echo "HTTP CODE: " . $info['http_code'] . "\n";
  if ($info['http_code'] !== 200 AND $info['http_code'] !== 404) {

    if (stripos($info['url'], ENGINE_CURR)) {
      $bad_urls[] = $info['url'];
    }   
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 1800) { $bad_urls = array(); }    
  } else {
  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); // Режем все карточки на странице
  	foreach ($matches2 as $key) {
			preg_match($regexpPrices2, $key[1], $matches); // Исследуем каждую карточку в отдельности
			
			preg_match($regexpZone, $response, $matchesZone);
			if ($matches[3] > 0 AND $matchesZone[1] == $zone) {
				$iswritefile = 1; // Писать ли файл?
				$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(trim(iconv('utf-8', 'windows-1251', $matches[2])), preg_replace('~[^\d.]+~', '' , $matches[3]));
				echo trim($matches[1]) . ":" . $matches[3] . "\n";
			}
		} 	
  }
}
