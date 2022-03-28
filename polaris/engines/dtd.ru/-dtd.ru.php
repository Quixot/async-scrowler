<?php
/**
 * dtd.ru
 *
 * ENGINE_CURR	Текущий движок
 * ENGINE_TYPE	Тип группы товаров
 * ENGINE_LOOP	К-во циклов
 * WINDOW_SIZE	К-во потоков
 * EXTRA_PARAM 	Доп. параметр, на всякий случай
 *
 * moscow 				- Москва
 * spb 						- СПБ
 * rostov-na-donu - Ростов-на-Дону
 * novosibirsk 		- Новосибирск
 * ekaterinburg 	- Екатеринбург
 * сhelyabinsk		- Челябинск
 * 
 */
defined('_JEXEC') or die('Silentium videtur confessio');

switch (EXTRA_PARAM) {
  case 'moscow': 
  	$region 	= '%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0%2C+';
  	$regionRu = 'Москва';
  	$cityid = '77000000000';
  	$storeid = '5';
    break;
  case 'spb':
    $region 	= '%D0%A1%D0%B0%D0%BD%D0%BA%D1%82-%D0%9F%D0%B5%D1%82%D0%B5%D1%80%D0%B1%D1%83%D1%80%D0%B3%2C+';
    $regionRu = 'Санкт-Петербург';
  	$cityid = '78000000000';   
  	$storeid = '4'; 
    break;
  case 'rostov':
  	$region 	= '%D0%A0%D0%BE%D1%81%D1%82%D0%BE%D0%B2-%D0%BD%D0%B0-%D0%94%D0%BE%D0%BD%D1%83%2C+%D0%A0%D0%BE%D1%81%D1%82%D0%BE%D0%B2%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB';
  	$regionRu = 'Ростов-на-Дону';
  	$cityid = '61000001000';  	
  	$storeid = '5';
    break;
  case 'novosibirsk':
  	$region 	= '%D0%9D%D0%BE%D0%B2%D0%BE%D1%81%D0%B8%D0%B1%D0%B8%D1%80%D1%81%D0%BA%2C+%D0%9D%D0%BE%D0%B2%D0%BE%D1%81%D0%B8%D0%B1%D0%B8%D1%80%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB';
  	$regionRu = 'Новосибирск';
  	$cityid = '54000001000';  	
  	$storeid = '13';
  	break;
 	case 'yekaterinburg':
 		$region 	= '%D0%95%D0%BA%D0%B0%D1%82%D0%B5%D1%80%D0%B8%D0%BD%D0%B1%D1%83%D1%80%D0%B3%2C+%D0%A1%D0%B2%D0%B5%D1%80%D0%B4%D0%BB%D0%BE%D0%B2%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB';
 		$regionRu = 'Екатеринбург';
  	$cityid = '66000001000';		
  	$storeid = '4';
 		break;
 	case 'chelyabinsk':
 		$region 	= '%D0%A7%D0%B5%D0%BB%D1%8F%D0%B1%D0%B8%D0%BD%D1%81%D0%BA%2C+%D0%A7%D0%B5%D0%BB%D1%8F%D0%B1%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB';
 		$regionRu = 'Челябинск';
  	$cityid = '74000001000'; 	
  	$storeid = '5';	
 		break; 	
 	case 'volgograd':
 		$region 	= '%D0%92%D0%BE%D0%BB%D0%B3%D0%BE%D0%B3%D1%80%D0%B0%D0%B4%2C+%D0%92%D0%BE%D0%BB%D0%B3%D0%BE%D0%B3%D1%80%D0%B0%D0%B4%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB';
 		$regionRu	= 'Волгоград';
  	$cityid = '34000001000'; 		
  	$storeid = '5';
 		break;
 	case 'perm':
 		$region 	= '%D0%9F%D0%B5%D1%80%D0%BC%D1%8C%2C+%D0%9F%D0%B5%D1%80%D0%BC%D1%81%D0%BA%D0%B8%D0%B9+%D0%BA%D1%80%D0%B0%D0%B9';
 		$regionRu	= 'Пермь';
  	$cityid = '59000001000'; 		
  	$storeid = '19';
 		break;
 	case 'kazan':
 		$region 	= '%D0%9A%D0%B0%D0%B7%D0%B0%D0%BD%D1%8C%2C+%D0%A2%D0%B0%D1%82%D0%B0%D1%80%D1%81%D1%82%D0%B0%D0%BD+%D0%A0%D0%B5%D1%81%D0%BF';
 		$regionRu	= 'Казань';
  	$cityid = '16000001000'; 
  	$storeid = '5';		
 		break; 		
 	default:
 		die("Unknown region\n");   		
}

$options 			 = array(CURLOPT_COOKIE => 'BITRIX_SM_SELECTED_CITY_KLADRCODE=' . $cityid . ';BITRIX_SM_STORE_ID=' . $storeid . ';BITRIX_SM_SELECTED_CITY=' . $region); 					// Подставляем coockie региона
$urlStart 		 = 'http://dtd.ru/search/?q=' . ENGINE_TYPE . '&s=&PAGEN_2=';	// Адрес
$regexpP 			 = "~<div class=\"catalog-pagenav clearfix\">.*</a>.*</div>~isU"; 	// Пагинация
$regexpP2 		 = "~<a.*href.*>(.+)</a>~isU";																			// Пагинация
$regexpPrices  = "~<div.*class=\"catalog-item catalog-position catalog(.+)<div class=\"attributes\"~isU"; // Все товары на странице
$regexpPrices2 = "~<div.*class=\"price\".*>(.+)<.*class=\"name\">.*<a.*href=\"(.+)\".*>(.+)</a>~isU"; 			// Режем карточки товара
$regexpRegion  = "~<div class=\"title-city\">(.+)</div>~isU"; // Регион


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
	echo $urlStart . "1" ."\n";
	$AC->execute(3);	

	// Наименования товара и цены
	$AC->flush_requests();
	$AC->__set('callback','callback_two');	

	if ($qOfPaginationPages <= 0) { $qOfPaginationPages = 1; } // Если к-во страниц не определилось, сканируем хотя бы одну, иначе будет ошибка Window size
	echo 'Количество страниц: ' . $qOfPaginationPages . "\n";

	for ($i = 1; $i <= $qOfPaginationPages; $i++) {
	  $AC->get($urlStart . $i, NULL, $options);
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
  global $regexpP;
  global $regexpP2;
  global $qOfPaginationPages;
  global $bad_urls;

  if ($info['http_code'] !== 200) {            
    //if (stripos($info['url'], ENGINE_CURR)) {
    //  $bad_urls[] = $info['url'];
    //}
  } else {
		preg_match($regexpP, $response, $matches);
		//print_r($matches);
		preg_match_all($regexpP2, $matches[0], $matches2);
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
			echo "Страницы: " . $temparrpage . "\n";
			$qOfPaginationPages = @max($temparrpage);		    	
		}
  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $matches;
	global $itemsArray;
	global $bad_urls;
	global $time_start;
	global $region;
	global $regionRu;
	global $regexpRegion;

  if ($info['http_code'] !== 200) {
    if (strripos($info['url'], ENGINE_CURR) && strripos($info['url'], 'old_browser_not_support') === false) {
      $bad_urls[] = $info['url'];
    }   
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 1800) { $bad_urls = array(); }      
  } else {
  	preg_match($regexpRegion, $response, $mregion);
  	echo "Регион: " . $regionRu . "\n";
  	echo "Регион: " . $mregion[1] . "\n";

  	//if (trim($mregion[1]) == $regionRu) {  // Проверка региона  	
  		//echo 'Регион сработал' . "\n";
	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); // 	

	  	foreach ($matches2 as $key) {
				preg_match($regexpPrices2, $key[1], $matches);
				if (strripos($key[1], 'button-orange') !== false) { // Тут дополнительно нужно проверять наличие. Если кнопка оранжевая, сканируем			
					$itemsArray['http://' . ENGINE_CURR . trim($matches[2])] = array(iconv('UTF-8', 'Windows-1251',trim($matches[3])), preg_replace('~[\D]+~', '' , $matches[1])); //iconv('UTF-8', 'Windows-1251', 
					echo trim($matches[1]) . "\n";						
				}
			} 
		//}	/*elseif (trim($mregion[1]) != $regionRu && sizeof($mregion[1]) > 0) {
  		//$bad_urls[] = $info['url'];
  	//}	*/
  }
}
