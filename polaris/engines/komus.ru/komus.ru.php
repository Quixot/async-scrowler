<?php
/**
 * komus.ru
 */
switch (EXTRA_PARAM) {
  case 'moscow':
    $region = 'CURRENT_REGION=77';//;region=0;area=77
    $city = 'Москва';
    break;
  case 'spb':
    $region = 'CURRENT_REGION=78';
    $city = 'Санкт-Петербург';
    break;
  case 'petrozavodsk':
    $region = 'CURRENT_REGION=47';
    $city = 'Республика Карелия';
    break; 
  case 'cheboksary':
    $region = 'CURRENT_REGION=75';
    $city = 'Чувашская Республ...';
    break;        
 	default:
 		die("Unknown region\n");  	 		
}

$urlOne = 'http://www.komus.ru/search?text=polaris';
$urlStart = 'https://www.komus.ru/search?listingMode=PLAIN&q=&text=polaris&sort=relevance&page=';

$options = array(
				CURLOPT_COOKIE => $region,
        //CURLOPT_COOKIEJAR       => COOKIEFILE,
        //CURLOPT_COOKIEFILE      => COOKIEFILE,
        CURLOPT_REFERER         => 'http://www.komus.ru/search?text=polaris',
        CURLOPT_AUTOREFERER     => TRUE,
        CURLOPT_FOLLOWLOCATION  => TRUE,
                        CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT        => 20,
    );
$regexpP1 = "~b-page-number(.+)</ul~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexpPrices1 = "~b-product-list__item js-item(.+)b-productParamsList--list.*</ul>~isU";
$regexpPrices2 = "~alt=\"(.+)\".*<a href=.*<a href=\"/katalog(.+)\".*cart-section__item--price.*>(.+)<~isU";
$regexpPrices3 = "~alt=\"(.+)\".*<a href=.*<a href=\"/katalog(.+)\"~isU";
$regexpPrices4 = "~alt=\"(.+)\".*class=\"b-price\">.*href=\"(.+)\".*cart-section__item--price.*>(.+)<~isU";
$regRegion = "~b-enterAccount__link b-enterAccount__link--arrow.*>(.+)<~isU";
$avail = 'Нет на складе';

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
		//print_r($already_scanned); 
	} else {
		$already_scanned = array();
	}
	$already_scanned = array();
	// Узнаем, сколько позиций в пагинации
	$AC->get('https://www.komus.ru/search?text=polaris', null, $options);
	$AC->get($urlStart.'1', null, $options);
	$AC->execute(2);

	while ($bad_urls) {
		  $AC->flush_requests();
		  foreach ($bad_urls as $urls) {
		    $AC->get($urls, NULL, $options);
		  }
		  unset($urls);
		  $bad_urls = array();    
		  $AC->execute(WINDOW_SIZE);
		}
	unset($urls);

	// Наименования товара и цены
	//$AC->flush_requests();
	//$AC->__set('callback','callback_two');	

	$is_any = 0;
	if ($qOfPaginationPages > 1) {
		$is_any = 0;
		for ($i = 1; $i < $qOfPaginationPages; $i++) {
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
		

		while ($bad_urls) {
		  $AC->flush_requests();
		  foreach ($bad_urls as $urls) {
		    $AC->get($urls, NULL, $options);
		  }
		  unset($urls);
		  $bad_urls = array();    
		  $AC->execute(WINDOW_SIZE);
		}
		unset($urls);
	}

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $city;
	global $itemsArray;
	global $errorsArray;
  global $qOfPaginationPages;
  global $bad_urls;
  global $time_start;
  global $avail;
  global $regRegion;

  //file_put_contents('/var/www/polaris/engines/komus.ru/content.txt', $response);

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);  

  if ($info['http_code'] !== 200) {
    $bad_urls[] = $request->url;
		if (round(microtime(1) - $time_start, 0) >= 120) { $bad_urls = array(); } 
  } else {
  	file_put_contents('/var/www/polaris/engines/komus.ru/content.txt', $response);

  	preg_match($regRegion, $response, $mReg);
  	//print_r($mReg);
  	$mReg[1] = trim($mReg[1]);
  	AngryCurl::add_debug_msg($mReg[1].' | '.$city);

  	if (stripos($mReg[1], $city) !== false) { //$mReg[1] == $city
			preg_match("~<h1 class=\"i-dib\">.*\((.+)\)~isU", $response, $matches);
			//print_r($matches);
			$qOfPaginationPages = ceil(trim($matches[1])/30);
			

		  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
		  //print_r($matches);
			foreach ($matches as $key) {
				if (strripos($key[0], $avail) === false) {
					if (strripos($key[0], 'b-productList__price--old') === false) {

						preg_match($regexpPrices2, $key[0], $matches2);
						//print_r($matches2);
						if (@$matches2[1] && @$matches2[2]) {
							if (stripos($matches2[2], '?') !== false) {
								$matches2[2] = substr($matches2[2], 0, stripos($matches2[2], '?'));
							}


							if (strripos($matches2[3], ',') !== false) {
				  			$matches2[3] = preg_replace('~[\D]+~', '' , substr($matches2[3], 0, strripos($matches2[3], ',')));
				  		} else {
				  			$matches2[3] = preg_replace('~[\D]+~', '' , $matches2[3]);
				  		}

							price_change_detect('http://www.'.ENGINE_CURR.'/katalog'.$matches2[2], trim($matches2[1]), $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
							$itemsArray['http://www.'.ENGINE_CURR.'/katalog'.$matches2[2]] = array(
								trim($matches2[1]), 
								$matches2[3],
								date("d.m.y-H:i:s"),
								$request->options[10004],
								$request->options[10018],
								$request->url
							);			
							AngryCurl::add_debug_msg(trim($matches2[1]).' | '.$matches2[3]);
						}	
					} else {
						preg_match($regexpPrices4, $key[0], $matches2);
						//print_r($matches2);
						if ($matches2[1] && $matches2[2]) {
							if (stripos($matches2[2], '?') !== false) {
								$matches2[2] = substr($matches2[2], 0, stripos($matches2[2], '?'));
							}

							if (strripos($matches2[3], ',') !== false) {
				  			$matches2[3] = preg_replace('~[\D]+~', '' , substr($matches2[3], 0, strripos($matches2[3], ',')));
				  		} else {
				  			$matches2[3] = preg_replace('~[\D]+~', '' , $matches2[3]);
				  		}

							price_change_detect('http://www.'.ENGINE_CURR.'/katalog'.$matches2[2], trim($matches2[1]), $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
							$itemsArray['http://www.'.ENGINE_CURR.'/katalog'.$matches2[2]] = array(
								trim($matches2[1]), 
								$matches2[3],
								date("d.m.y-H:i:s"),
								$request->options[10004],
								$request->options[10018],
								$request->url
							);			
							AngryCurl::add_debug_msg(trim($matches2[1]).' | '.$matches2[3]);
						}						
					}
				} else {
					preg_match($regexpPrices3, $key[0], $matches2);
					//print_r($matches2);
					if ($matches2[1] && $matches2[2]) {
						if (stripos($matches2[2], '?') !== false) {
							$matches2[2] = substr($matches2[2], 0, stripos($matches2[2], '?'));
						}						
						price_change_detect('http://www.'.ENGINE_CURR.'/katalog'.$matches2[2], trim($matches2[1]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray['http://www.'.ENGINE_CURR.'/katalog'.$matches2[2]] = array(
							trim($matches2[1]), 
							'0',
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url
						);			
						AngryCurl::add_debug_msg($matches2[1].' | 0');
					}	
				}	
			}
			file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
		} else {
	    $bad_urls[] = $request->url;
			if (round(microtime(1) - $time_start, 0) >= 60) { $bad_urls = array(); } 
			AngryCurl::add_debug_msg('Регион не совпал');
		}
  }
}

