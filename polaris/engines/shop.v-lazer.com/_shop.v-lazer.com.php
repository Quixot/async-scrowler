<?php
/**
 * shop.v-lazer.com
 */
defined('_JEXEC') or die('Silentium videtur confessio');

switch (EXTRA_PARAM) {
 	case 'vladivostok':
 		$region = '053adb6202177e482e74fdaf1c0fdd3ac2935896%7E';
 		break; 
 	default:
 		die("Unknown region\n");  	 		
}

$options 			 = array(CURLOPT_COOKIE => 'region=' . $region); // Подставляем coockie региона
$urlStart 		 = 'http://shop.v-lazer.com/catalog/~/search/page-'; // Первая часть адреса
$urlEnd 			 = '/?query=' . ENGINE_TYPE;
$regexpP 			 = "~class=\"pageline\"(.+)</div>.*</li>~isU"; // Пагинация
$regexpP2 		 = "~<a href.*page-(.+)/?~isU";
$regexpPrices  = "~class=\"cell.*\"(.+)class=\"shoplist\"~isU";
$regexpPrices2 = "~class=\"name\".*href=\"(.+)\".*>(.+)<.*class=\"price\".*<li.*>(.+)<~isU";	// Все товары на странице
$regexpPrices3 = "~class=\"name\".*href=\"(.+)\".*>(.+)<~isU";	// Все товары на странице

/**
 * МЕГАЦИКЛ
 */
for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
	if ($iGlobalLoop > 0) {
		$AC->flush_requests();
		$AC->__set('callback','callback_one');
	}		
	// Узнаем, сколько позиций в пагинации
	$AC->get($urlStart . '1' . $urlEnd, null, $options);
	$AC->get($urlStart . '1' . $urlEnd, null, $options);
	$AC->get($urlStart . '1' . $urlEnd, null, $options);
	$AC->get($urlStart . '1' . $urlEnd, null, $options);
	echo $urlStart . '1' . $urlEnd . "\n";  // Пагинация
	$AC->execute(4);

	// Наименования товара и цены
	$AC->flush_requests();
	$AC->__set('callback','callback_two');	

	if ($qOfPaginationPages <= 0) { $qOfPaginationPages = 1; } // Если к-во страниц не определилось, сканируем хотя бы одну, иначе будет ошибка Window size
	echo 'Количество страниц: ' . $qOfPaginationPages . "\n";

	for ($i = 1; $i <= $qOfPaginationPages; $i++) {
	  $AC->get($urlStart . $i . $urlEnd, null, $options);	 
	  echo $urlStart . $i . $urlEnd . "\n"; 	 
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
  global $regexpP;
  global $regexpP2;
  global $qOfPaginationPages;
  global $bad_urls;

  if ($info['http_code'] !== 200) {            

  } else {
  	//preg_match("~cell bg_menu selectbox basebox city.*<span.*<span(.+)<~isU", $response, $reg);
  	//echo $reg[1];
		preg_match($regexpP, $response, $matches);
		print_r($matches);
		preg_match_all($regexpP2, $matches[0], $matches2);
		print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			echo "key: " . $key . "\n";
			echo "value:" . $value . "\n";
			if (is_numeric($value)) {
				$temparrpage[] = $value;
			}
		}

		if (@max($temparrpage) > $qOfPaginationPages) {
			echo "Страницы: " . $temparrpage . "\n";
			$qOfPaginationPages = @max($temparrpage);	    	
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

  if ($info['http_code'] !== 200) {
    if (stripos($info['url'], ENGINE_CURR)) {
      $bad_urls[] = $info['url'];
    }   
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 1800) { $bad_urls = array(); }    
  } else {  	
  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); // Режем все карточки на странице
  	print_r($matches2);
  	foreach ($matches2 as $key) {		
			preg_match($regexpPrices2, $key[1], $matches); // Исследуем каждую карточку в отдельности
			if ($matches[3]) {
				//$matches = parser_clean($matches, 2, 3);
 				$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(iconv('utf-8', 'windows-1251', $matches[2]), $matches[3]);
				echo 'http://' . ENGINE_CURR . trim($matches[1]) . "\n";	
			} else {
				preg_match($regexpPrices3, $key[1], $matches);
				if ($matches[1]) {					
					$matches[2] = str_replace(';', ' ', $matches[2]);
	 				$itemsArray['http://' . ENGINE_CURR . trim($matches[1])] = array(iconv('utf-8', 'windows-1251', $matches[2]), '0');
					echo 'http://' . ENGINE_CURR . trim($matches[1]) . "\n";						
				}
			}	
								
		}
  }
}
