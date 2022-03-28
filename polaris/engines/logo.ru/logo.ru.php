<?php
/**
 * logo.ru
 */
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
 	default:
 		die("Unknown region\n"); 		
}

$options 			 = array(CURLOPT_COOKIE => 'city=' . $region);
$urlStart 		 = '?brands=' . ENGINE_TYPE;

$urlCatalog = "~class=\"sres_show\".*href=\"(.+)\"~isU";

$regexpPagin	 = "~class=\"pageNav\"(.+)</div>~isU";
$regexpPagin2  = "~<a.*>(.+)<~isU";
$regexpPrices  = "~<div.*class=\"itempr(.+)<div class=\"inCart~isU";
$regexpPrices2 = "~href=\"(.+)\".*title=\"(.+)\".*<span class=\"price\".*>(.+)</span>~isU";
//$directLinks = explode("\r\n", file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/links.txt'));
//array_walk($directLinks, 'trim_value');
//print_r($directLinks);die();

	// Загрузка отсканированных ссылок:
	foreach ($itemsArray as $key => $value) {
		$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
		//echo (time() - $date->format('U')).PHP_EOL; 
		if (time() - $date->format('U') <= 1800) {
			$already_scanned[] = $value[5];
		}
		
	}
	if ($already_scanned) {
		$already_scanned = array_unique($already_scanned);
		$already_scanned = array_values($already_scanned);
		//print_r($already_scanned); 
	} else {
		$already_scanned = array();
	}

	$AC->get('https://www.logo.ru/search-new?q=polaris', null, $options);
	$AC->execute(WINDOW_SIZE);

	$AC->flush_requests();
	$AC->__set('callback','callback_two');	

	$is_scan = 0;
	foreach ($directLinks as $url) {
		$qOfPaginationPages = 0;
		$bad_urls = array();
		if (!in_array('https://www.logo.ru'.$url, $already_scanned)) {
			echo 'сканирую адрес:'.PHP_EOL.'https://www.logo.ru'.$url.PHP_EOL;
			$AC->get('https://www.logo.ru'.$url, NULL, $options);
			$is_scan = 1;
		} else {
			echo 'уже сканировал:'.PHP_EOL.'https://www.logo.ru'.$url.PHP_EOL;
		}
		if ($is_scan) {
			$is_scan = 0;
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
		
		if ($qOfPaginationPages > 1) {
			for ($i=2; $i <= $qOfPaginationPages ; $i++) { 
				if (!in_array($url.'&page='.$i, $already_scanned)) {
					echo 'сканирую адрес:'.PHP_EOL.$url.'&page='.$i.PHP_EOL;
					if (stripos($url, '?') === false) {
						$AC->get($url.'?page='.$i, NULL, $options);
					} else {
						$AC->get($url.'&page='.$i, NULL, $options);
					}
					$is_scan = 1;
				} else {
					echo 'уже сканировал:'.PHP_EOL.$url.'&page='.$i.PHP_EOL;
				}
			}
			if ($is_scan) {
				$is_scan = 0;
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

	}

	



	// Сохраним массив в переменную
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';

/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $urlCatalog;
	global $qOfPaginationPages;
	global $directLinks;
	global $itemsArray;
	global $errorsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	


  if ($info['http_code'] !== 200) {
    $bad_urls[] = $request->url;
		if (round(microtime(1) - $time_start, 0) >= 300) { $bad_urls = array(); }    
  } else {
  		preg_match_all($urlCatalog, $response, $matches2); // Режем все карточки на странице
  		

  		$directLinks = $matches2[1];
  		print_r($directLinks);
		
  }
}


function callback_two($response, $info, $request) {
	global $regexpPagin;
	global $regexpPagin2;
	global $regexpPrices;
	global $regexpPrices2;
	global $urlCatalog;
	global $qOfPaginationPages;
	global $itemsArray;
	global $errorsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	


  if ($info['http_code'] !== 200) {
    $bad_urls[] = $request->url;
		if (round(microtime(1) - $time_start, 0) >= 300) { $bad_urls = array(); }    
  } else {

    	preg_match($regexpPagin, $response, $matches);
			//print_r($matches);
	    @preg_match_all($regexpPagin2, $matches[0], $matches2);
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

  		preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); // Режем все карточки на странице
	  	foreach ($matches2 as $key) {
				preg_match($regexpPrices2, $key[1], $matches); // Исследуем каждую карточку в отдельности
					if ($matches[1]) {
					$matches[2] = trim(strip_tags($matches[2]));
					if (strripos($matches[1], 'https://') === false ) {
						$matches[1] = 'https://www.logo.ru' . trim($matches[1]);
					}
					price_change_detect($matches[1], $matches[2], preg_replace('~[^\d]+~', '', $matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array(
						$matches[2], 
						preg_replace('~[^\d.]+~', '', $matches[3]),
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url
					);
					AngryCurl::add_debug_msg($matches[2].' | '.preg_replace('~[^\d]+~', '', $matches[3]));
				}
			}
		
  }
}
