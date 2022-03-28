<?php
/**
 * ulmart.ru
 */
switch (EXTRA_PARAM) {
  case 'almetevsk':	$region = '721'; break;	
  case 'anapa':	$region = '501'; break;
  case 'apatity':	$region = '1969'; break;	
  case 'arzamas':	$region = '1730'; break;
  case 'armavir':	$region = '1522'; break;	
  case 'arhangelsk':	$region = '1809'; break;
  case 'balakovo':	$region = '1744'; break;	
  case 'belgorod':	$region = '1722'; break;
  case 'bryansk':	$region = '1841'; break;
  case 'velikijnovgorod':	$region = '361'; break;	
  case 'vladimir':	$region = '161'; break;
  case 'volgodonsk':	$region = '2355'; break;
  case 'volgograd':	$region = '1842'; break;
  case 'vologda':	$region = '1581'; break;	
  case 'dimitrovgrad':	$region = '2236'; break;
  case 'yekaterinburg':	$region = '1743'; break;
  case 'ivanovo':	$region = '421'; break;	
  case 'izhevsk':	$region = '1821'; break;
  case 'joshkar-ola':	$region = '1833'; break;
  case 'kaluga':	$region = '381'; break;
  case 'kostroma':	$region = '1732'; break;	
  case 'kropotkin':	$region = '1221'; break;
  case 'kursk':	$region = '1845'; break;
  case 'lipeck':	$region = '1687'; break;
  case 'majkop':	$region = '1561'; break;	
  case 'murmansk':	$region = '1782'; break;
  case 'naberezhnye-chelny':	$region = '741'; break;
  case 'nevinnomyssk':	$region = '2130'; break;	
  case 'nizhnekamsk':	$region = '941'; break;
  case 'novorossijsk':	$region = '481'; break;
  case 'novocherkassk':	$region = '1869'; break;	
  case 'oktyabrskij':	$region = '2273'; break;
  case 'orel':	$region = '1847'; break;
  case 'pavlovo':	$region = '1181'; break;	
  case 'petrozavodsk':	$region = '301'; break;
  case 'pskov':	$region = '241'; break;
  case 'pyatigorsk':	$region = '2295'; break;	
  case 'rybinsk':	$region = '1900'; break;
  case 'ryazan':	$region = '341'; break;
  case 'saratov':	$region = '881'; break;	
  case 'severodvinsk':	$region = '2214'; break;
  case 'smolensk': 	$region = '1850'; break;  
  case 'sochi': 	$region = '2212'; break;
  case 'stavropol': 	$region = '1562'; break;
  case 'staryj-oskol': 	$region = '1733'; break;  
  case 'taganrog': 	$region = '1601'; break;
  case 'tambov': 	$region = '1201'; break;
  case 'tver': 	$region = '61'; break;
  case 'tolyatti': 	$region = '1182'; break;  
  case 'tuapse': 	$region = '601'; break;
  case 'tula': 	$region = '121'; break;  
  case 'ulyanovsk': 	$region = '1708'; break;
  case 'cheboksary': 	$region = '1501'; break;
  case 'cherepovec': 	$region = '1341'; break;  
  case 'shahty': 	$region = '1695'; break;    
  case 'ehngels': 	$region = '1481'; break;
  case 'yaroslavl': 	$region = '101'; break;

// Города-Миллионики
  case 'chelyabinsk':	$region = '1812'; break;
  case 'moscow':	$region = '18414'; break;
  case 'spb':	$region = '18413'; break;
  case 'rostov':	$region = '401'; break;  
  case 'kazan':	$region = '181'; break;
  case 'krasnodar':	$region = '281'; break;
  case 'krasnoyarsk':	$region = '1824'; break;
  case 'novgorod':	$region = '321'; break;
  case 'novosibirsk':	$region = '1816'; break;
  case 'omsk':	$region = '1815'; break;
  case 'ufa':	$region = '1742'; break;
  case 'samara':	$region = '681'; break;
  case 'voronezh':	$region = '1021'; break;
  case 'yekaterinburg':	$region = '1743'; break;
  
 	default:
 		die("Unknown region\n");   		
}

$options 			= array(CURLOPT_COOKIE => 'city=' . $region);			 								// Подставляем coockie региона
$urlStart 		= 'http://www.ulmart.ru/searchAdditional?string=' . ENGINE_TYPE;	// Первая часть адреса
$urlEnd				= '&category=&rootCategory=&subcategory=&filters=&numericFilters=&brands=&shops=&recommended=&superPrice=&specOffers=&sort=6&viewType=2&minPrice=&maxPrice=&extended=&extendedFilters=&pageNum=';							 														// Вторая часть адреа и поисковая строка
$regexpPagin	= "~<sup class=\"text-muted\"><small>(.+)<~isU";
$regexpPrices = "~b-product__art-wrap\">.*b-price_size4.*class=\"b-price__num.*>(.+)<.*class=\"b-product__title.*<a.*href=\"(.+)\".*>(.+)</a~isU";
$regexpOneItem = "~<h1 itemprop=\"name\".*>(.+)<.*class=\"b-price__num js-price\".*>(.+)<~isU";



/**
 * МЕГАЦИКЛ
 */
for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
	if ($iGlobalLoop > 0) {
		$AC->flush_requests();
		$AC->__set('callback','callback_one');
	}		
	// Узнаем, сколько позиций в пагинации
	$AC->get('http://www.ulmart.ru/search?string=' . ENGINE_TYPE . '&rootCategory=&sort=6&viewType=2', NULL, $options);
	$AC->get('http://www.ulmart.ru/search?string=' . ENGINE_TYPE . '&rootCategory=&sort=6&viewType=2', NULL, $options);
	$AC->get('http://www.ulmart.ru/search?string=' . ENGINE_TYPE . '&rootCategory=&sort=6&viewType=2', NULL, $options);
	echo 'http://www.ulmart.ru/search?string=' . ENGINE_TYPE . '&rootCategory=&sort=6&viewType=2';
	$AC->execute(3);

	// Наименования товара и цены
	$AC->flush_requests();
	$AC->__set('callback','callback_two');	

	echo 'Количество страниц: ' . $qOfPaginationPages . "\n";
	if ($qOfPaginationPages < 1) {
		$qOfPaginationPages = 1;
	}

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

	// Сохраним массив в переменную
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));

} // МЕГАЦИКЛ

/**
 * Формируем CSV файл
 *
 */
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpPagin;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices;
	global $regexpOneItem;
	global $itemsArray;
	global $time_start;
	global $errorsArray;

  if ($info['http_code'] !== 200) {            
    //if (stripos($info['url'], ENGINE_CURR)) {
    //  $bad_urls[] = $info['url'];
    //}
  } else {
    preg_match($regexpPagin, $response, $matches); // Сколько страниц цен
    print_r($matches);    
    $temp = ceil( preg_replace('~[^\d.]+~', '' , $matches[1]) / 30);
    if ($temp > $qOfPaginationPages) {      
	    $qOfPaginationPages = $temp;
    }

  	preg_match_all($regexpPrices, $response, $matches, PREG_SET_ORDER); //		
		if ($matches) {
			foreach ($matches as $key) {
				$key[3] = strip_tags($key[3]);
				if (strripos($key[0], 'href="/cart/add') !== false) {
					price_change_detect('http://' . ENGINE_CURR . $key[2], trim($key[3]), trim(preg_replace('~[^\d.]+~', '' , $key[1])), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['http://' . ENGINE_CURR . $key[2]] = array(trim($key[3]), trim(preg_replace('~[^\d.]+~', '' , $key[1])), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);			
					echo $key[2] . "\n";			
				}	else {
					price_change_detect('http://' . ENGINE_CURR . $key[2], trim($key[3]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['http://' . ENGINE_CURR . $key[2]] = array(trim($key[3]), '0',
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url);			
					echo $key[2] . " - null\n";					
				}		
			}
		} else {
			preg_match($regexpPrices, $response, $matches);
			if ($matches[1]) {
				price_change_detect(substr($info['url'], 0, strripos($info['url'], '?')), trim($matches[1]), trim(preg_replace('~[^\d.]+~', '' , $matches[2])), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[substr($info['url'], 0, strripos($info['url'], '?'))] = array(trim($matches[1]), trim(preg_replace('~[^\d.]+~', '' , $matches[2])),
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url);
				echo $matches[1] . " - Unique\n";
			}
		}

  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices;
	global $regexpOneItem;
	global $matches;
	global $itemsArray;
	global $bad_urls;
	global $time_start;
	global $errorsArray;

  if ($info['http_code'] !== 200) {
    if (stripos($info['url'], ENGINE_CURR)) {
      $bad_urls[] = $info['url'];
    }   
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 1800) { $bad_urls = array(); }        
  } else {	
  	preg_match_all($regexpPrices, $response, $matches, PREG_SET_ORDER); //		
		if ($matches) {
			foreach ($matches as $key) {
				$key[3] = strip_tags($key[3]);
				if (strripos($key[0], 'href="/cart/add') !== false) {
					price_change_detect('http://' . ENGINE_CURR . $key[2], trim($key[3]), trim(preg_replace('~[^\d.]+~', '' , $key[1])), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['http://' . ENGINE_CURR . $key[2]] = array(trim($key[3]), trim(preg_replace('~[^\d.]+~', '' , $key[1])), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);			
					echo $key[2] . "\n";			
				}	else {
					price_change_detect('http://' . ENGINE_CURR . $key[2], trim($key[3]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['http://' . ENGINE_CURR . $key[2]] = array(trim($key[3]), '0',
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url);			
					echo $key[2] . " - null\n";					
				}		
			}
		} else {
			preg_match($regexpPrices, $response, $matches);
			if ($matches[1]) {
				price_change_detect(substr($info['url'], 0, strripos($info['url'], '?')), trim(strip_tags($matches[1])), trim(preg_replace('~[^\d.]+~', '' , $matches[2])), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[substr($info['url'], 0, strripos($info['url'], '?'))] = array(trim(strip_tags($matches[1])), trim(preg_replace('~[^\d.]+~', '' , $matches[2])),
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url);
				echo $matches[1] . " - Unique\n";
			}
		}
  }
}
