<?php
/**
 * tehnosila.ru
 */
switch (EXTRA_PARAM) {
  case 'arhangelsk': 
  	$region = 'arhangelsk';
    break;  
  case 'astrakhan': 
  	$region = 'astrahan';
    break; 
  case 'barnaul': 
  	$region = 'barnaul';
    break;  
  case 'belgorod': 
  	$region = 'belgorod';
    break; 
  case 'bryansk': 
  	$region = 'brjansk';
    break;  
  case 'velikijnovgorod': 
  	$region = 'novgorod';
    break; 
  case 'vladimir': 
  	$region = 'vladimir';
    break;  
  case 'vologda': 
  	$region = 'vologda';
    break; 
  case 'ivanovo': 
  	$region = 'ivanovo';
    break;  
  case 'izhevsk': 
  	$region = 'izhevsk';
    break; 
  case 'irkutsk': 
  	$region = 'irkutsk';
    break;  
  case 'kaluga': 
  	$region = 'kaluga';
    break; 
  case 'kemerovo': 
  	$region = 'kemerovo';
    break;  
  case 'kostroma': 
  	$region = 'kostroma';
    break;
  case 'krasnoyarsk': 
  	$region = 'krasnojarsk';
    break;  
  case 'kursk': 
  	$region = 'kursk';
    break; 
  case 'lipeck': 
  	$region = 'lipetsk';
    break;  
  case 'magnitogorsk': 
  	$region = 'magnitogorsk';
    break;
  case 'murmansk': 
  	$region = 'murmansk';
    break;  
  case 'naberezhnye-chelny': 
  	$region = 'chelny';
    break;
  case 'nizhnevartovsk': 
  	$region = 'nizhnevartovsk';
    break;  
  case 'novgorod': 
  	$region = 'nizhnij-novgorod';
    break;
  case 'nizhnij-tagil': 
  	$region = 'nizhniy-tagil';
    break;  
  case 'novokuzneck': 
  	$region = 'novokuznetsk';
    break;
  case 'novocherkassk': 
  	$region = 'novocherkassk';
    break;  
  case 'noyabrsk': 
  	$region = 'noyabrsk';
    break;
  case 'orenburg': 
  	$region = 'orenburg';
    break;  
  case 'penza': 
  	$region = 'penza';
    break;        
  case 'petrozavodsk': 
  	$region = 'petrozavodsk';
    break;  
  case 'pskov': 
  	$region = 'pskov';
    break;
  case 'pyatigorsk': 
  	$region = 'pyatigorsk';
    break;  
  case 'ryazan': 
  	$region = 'ryazan';
    break; 
  case 'saratov': 
  	$region = 'saratov';
    break;  
  case 'smolensk': 
  	$region = 'smolensk';
    break;
  case 'sochi': 
  	$region = 'sochi';
    break;  
  case 'stavropol': 
  	$region = 'stavropol';
    break;        
  case 'surgut': 
  	$region = 'surgut';
    break;  
  case 'tambov': 
  	$region = 'tambov';
    break;
  case 'tver': 
  	$region = 'tver';
    break;  
  case 'tolyatti': 
  	$region = 'tolyatti';
    break;
  case 'tomsk': 
  	$region = 'tomsk';
    break;  
  case 'tula': 
  	$region = 'tula';
    break;
  case 'tyumen': 
  	$region = 'tyumen';
    break;  
  case 'ulan-udeh': 
  	$region = 'ulan';
    break;        
  case 'ulyanovsk': 
  	$region = 'ulyanovsk';
    break;  
  case 'habarovsk': 
  	$region = 'habarovsk';
    break;
  case 'cheboksary': 
  	$region = 'cheboksary';
    break;  
  case 'cherepovec': 
  	$region = 'cherepovets';
    break;
  case 'yakutsk': 
  	$region = 'jakutsk';
    break;  
  case 'chita': 
  	$region = 'chita';
    break;
  case 'yaroslavl': 
  	$region = 'yaroslavl';
    break;  

// Города-Миллионики
  case 'moscow': 
  	$region = 'moscow';
    break;
  case 'spb':
    $region = 'sankt-peterburg';
    break;
  case 'rostov':
  	$region = 'rostov-na-donu';
    break;
  case 'krasnodar':
  	$region = 'krasnodar';
  	break;
  case 'novosibirsk':
  	$region = 'novosibirsk';
  	break;
 	case 'yekaterinburg':
 		$region = 'ekaterinburg';
 		break;
 	case 'chelyabinsk':
 		$region = 'chelyabinsk';
 		break;
 	case 'volgograd':
 		$region = 'volgograd';
 		break;
 	case 'kazan':
 		$region = 'kazan';
 		break;
 	case 'perm':
 		$region = 'perm';
 		break;
 	case 'omsk':
 		$region = 'omsk';
 		break;
 	case 'samara':
 		$region = 'samara';
 		break; 		
 	case 'ufa':
 		$region = 'ufa1';
 		break;
 	case 'voronezh':
 		$region = 'voronezh';
 		break;
 	case 'vladivostok':
 		$region = 'vladivostok';
 		break; 
 	default:
 		die("Unknown region\n"); 
}

if ($region != 'moscow') {
	$subdomen = $region . '.';
} else {
	$subdomen = '';
}

//$options 			= array(CURLOPT_COOKIE => 'MVID_CITY_ID=' . EXTRA_PARAM); 		// Подставляем coockie региона
//$options 			= array(CURLOPT_COOKIE => 'viewType=list');
$options 			 = array(
								CURLOPT_COOKIE => 'viewType=list',
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT        => 330,
                CURLOPT_AUTOREFERER     => TRUE,
                CURLOPT_FOLLOWLOCATION  => TRUE,
                CURLOPT_HEADER => true, 
                CURLOPT_SSL_VERIFYPEER => 0	
	);
$urlStart 		= 'http://' . $subdomen . 'tehnosila.ru/search?q=' . ENGINE_TYPE;						// Первая часть адреса
$urlEnd				= '&region_intentional=1&p=';							 											// Вторая часть адреа и поисковая строка
$regexpPagin	= "~class=\"items-per-page-view\">(.+)<~isU"; 	// К-во найденых товаров
$regexpPrices = "~<div class=\"item-info\"(.+)<div class=\"clear\"></div>\s*</div>\s*</div>~isU"; 	// Все товары на странице
$regexpPrices2 = "~<div class=\"item-info-block\">.*<a.*href=\"(.+)\".*>(.+)</a>.*<div class=\"price\">.*<span class=\"number\">(.+)<span class=\"currency\">~isU";
$regexpPrices3 = "~<div class=\"item-info-block\">.*<a.*href=\"(.+)\".*>(.+)</a>.*<div class=\"price\">.*<span class=\"number-new\">(.+)<span class=\"currency\">~isU";


	// Узнаем, сколько позиций в пагинации
	$AC->get('http://' . $subdomen . 'tehnosila.ru/search?q=' . ENGINE_TYPE.$urlEnd.'1', NULL, $options);	
	$AC->get('http://' . $subdomen . 'tehnosila.ru/search?q=' . ENGINE_TYPE.$urlEnd.'2', NULL, $options);	
	$AC->get('http://' . $subdomen . 'tehnosila.ru/search?q=' . ENGINE_TYPE.$urlEnd.'1', NULL, $options);	
	//echo 'http://' . $subdomen . 'tehnosila.ru/search?q=' . ENGINE_TYPE.$urlEnd.'1';
	$AC->execute(3);


	// Наименования товара и цены
	$AC->flush_requests();
	$AC->__set('callback','callback_two');	

	if ($qOfPaginationPages <= 0) { $qOfPaginationPages = 1; } // Если к-во страниц не определилось, сканируем хотя бы одну, иначе будет ошибка Window size
	//echo 'Количество страниц: ' . $qOfPaginationPages . "\n";

	for ($i = 1; $i <= $qOfPaginationPages; $i++) {
	  $AC->get($urlStart . $urlEnd . $i, NULL, $options);
	  $AC->add_debug_msg( $urlStart . $urlEnd . $i ); // Проверим, какие адреса записываются для выполнения    
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


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpPagin;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
	global $time_start;
  global $qOfPaginationPages;
  global $bad_urls;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);  

  if ($info['http_code'] !== 200) {            
    //if (stripos($info['url'], ENGINE_CURR)) {
    //  $bad_urls[] = $info['url'];
    //}
  } else {
    preg_match($regexpPagin, $response, $matches); // Сколько страниц цен

    $temp = ceil( preg_replace('~\D+~', '' , $matches[1]) / 30 );
    if ($temp > $qOfPaginationPages) {      
	    $qOfPaginationPages = $temp;
    }   

	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  	//print_r($matches2);
	  	foreach ($matches2 as $key) {
				preg_match($regexpPrices2, $key[1], $matches);
				//print_r($matches);
				if (@$matches[1]) {
					price_change_detect(trim($matches[1]), trim($matches[2]), preg_replace('~[^\d]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(trim($matches[2]), preg_replace('~[^\d]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004]);		
					//echo trim($matches[2]).' - '.preg_replace('~[^\d]+~', '' , $matches[3])."\n";
				} else {
					preg_match($regexpPrices3, $key[1], $matches);
					if (@$matches[1]) {
						price_change_detect(trim($matches[1]), trim($matches[2]), preg_replace('~[^\d]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(trim($matches[2]), preg_replace('~[^\d]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004]);		
						//echo trim($matches[2]).' - '.trim($matches[3])."\n";
					}					
				}
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
		if (round(microtime(1) - $time_start, 0) >= 180) { $bad_urls = array(); }        
  } else {	
    	
	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  	foreach ($matches2 as $key) {
				preg_match($regexpPrices2, $key[1], $matches);
				if (@$matches[1]) {
					price_change_detect(trim($matches[1]), trim($matches[2]), preg_replace('~[^\d]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(trim($matches[2]), preg_replace('~[^\d]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004]);		
					//echo trim($matches[1]) . "\n";
				} else {
					preg_match($regexpPrices3, $key[1], $matches);
					if (@$matches[1]) {
						price_change_detect(trim($matches[1]), trim($matches[2]), preg_replace('~[^\d]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(trim($matches[2]), preg_replace('~[^\d]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004]);		
						//echo trim($matches[1]) . "\n";
					}					
				}
			}
		 	
  }
}
