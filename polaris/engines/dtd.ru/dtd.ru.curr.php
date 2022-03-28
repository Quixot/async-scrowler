<?php
/**
 * dtd.ru
 */
defined('_JEXEC') or die('Silentium videtur confessio');

switch (EXTRA_PARAM) {
  case 'moscow': 
    $region   = '%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0%2C+';
    $regionRu = 'Москва';
    $cityid = '77000000000';
    break;
  case 'spb':
    $region   = '%D0%A1%D0%B0%D0%BD%D0%BA%D1%82-%D0%9F%D0%B5%D1%82%D0%B5%D1%80%D0%B1%D1%83%D1%80%D0%B3%2C+';
    $regionRu = 'Санкт-Петербург';
    $cityid = '78000000000';   
    break;
  case 'chelyabinsk':
    $region   = '%D0%A7%D0%B5%D0%BB%D1%8F%D0%B1%D0%B8%D0%BD%D1%81%D0%BA%2C+%D0%A7%D0%B5%D0%BB%D1%8F%D0%B1%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB';
    $regionRu = 'Челябинск';
    $cityid = '74000001000';   
    break;
  case 'yekaterinburg':
    $region   = '%D0%95%D0%BA%D0%B0%D1%82%D0%B5%D1%80%D0%B8%D0%BD%D0%B1%D1%83%D1%80%D0%B3%2C+%D0%A1%D0%B2%D0%B5%D1%80%D0%B4%D0%BB%D0%BE%D0%B2%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB';
    $regionRu = 'Екатеринбург';
    $cityid = '66000001000';    
    break;  
  case 'kazan':
    $region   = '%D0%9A%D0%B0%D0%B7%D0%B0%D0%BD%D1%8C%2C+%D0%A2%D0%B0%D1%82%D0%B0%D1%80%D1%81%D1%82%D0%B0%D0%BD+%D0%A0%D0%B5%D1%81%D0%BF';
    $regionRu = 'Казань';
    $cityid = '16000001000';
    break;
  case 'krasnoyarsk':
    $region   = '%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D1%8F%D1%80%D1%81%D0%BA%2C+%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D1%8F%D1%80%D1%81%D0%BA%D0%B8%D0%B9+%D0%BA%D1%80%D0%B0%D0%B9';
    $regionRu = 'Красноярск';
    $cityid = '24000001000';
    break;
  case 'krasnodar':
    $region   = '%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D0%B4%D0%B0%D1%80%2C+%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D0%B4%D0%B0%D1%80%D1%81%D0%BA%D0%B8%D0%B9+%D0%BA%D1%80%D0%B0%D0%B9';
    $regionRu = 'Краснодар';
    $cityid = '23000001000';
    break;
  case 'novgorod':
    $region   = '%D0%9D%D0%B8%D0%B6%D0%BD%D0%B8%D0%B9+%D0%9D%D0%BE%D0%B2%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%2C+%D0%9D%D0%B8%D0%B6%D0%B5%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB';
    $regionRu = 'Нижний Новгород';
    $cityid = '52000001000';    
    break;
  case 'novosibirsk':
    $region   = '%D0%9D%D0%BE%D0%B2%D0%BE%D1%81%D0%B8%D0%B1%D0%B8%D1%80%D1%81%D0%BA%2C+%D0%9D%D0%BE%D0%B2%D0%BE%D1%81%D0%B8%D0%B1%D0%B8%D1%80%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB';
    $regionRu = 'Новосибирск';
    $cityid = '54000001000';    
    break;
  case 'omsk':
    $region   = '%D0%9E%D0%BC%D1%81%D0%BA%2C+%D0%9E%D0%BC%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB';
    $regionRu = 'Омск';
    $cityid = '55000001000';    
    break; 
  case 'perm':
    $region   = '%D0%9F%D0%B5%D1%80%D0%BC%D1%8C%2C+%D0%9F%D0%B5%D1%80%D0%BC%D1%81%D0%BA%D0%B8%D0%B9+%D0%BA%D1%80%D0%B0%D0%B9';
    $regionRu = 'Пермь';
    $cityid = '59000001000';    
    break;    
  case 'rostov':
    $region   = '%D0%A0%D0%BE%D1%81%D1%82%D0%BE%D0%B2-%D0%BD%D0%B0-%D0%94%D0%BE%D0%BD%D1%83%2C+%D0%A0%D0%BE%D1%81%D1%82%D0%BE%D0%B2%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB';
    $regionRu = 'Ростов-на-Дону';
    $cityid = '61000001000';    
    break;
  case 'samara':
    $region   = '%D0%A1%D0%B0%D0%BC%D0%B0%D1%80%D0%B0%2C+%D0%A1%D0%B0%D0%BC%D0%B0%D1%80%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB';
    $regionRu = 'Самара';
    $cityid = '63000001000';    
    break;
  case 'ufa':
    $region   = '%D0%A3%D1%84%D0%B0%2C+%D0%91%D0%B0%D1%88%D0%BA%D0%BE%D1%80%D1%82%D0%BE%D1%81%D1%82%D0%B0%D0%BD+%D0%A0%D0%B5%D1%81%D0%BF';
    $regionRu = 'Уфа';
    $cityid = '02000001000';    
    break;
  case 'vladivostok':
    $region   = '%D0%92%D0%BB%D0%B0%D0%B4%D0%B8%D0%B2%D0%BE%D1%81%D1%82%D0%BE%D0%BA%2C+%D0%9F%D1%80%D0%B8%D0%BC%D0%BE%D1%80%D1%81%D0%BA%D0%B8%D0%B9+%D0%BA%D1%80%D0%B0%D0%B9';
    $regionRu = 'Владивосток';
    $cityid = '25000001000';    
    break;
  case 'volgograd':
    $region   = '%D0%92%D0%BE%D0%BB%D0%B3%D0%BE%D0%B3%D1%80%D0%B0%D0%B4%2C+%D0%92%D0%BE%D0%BB%D0%B3%D0%BE%D0%B3%D1%80%D0%B0%D0%B4%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB';
    $regionRu = 'Волгоград';
    $cityid = '34000001000';
    break;
  case 'voronezh':
    $region   = '%D0%92%D0%BE%D1%80%D0%BE%D0%BD%D0%B5%D0%B6%2C+%D0%92%D0%BE%D1%80%D0%BE%D0%BD%D0%B5%D0%B6%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB';
    $regionRu = 'Воронеж';
    $cityid = '36000001000';    
    break;  
  default:
    die("Unknown region\n");      
}

$options 			 = array(CURLOPT_COOKIE => 'BITRIX_SM_SELECTED_CITY_KLADRCODE=' . $cityid . ';BITRIX_SM_SELECTED_CITY=' . $region); 					// Подставляем coockie региона
$regexpPrices  = "~<div class=\"catalog-element\">.*<div class=\"title\">.*<h1>(.+)<.*class=\"insider-price\">.*<strong>(.+)<.*class=\"button-orange-158x30 add2basket\"(.+)</div>~isU";
$regexpRegion  = "~<div class=\"title-city\">(.+)</div>~isU"; // Регион

$directlinks = file_get_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'directlinks.txt');
$directlinksarray = split("\n", $directlinks);
/**
 * МЕГАЦИКЛ
 */
for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
	foreach ($directlinksarray as $key => $value) {
	  $AC->get($value, NULL, $options);
	  $AC->add_debug_msg( $value ); // Проверим, какие адреса записываются для выполнения    
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
	global $regexpPrices;
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
	  
	  preg_match($regexpPrices, $response, $matches); // 	

		if ($matches[2] > 0) { // Если есть кнопка купить, то товар в наличии
				$itemsArray[$info['url']] = array(iconv('UTF-8', 'Windows-1251',trim($matches[1])), preg_replace('~[\D]+~', '' , $matches[2]), date("d.m.y-H:i:s"), $request->options[10004]); //iconv('UTF-8', 'Windows-1251', 
				echo trim($matches[1]) . "\n";						
		}		
  }
}
