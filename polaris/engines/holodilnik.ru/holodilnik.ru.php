<?php
/**
 * holodilnik.ru
 */
switch (EXTRA_PARAM) {
	case 'chelyabinsk': $region = '50'; $city = 'Челябинск'; break; //	Челябинск
	case 'kazan': $region = '27'; $city = 'Казань'; break; //	Казань
	case 'krasnodar': $region = '14'; $city = 'Краснодар'; break; //	Краснодар	
	case 'moscow': $region = '1'; $city = 'Москва и область'; break; //	Москва
	case 'novgorod': $region = '20'; $city = 'Нижний Новгород'; break; //	Нижний Новгород
	case 'novosibirsk': $region = '19'; $city = 'Новосибирск'; break; //	Новосибирск
	case 'omsk': $region = '49'; $city = 'Омск'; break; //	Омск
	case 'pyatigorsk': $region = '42'; $city = 'Пятигорск'; break; //	Пятигорск
	case 'rostov': $region = '26'; $city = 'Ростов-на-Дону'; break; //	Ростов-на-Дону
	case 'samara': $region = '44'; $city = 'Самара'; break; //	Самара
	case 'spb': $region = '2'; $city = 'Санкт-Петербург'; break; //	Санкт-Петербург	
	case 'ufa': $region = '9'; $city = 'Уфа'; break; //	Уфа
	case 'volgograd': $region = '4'; $city = 'Волгоград'; break; //	Волгоград
	case 'voronezh': $region = '28'; $city = 'Воронеж'; break; //	Воронеж
	case 'yekaterinburg': $region = '41'; $city = 'Екатеринбург'; break; //	Екатеринбург

	case 'anapa': $region = '35'; break; //	Анапа
	case 'barnaul': $region = '32'; break; //	Барнаул
	case 'velikijnovgorod': $region = '13'; break; //	Великий Новгород
	case 'vladimir': $region = '24'; break; //	Владимир
	case 'ivanovo': $region = '23'; break; //	Иваново
	case 'kaluga': $region = '5'; break; //	Калуга
	case 'kemerovo': $region = '29'; break; //	Кемерово
	case 'kostroma': $region = '25'; break; //	Кострома
	case 'lipeck': $region = '22'; break; //	Липецк
	case 'novorossijsk': $region = '33'; break; //	Новороссийск
	case 'obninsk': $region = '8'; break; //	Обнинск
	case 'ryazan': $region = '12'; break; //	Рязань
	case 'sochi': $region = '30'; break; //	Сочи
	case 'stavropol': $region = '43'; break; //	Ставрополь
	case 'syzran': $region = '47'; break; //	Сызрань
	case 'tambov': $region = '16'; break; //	Тамбов
	case 'tver': $region = '6'; break; //	Тверь
	case 'tolyatti': $region = '45'; break; //	Тольятти
	case 'tuapse': $region = '37'; break; //	Туапсе
	case 'tula': $region = '7'; break; //	Тула
	case 'ulyanovsk': $region = '46'; break; //	Ульяновск
	case 'yaroslavl': $region = '15'; break; //	Ярославль
 	default:
 		die("Unknown region\n");   	
}

$options 			= array(CURLOPT_COOKIE => 'region_position_nn=' . $region); 	// Подставляем coockie региона
$urlStart 		 = 'https://www.holodilnik.ru/search/?search=polaris&page=';										// Первая часть адреса
$urlEnd				 = '';							 				// Вторая часть адреа и поисковая строка
$regexpP1 	 	 = "~class=\"pagination\"(.+)</ul>~isU";
$regexpP2	 		 = "~<a.*>(.+)<~isU";
$regexpPrices  = "~itemprop=\"itemListElement\"(.+)class='item-status~isU";												 					// Все товары на странице
$regexpPrices2 = "~product-name.*href=\"(.+)\".*itemprop=\"name\".*>(.+)</a>.*class='price'>(.+)<~isU";
$regexpPrices3 = "~product-name.*href=\"(.+)\".*itemprop=\"name\".*>(.+)</a>.*<div.*class=\"price price.*</em></div>(.+)<~isU";
$regexpPrices4 = "~product-name.*href=\"(.+)\".*itemprop=\"name\".*>(.+)</a>.*class='old-price'>.*</div>(.+)<~isU";
$regexpPrices5 = "~product-name.*href=\"(.+)\".*itemprop=\"name\".*>(.+)</a>~isU";
$regRegion = "~class=\"data-region your_reg\".*<span>(.+)<~isU";

	// Загрузка отсканированных ссылок:
	foreach ($itemsArray as $key => $value) {
		$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
		//echo (time() - $date->format('U')).PHP_EOL; 
		if (time() - $date->format('U') <= 5400) {
			$already_scanned[] = trim($value[5]);
		}
		
	}
	if ($already_scanned) {
		$already_scanned = array_unique($already_scanned);
		$already_scanned = array_values($already_scanned);
		print_r($already_scanned); 
	} else {
		$already_scanned = array();
	}
//$already_scanned = array();
	// Узнаем, сколько позиций в пагинации
	$AC->get($urlStart . '1', NULL, $options);
	//$AC->get($urlStart . '2', NULL, $options);
	$AC->execute(WINDOW_SIZE);	

	// Наименования товара и цены
	//$AC->flush_requests();
	//$AC->__set('callback','callback_two');	

	if ($qOfPaginationPages > 2) {
		$is_any = 0;
		for ($i = 1; $i <= $qOfPaginationPages; $i++) {
			if (!in_array($urlStart.$i, $already_scanned)) {
				echo 'сканирую адрес:'.PHP_EOL.$urlStart.$i.PHP_EOL;
				$AC->get($urlStart.$i, NULL, $options);
				$is_any = 1;
			} else {
				echo 'уже сканировал:'.PHP_EOL.$urlStart.$i.PHP_EOL;
			}
		}
		if ($is_any) {
			$AC->execute(WINDOW_SIZE);
		}
		

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
	}

	$links = array(
		'https://holodilnik.ru/domestic/irons/polaris/',
		'https://holodilnik.ru/domestic/dampener_of_air/polaris/',
		'https://holodilnik.ru/small_domestic/meat_grinder/polaris/',
		'https://holodilnik.ru/small_domestic/dryers_for_vegetables/polaris/',
		'https://holodilnik.ru/small_domestic/electric_furnace/polaris/',
		'https://holodilnik.ru/small_domestic/double_boiler/polaris/',
		'https://holodilnik.ru/small_domestic/coffee_makers/polaris/',
		'https://holodilnik.ru/small_domestic/teapots/polaris/',
		'https://holodilnik.ru/domestic/heaters/polaris/',
		'https://holodilnik.ru/beauty/hair_driers/polaris/',
		'https://holodilnik.ru/small_domestic/blenders/polaris/',
		'https://holodilnik.ru/beauty/nipper_for_stacking_hair/polaris/',
		'https://holodilnik.ru/domestic/fans/polaris/',
		'https://holodilnik.ru/domestic/cleaner_of_air/polaris/',
		'https://holodilnik.ru/domestic/konvectors/polaris/',
		'https://holodilnik.ru/domestic/heat_fans/polaris/',
		'https://holodilnik.ru/domestic/clears_steam/polaris/',
		'https://holodilnik.ru/domestic/robo_cleaners/polaris/',
		'https://holodilnik.ru/beauty/machine_for_a_hairstyle_of_hair/polaris/',
		'https://holodilnik.ru/small_domestic/coffee_grinders/polaris/',
		'https://holodilnik.ru/domestic/heaters_of_waters/polaris/',
		);

	foreach ($links as $url) {
		if (!in_array($url, $already_scanned)) {
			echo 'сканирую адрес:'.PHP_EOL.$url.PHP_EOL;
			$AC->get($url, NULL, $options);
			$is_any = 1;
		} else {
			echo 'уже сканировал:'.PHP_EOL.$url.PHP_EOL;
		}
	}
	if ($is_any) {
		$AC->execute(WINDOW_SIZE);
	}	

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

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));

	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;
  global $regRegion;
  global $city;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $regexpPrices5;
	global $itemsArray;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 180) { $bad_urls = array(); }
  } else {
  	//file_put_contents('/var/www/polaris/engines/holodilnik.ru/content.txt', $response);

		preg_match($regRegion, $response, $mReg); 
		$mReg[1] = trim(iconv('windows-1251', 'utf-8', $mReg[1]));
		AngryCurl::add_debug_msg($mReg[1].' | '.$city);

		if (1==1) { //$mReg[1] == $city
			preg_match($regexpP1, $response, $matches);
			//print_r($matches);
			@preg_match_all($regexpP2, $matches[1], $matches2);
			//print_r($matches2);
			$temparrpage = array();
			foreach ($matches2[1] as $key => $value) {
				//echo "key: " . $key . "\n";
				echo "value:" . $value . "\n";
				if (is_numeric($value)) {
					$temparrpage[] = $value;
				}
			}

			if (@max($temparrpage) > $qOfPaginationPages) {
				$qOfPaginationPages = @max($temparrpage);	    	
			}	

	   	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); 
			//print_r($matches2);
	  	foreach ($matches2 as $key) {
	  		if (strripos($key[1], iconv('utf-8', 'windows-1251', 'В корзину')) !== false) { // Если в наличии
					if (strripos($key[1], 'old-price') !== false) {  // Если цена со скидкой %
						preg_match($regexpPrices4, $key[1], $matches);
						//print_r($matches);					
						$matches[2] = strip_tags($matches[2]);
						$matches[3] = str_replace('&#8381;', '', $matches[3]);
						$matches[3] = preg_replace('~[^\d]+~', '' ,$matches[3]);
						price_change_detect('https:'.trim($matches[1]), trim(iconv('windows-1251', 'UTF-8', $matches[2])), trim($matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray['https:'.trim($matches[1])] = array(trim(iconv('windows-1251', 'UTF-8', $matches[2])), trim($matches[3]), date("d.m.y-H:i:s"), $request->options[10004],
						$request->options[10018],
						$request->url);
						AngryCurl::add_debug_msg(iconv('windows-1251', 'UTF-8', $matches[2]).' | '.$matches[3]);					
					} else {
						preg_match($regexpPrices2, $key[1], $matches);
						//print_r($matches);
						$matches[2] = strip_tags($matches[2]);
						$matches[3] = str_replace('&#8381;', '', $matches[3]);
						$matches[3] = preg_replace('~[^\d]+~', '' ,$matches[3]);
						price_change_detect('https:'.trim($matches[1]), trim(iconv('windows-1251', 'UTF-8', $matches[2])), trim($matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray['https:'.trim($matches[1])] = array(trim(iconv('windows-1251', 'UTF-8', $matches[2])), trim($matches[3]), date("d.m.y-H:i:s"), $request->options[10004],
						$request->options[10018],
						$request->url);		
						AngryCurl::add_debug_msg(iconv('windows-1251', 'UTF-8', $matches[2]).' | '.$matches[3]);
					}
				}	else { // Если Нет в наличии
					preg_match($regexpPrices5, $key[1], $matches);
					$matches[2] = strip_tags($matches[2]);
					price_change_detect('https:'.trim($matches[1]), trim(iconv('windows-1251', 'UTF-8', $matches[2])), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https:'.trim($matches[1])] = array(trim(iconv('windows-1251', 'UTF-8', $matches[2])), '0', date("d.m.y-H:i:s"), $request->options[10004],
						$request->options[10018],
						$request->url);		
					AngryCurl::add_debug_msg(iconv('windows-1251', 'UTF-8', $matches[2]).' | 0');
				}
			}
    } else {
    	AngryCurl::add_debug_msg('Регион не совпадает');
    	$bad_urls[] = $request->url;
    	if (round(microtime(1) - $time_start, 0) >= 180) { $bad_urls = array(); }
    }
  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $regexpPrices5;
	global $city;
	global $regRegion;
	global $matches;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {
    $bad_urls[] = $request->url;  	
		if (round(microtime(1) - $time_start, 0) >= 180) { $bad_urls = array(); }        
  } else {
		preg_match($regRegion, $response, $mReg); 
		$mReg[1] = trim(iconv('windows-1251', 'utf-8', $mReg[1]));
		AngryCurl::add_debug_msg($mReg[1].' | '.$city);

		if (1 == 1) {//$mReg[1] == $city
	   	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  	foreach ($matches2 as $key) {
	  		if (strripos($key[1], iconv('utf-8', 'windows-1251', 'В корзину')) !== false) { // Если в наличии
					if (strripos($key[1], 'marge_discount') !== false) {  // Если цена со скидкой %
						preg_match($regexpPrices4, $key[1], $matches);
						$matches[2] = strip_tags($matches[2]);
						$matches[3] = preg_replace('~[^\d]+~', '' ,$matches[3]);
						price_change_detect('https:'.trim($matches[1]), trim(iconv('windows-1251', 'UTF-8', $matches[2])), trim($matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray['https:'.trim($matches[1])] = array(trim(iconv('windows-1251', 'UTF-8', $matches[2])), trim($matches[3]), date("d.m.y-H:i:s"), $request->options[10004],
						$request->options[10018],
						$request->url);		
						AngryCurl::add_debug_msg(iconv('windows-1251', 'UTF-8', $matches[2]).' | '.$matches[3]);					
					} else {
						preg_match($regexpPrices2, $key[1], $matches);
						$matches[2] = strip_tags($matches[2]);
						$matches[3] = preg_replace('~[^\d]+~', '' ,$matches[3]);
						price_change_detect('https:'.trim($matches[1]), trim(iconv('windows-1251', 'UTF-8', $matches[2])), trim($matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray['https:'.trim($matches[1])] = array(trim(iconv('windows-1251', 'UTF-8', $matches[2])), trim($matches[3]), date("d.m.y-H:i:s"), $request->options[10004],
						$request->options[10018],
						$request->url);		
						AngryCurl::add_debug_msg(iconv('windows-1251', 'UTF-8', $matches[2]).' | '.$matches[3]);
					}
				}	else { // Если Нет в наличии
					preg_match($regexpPrices5, $key[1], $matches);
					$matches[2] = strip_tags($matches[2]);
					price_change_detect('https:'.trim($matches[1]), trim(iconv('windows-1251', 'UTF-8', $matches[2])), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https:'.trim($matches[1])] = array(trim(iconv('windows-1251', 'UTF-8', $matches[2])), '0', date("d.m.y-H:i:s"), $request->options[10004],
						$request->options[10018],
						$request->url);		
					AngryCurl::add_debug_msg(iconv('windows-1251', 'UTF-8', $matches[2]).' | 0');
				}
			}
		} else {
    	AngryCurl::add_debug_msg('Регион не совпадает');
    	$bad_urls[] = $request->url;
    	if (round(microtime(1) - $time_start, 0) >= 180) { $bad_urls = array(); }
		}
  }
}
