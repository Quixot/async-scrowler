<?php
/**
 * citilink.ru
 */

switch (EXTRA_PARAM) {
  case 'moscow':  $region = 'msk_cl%3A'; break;
  case 'spb': $region = 'spb_cl%3A'; break;
  case 'chelyabinsk':  $region = 'chlb_cl%3A'; break;
  case 'kazan': $region = 'kzn_cl%3A'; break;
  case 'krasnodar': $region = 'krd_cl%3A'; break;
  case 'krasnoyarsk': $region = 'krasn_cl%3A'; break;
  case 'novgorod': $region = 'nnov_cl%3A'; break;
  case 'perm': $region = 'perm_cl%3A'; break;
  case 'rostov': $region = 'rnd_cl%3A'; break;
  case 'samara': $region = 'smr_cl%3A'; break;
  case 'volgograd': $region = 'vlg_cl%3A'; break;
  case 'voronezh': $region = 'vrzh_cl%3A'; break;
  case 'yekaterinburg': $region = 'ekat_cl%3A'; break;
  case 'pyatigorsk': $region = 'stav_cl%3Astavlira'; break;
  default:
    die("Unknown region\n");    
}
$options 			= array(CURLOPT_COOKIE => '_space=' . $region); 	// Подставляем coockie региона
$urlStart 		= 'http://www.citilink.ru/search/?text=' . ENGINE_TYPE;				// Первая часть адреса
$urlEnd				= '';							 				// Вторая часть адреа и поисковая строка
$regexpLinks = "~category-content__title.*href=\"(.+)\"~isU";
$regexpP1	= "~class=\"page_listing\"(.*)</div>~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexpPrices = "~product_data__gtm-js(.+)remove_from_cart~isU";
$regexpPrices2 ="~class=\"h3.*<a.*class=\"link_gtm-js.*href=\"(.+)\".*</span>.*</span>(.+)</a>.*class=\"price\"><ins class=\"num\">(.+)<~isU";
$regexpPrices3 ="~class=\"h3.*<a.*class=\"link_gtm-js.*href=\"(.+)\".*</span>.*</span>(.+)</a~isU";

$regexpPrices2 = "~product-card__name.*href=\"(.+)\".*>(.+)<.*class=\"num\">(.+)<~isU";
$regexpPrices3 = "~product-card__name.*href=\"(.+)\".*>(.+)<~isU";


/**
 * МЕГАЦИКЛ
 */
for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
	$AC->flush_requests();
	$AC->__set('callback','callback_one');
	
	// Соберём ссылки на разделы с карточками и сразу определим пагинацию
	$qOfPagesArray = array(); // Создадим массив и выберем больший элемент (он будет содержать более точные данные)
	$AC->get('http://www.citilink.ru/search/?text=' . ENGINE_TYPE, NULL, $options);
	$AC->get('http://www.citilink.ru/search/?text=' . ENGINE_TYPE, NULL, $options);
	$AC->execute(2);

	if ($qOfPaginationPages <= 0) { $qOfPaginationPages = 1; }
	echo "Pages: $qOfPaginationPages\n";

	$AC->flush_requests();
	$AC->__set('callback','callback_two');
	
	for ($i = 1; $i <= $qOfPaginationPages; $i++) { // Перебираем страницы пагинации и карточки товара в каждой
			if ($i == 1) {
				$AC->get($urlStart, NULL, $options);
        $AC->add_debug_msg($urlStart);
			} else {
				$AC->get($urlStart . '&p=' . $i, NULL, $options);
        $AC->add_debug_msg($urlStart . '&p=' . $i);
			}
			//$AC->add_debug_msg( $key . '&p=' . $i ); // Страницы с карточками товара, с учётом пагинации
	}
	$AC->execute(WINDOW_SIZE);

  echo "Здесь должны быть плохие адреса:\n\n\n";
  print_r($bad_urls);

	while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
    
	  $AC->flush_requests(); // Чистим массив запросов
	  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
	    $AC->get($urls, NULL, $options);
	    $AC->add_debug_msg("Bad URLs: $urls"); // LOG ⇒ Можем посмотреть сколько адресов при первом прогоне вернули пустоту        
	  }
	  unset($urls);

	  $bad_urls = array();       // Чистим массив URL-ов для следующего (возможного) цикла    
	  $AC->execute(WINDOW_SIZE); // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
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
	global $regexpLinks;
	global $directLinks;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]); 

	preg_match_all($regexpLinks, $response, $matches, PREG_SET_ORDER);
	print_r($matches);
	if ($matches) {
		foreach ($matches as $key => $value) {
			if (!in_array($value, $directLinks)) {
				$directLinks[] = $value;
			}
		}
	}
}

function callback_two($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;
  global $qOfPaginationPages;  
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
	global $errorsArray;
  global $time_start;
  global $bad_urls;

  if ($info['http_code'] !== 200) {            
    //if (stripos($info['url'], ENGINE_CURR)) {
    //  $bad_urls[] = $info['url'];
    //}
  } else {
		preg_match($regexpP1, $response, $matches);
		//print_r($matches);
		preg_match_all($regexpP2, $matches[1], $matches2);
		print_r($matches2);
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

  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
  	foreach ($matches2 as $key) {
  		if (strripos($key[1], 'disabled') === false) {
				preg_match($regexpPrices2, $key[1], $matches);
	      $matches[2] = trim($matches[2]);
				$vowels = array("\n", "\r", "\t", "\x0B", "&#8203;", "&nbsp;", "&emsp;", "&ensp;");
				$matches[2] = str_replace($vowels, ' ', $matches[2]);
				$matches[2] = str_replace(';', '', $matches[2]);
				if ($matches[1] && $matches[2]) {
					price_change_detect(trim($matches[1]), $matches[2], trim($matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(
						$matches[2], 
						trim($matches[3]),
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url
					);
					echo trim($matches[1]) . "\n";
				}
  		} else {
				preg_match($regexpPrices3, $key[1], $matches);
	      $matches[2] = trim($matches[2]);	
				$vowels = array("\n", "\r", "\t", "\x0B", "&#8203;", "&nbsp;", "&emsp;", "&ensp;");
				$matches[2] = str_replace($vowels, ' ', $matches[2]);
				$matches[2] = str_replace(';', '', $matches[2]);
				if ($matches[1] && $matches[2]) {
					price_change_detect(trim($matches[1]), $matches[2], '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(
						$matches[2], 
						'0',
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url
					);		
					echo trim($matches[1]) . " - Null\n";
				}
  		}
		} 

  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $errorsArray;
	global $itemsArray;
	global $bad_urls;
  global $time_start;

  echo 'callback two' . "\n";
  if ($info['http_code'] !== 200) {
    if (substr_count($info['url'], '?') > 1) {
      echo 'Адрес с несколькими ? : ' . $info['url'] . "\n";
      $temp = substr($info['url'], 0, strripos($info['url'], '?'));
      if (strripos($temp, '//search') !== false) {
        $temp = str_replace('//search', '/search', $temp);
      }     
      $bad_urls[] = $temp;
      echo 'Тут было два ? : ' . substr($info['url'], 0, strripos($info['url'], '?')) . "\n";      
    } else {
      if (strripos($info['url'], '//search') !== false) {
        $info['url'] = str_replace('//search', '/search', $info['url']);        
      }      
      $bad_urls[] = $info['url'];
      echo 'плохой адрес: ' . $info['url'] . "\n";
    }  
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 1200) { $bad_urls = array(); echo 'MICROTIME' . round(microtime(1) - $time_start, 0) . "\n";}      
  } else {	
  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
  	foreach ($matches2 as $key) {
  		if (strripos($key[1], 'disabled') === false) {
				preg_match($regexpPrices2, $key[1], $matches);
	      $matches[2] = trim($matches[2]);
				$vowels = array("\n", "\r", "\t", "\x0B", "&#8203;", "&nbsp;", "&emsp;", "&ensp;");
				$matches[2] = str_replace($vowels, ' ', $matches[2]);
				$matches[2] = str_replace(';', '', $matches[2]);
				if ($matches[1] && $matches[2]) {
					price_change_detect(trim($matches[1]), $matches[2], trim($matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(
						$matches[2], 
						trim($matches[3]),
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url
					);		
					echo trim($matches[1]) . "\n";
				}
  		} else {
				preg_match($regexpPrices3, $key[1], $matches);
	      $matches[2] = trim($matches[2]);	
				$vowels = array("\n", "\r", "\t", "\x0B", "&#8203;", "&nbsp;", "&emsp;", "&ensp;");
				$matches[2] = str_replace($vowels, ' ', $matches[2]);
				$matches[2] = str_replace(';', '', $matches[2]);
				if ($matches[1] && $matches[2]) {
					price_change_detect(trim($matches[1]), $matches[2], '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(
						$matches[2], 
						'0',
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url
					);		
					echo trim($matches[1]) . " - Null\n";
				}
  		}
		} 	
  }
}
