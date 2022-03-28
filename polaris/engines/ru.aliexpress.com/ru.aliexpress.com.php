<?php
/**
 * ru.aliexpress.com
 */
switch (EXTRA_PARAM) {
  case 'moscow':
    break;
 	default:
 		die("Unknown region\n"); 		
}

$itemsArray = array();
$urlStart 		 = 'https://tmall.aliexpress.com/wholesale?catId=0&initiative_id=SB_20180601061919&SearchText=polaris';
$urlEnd 			 = '.html?SearchText='.ENGINE_TYPE.'&origin=y&SortType=bestmatch_sort';
$urlNew 			 = "https://tmall.aliexpress.com/wholesale?site=rus&g=y&brandValueIds=201771818&SearchText=polaris&isCompetitiveProducts=y&page=";
$regexpP 			 = "~class=\"ui-pagination-navi(.+)</div>~isU";	// Пагинация
$regexpP2 		 = "~<a.*>(.+)<~isU"; // Пагинация
$reg1  				 = "~<div class=\"item\">(.+)</li>~isU";
$reg2  				 = "~class=\"history-item product.*href=\"(.+)\".*>(.+)</a.*itemprop=\"price\">(.+)<~isU";
$reg3  				 = "~class=\"history-item product.*href=\"(.+)\".*>(.+)</a~isU~isU";

file_put_contents('/var/www/polaris/engines/ru.aliexpress.com/cookies.txt', '');

$options = array(
        CURLOPT_COOKIEJAR       => '/var/www/polaris/engines/ru.aliexpress.com/cookies.txt',
        CURLOPT_COOKIEFILE      => '/var/www/polaris/engines/ru.aliexpress.com/cookies.txt',
        CURLOPT_REFERER         => 'http://ru.aliexpress.com',
        CURLOPT_AUTOREFERER     => TRUE,
        CURLOPT_FOLLOWLOCATION  => TRUE
    );


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

	



	$AC->get('https://tmall.ru/wholesale?site=rus&page=1&SearchText=polaris&isCompetitiveProducts=y&g=y', null, $options);
	$AC->get('https://tmall.ru/wholesale?site=rus&page=3&SearchText=polaris&isCompetitiveProducts=y&g=y', null, $options);
	$AC->get('https://tmall.ru/wholesale?site=rus&page=4&SearchText=polaris&isCompetitiveProducts=y&g=y', null, $options);
	$AC->get('https://tmall.ru/wholesale?site=rus&page=5&SearchText=polaris&isCompetitiveProducts=y&g=y', null, $options);
	$AC->get('https://tmall.ru/wholesale?site=rus&page=6&SearchText=polaris&isCompetitiveProducts=y&g=y', null, $options);
	$AC->get('https://tmall.ru/wholesale?site=rus&page=7&SearchText=polaris&isCompetitiveProducts=y&g=y', null, $options);
	$AC->get('https://tmall.ru/wholesale?site=rus&page=8&SearchText=polaris&isCompetitiveProducts=y&g=y', null, $options);
	$AC->get('https://tmall.ru/wholesale?site=rus&page=9&SearchText=polaris&isCompetitiveProducts=y&g=y', null, $options);
	
/*
	$AC->get('https://aliexpress.ru/store/5020201/search/1.html', null, $options);
	$AC->get('https://aliexpress.ru/store/5020201/search/2.html', null, $options);
	$AC->get('https://aliexpress.ru/store/5020201/search/3.html', null, $options);
	$AC->get('https://aliexpress.ru/store/5020201/search/4.html', null, $options);
	$AC->get('https://aliexpress.ru/store/5020201/search/5.html', null, $options);
	$AC->get('https://aliexpress.ru/store/5020201/search/6.html', null, $options);
	$AC->get('https://aliexpress.ru/store/5020201/search/7.html', null, $options);
	$AC->get('https://aliexpress.ru/store/5020201/search/8.html', null, $options);
	$AC->get('https://aliexpress.ru/store/5020201/search/9.html', null, $options);
	$AC->get('https://polaris.aliexpress.ru/store/5020201', null, $options);


$AC->get('https://promotion.aliexpress.ru/wow/gcp/aer/channel/aer/tmall_localization/7pcZWCh8tW?wh_weex=true&_immersiveMode=true&wx_navbar_hidden=true&wx_navbar_transparent=true&ignoreNavigationBar=true&wx_statusbar_hidden=true', null, $options);
$AC->get('https://aliexpress.ru/brands/polaris?trafficChannel=main&d=y&CatId=0&SearchText=polaris&ltype=wholesale&pageType=brand&SortType=default&page=2', null, $options);
$AC->get('https://aliexpress.ru/brands/polaris?trafficChannel=main&d=y&CatId=0&SearchText=polaris&ltype=wholesale&pageType=brand&SortType=default&page=3', null, $options);
$AC->get('https://aliexpress.ru/brands/polaris?trafficChannel=main&d=y&CatId=0&SearchText=polaris&ltype=wholesale&pageType=brand&SortType=default&page=4', null, $options);
$AC->get('https://aliexpress.ru/brands/polaris?trafficChannel=main&d=y&CatId=0&SearchText=polaris&ltype=wholesale&pageType=brand&SortType=default&page=5', null, $options);
$AC->get('https://aliexpress.ru/brands/polaris?trafficChannel=main&d=y&CatId=0&SearchText=polaris&ltype=wholesale&pageType=brand&SortType=default&page=6', null, $options);
$AC->get('https://aliexpress.ru/brands/polaris?trafficChannel=main&d=y&CatId=0&SearchText=polaris&ltype=wholesale&pageType=brand&SortType=default&page=7', null, $options);
$AC->get('https://aliexpress.ru/brands/polaris?trafficChannel=main&d=y&CatId=0&SearchText=polaris&ltype=wholesale&pageType=brand&SortType=default&page=8', null, $options);*/

	$AC->execute(WINDOW_SIZE);

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

	// Сохраним массив в переменную
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP;
  global $regexpP2;
  global $qOfPaginationPages;
  global $bad_urls;
	global $reg1;
	global $reg2;
	global $reg3;
	global $itemsArray;
	global $errorsArray;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url;
  } else {
		preg_match($regexpP, $response, $matches);
		//print_r($matches);
		preg_match_all($regexpP2, $matches[0], $matches2);
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

  	preg_match_all($reg1, $response, $matches2, PREG_SET_ORDER); // Режем все карточки на странице
  	//print_r($matches2);
  	foreach ($matches2 as $key) {
			if (stripos($key[0], 'Polaris Official Store') !== false) {

			
				preg_match($reg2, $key[1], $matches); // Исследуем каждую карточку в отдельности
				//print_r($matches);

				if (@$matches[3]) { // Если есть "новый прайс"
					//$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
					if (stripos($matches[1], '?') !== false) {
						$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
					}			
					$matches[1] = 'https://tmall.aliexpress.com'.trim($matches[1]);	

					$matches[2] = strip_tags(trim($matches[2]));

					$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
					$matches[3] = substr($matches[3], 0, -2);

				
					//$matches = parser_clean($matches, 2, 3);
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3],
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);					
				} else {
					preg_match($reg3, $matches[1], $matches);
					$matches[2] = strip_tags(trim($matches[2]));
					if (stripos($matches[1], '?') !== false) {
						$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
					}			
					$matches[1] = 'https://tmall.aliexpress.com'.trim($matches[1]);	

					if ($matches[1]) {
						price_change_detect($matches[1], $matches[2], '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], '0',
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | 0');
					}
				}
			} else {
				AngryCurl::add_debug_msg("Не тот контрагент!");
			}
		}

  }
}

function callback_two($response, $info, $request) {
	global $reg1;
	global $reg2;
	global $reg3;
	global $itemsArray;
	global $errorsArray;
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
  	preg_match_all($reg1, $response, $matches2, PREG_SET_ORDER); // Режем все карточки на странице
  	//print_r($matches2);
  	foreach ($matches2 as $key) {
  		if (stripos($key[0], 'Polaris Official Store') !== false) {
				preg_match($reg2, $key[1], $matches); // Исследуем каждую карточку в отдельности
				//print_r($matches);
				if (stripos($matches[1], '?') !== false) {
					$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
				}		

				$matches[2] = strip_tags(trim($matches[2]));
				$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
				$matches[3] = substr($matches[3], 0, -2);

				$matches[1] = 'https://tmall.aliexpress.com'.trim($matches[1]);	
				if (@$matches[3]) { // Если есть "новый прайс"
					$matches = parser_clean($matches, 2, 3);
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3],
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);	
				} else {
					preg_match($reg3, $matches[1], $matches); // Нет в наличии				
					if ($matches[1]) {
						price_change_detect($matches[1], $matches[2], '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], '0',
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | 0');			
					}
				}
			}
		}							
  }
}
