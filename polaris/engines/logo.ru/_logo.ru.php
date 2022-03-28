<?php
/**
 * logo.ru
 */
defined('_JEXEC') or die('Silentium videtur confessio');

switch (EXTRA_PARAM) {
 	case 'yekaterinburg':
 		$region = 'a4eb7bd26e0e5a3a35431f1e890429b0';
 		break;
 	case 'chelyabinsk':
 		$region = 'f064e8e0876d2d924010a93e90aa4926';
 		break;
 	case 'perm':
 		$region = 'b2666f0c172b78f437d39e4464bbe45b';
 		break;
 	case 'perm':
 		$region = 'b2666f0c172b78f437d39e4464bbe45b';
 		break; 		
 	default:
 		die("Unknown region\n"); 		
}

$options 			 = array(CURLOPT_COOKIE => 'city=' . $region); 						// Подставляем coockie региона
$urlStart 		 = 'http://www.logo.ru/search-new?q=' . ENGINE_TYPE . '&page=';		// Первая часть адреса
//$regexpP 			 = "~<div class=\"pageNav2\">(.+)</div>~isU";	// Пагинация
//$regexpP2 		 = "~<a href=\".*>(.+)<~isU";		// Пагинация
$regexpAllP		 = "~<span class=\"sres_show\">(.+)<~isU";
$regexpPrices  = "~<div.*class=\"itempr(.+)<div class=\"inCart~isU";									// Все товары на странице
$regexpPrices2 = "~</div>.*<a href=\"(.+)\".*>(.+)</a>.*<span class=\"price\".*>(.+)</span>~isU"; // Режем карточки товара



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
	$AC->get($urlStart . '1', NULL, $options);
	echo $urlStart . '1' . "\n";  // Пагинация
	$AC->execute(3);	

	// Наименования товара и цены
	$AC->flush_requests();
	$AC->__set('callback','callback_two');	
	
	echo 'Количество страниц: ' . ceil($qOfPaginationPages/20) . "\n";

	for ($i = 1; $i <= ceil($qOfPaginationPages/20); $i++) {
	  $AC->get($urlStart . $i, NULL, $options);
	  $AC->add_debug_msg( $urlStart . $i ); // Проверим, какие адреса записываются для выполнения    
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
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpAllP;  
  global $qOfPaginationPages;
  global $bad_urls;

  if ($info['http_code'] !== 200 && !$qOfPaginationPages) {            
    if (stripos($info['url'], ENGINE_CURR)) {
      $bad_urls[] = $info['url'];
    }
  } else {
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
    if (stripos($info['url'], ENGINE_CURR) !== false && $response && strripos($response, '</html') === false) {       
      $bad_urls[] = $info['url'];    
    } else {  	
  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); // Режем все карточки на странице
	  	foreach ($matches2 as $key) {
				preg_match($regexpPrices2, $key[1], $matches); // Исследуем каждую карточку в отдельности
				
				$matches = parser_clean($matches, 2, 3);
				$matches[1] = trim($matches[1]);
				if (strripos($matches[1], 'http://') === false ) {
					$matches[1] = 'http://www.logo.ru' . $matches[1];
				}
				$itemsArray[$matches[1]] = array(iconv('UTF-8', 'Windows-1251',$matches[2]), $matches[3], date("d.m.y-H:i:s"), $request->options[10004]);
				echo $matches[1] . "\n";						
			}
		}
  }
}
