<?php
/**
 * allo.ua
 */
switch (EXTRA_PARAM) {
	case 'kiev': 		$city = 'Киев'; 		$region = '4'; 	break;
	case 'kharkov': $city = 'Харьков'; 	$region = '13'; break;
	case 'dnepr': 	$city = 'Днепр'; 		$region = '1'; 	break;
	case 'odessa': 	$city = 'Одесса'; 	$region = '10'; break;
	case 'lvov': 		$city = 'Львов'; 		$region = '8'; 	break;
 	default:
 		die("Unknown region\n"); 		
}	

$regexpP 			 = "~class=\"pagination\"(.+)</ul>~isU"; 	// Пагинация
$regexpP2  		 = "~<a.*>(.+)<~isU";  
$regexpPrices  = "~<div data-product-id=(.+)<dt>.*</div></div></div>~isU"; 
$regexpPrices2 = "~product-card__content.*href=\"(.+)\".*>(.+)</a.*class=\"sum\">(.+)<~isU"; // Режем карточки товара
$regexpPrices3 = "~product-card__content.*href=\"(.+)\".*>(.+)</a.*class=\"sum\".*class=\"sum\">(.+)<~isU";
$regexpPrices4 = "~product-card__content.*href=\"(.+)\".*>(.+)</a~isU";

$options = array(
								CURLOPT_COOKIE => 'city_id='.$region.';city_id_geo='.$region,
								//CURLOPT_COOKIEJAR       => '/var/www/polaris.ua/cookies',
        				//CURLOPT_COOKIEFILE      => '/var/www/polaris.ua/cookies',
                CURLOPT_CONNECTTIMEOUT 	=> 20,
                CURLOPT_TIMEOUT        	=> 20,
                CURLOPT_AUTOREFERER     => true,
                CURLOPT_FOLLOWLOCATION  => true,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_HEADER 					=> true, 
                CURLOPT_SSL_VERIFYPEER 	=> 0,
                CURLOPT_SSL_VERIFYHOST 	=> 0,
);

$already_scanned = array();
$already_scanned = scanned_links($itemsArray);
//$already_scanned = array();
print_r($already_scanned);
//die();

/**
 * Получаем ссылки на категории
 */
	$AC->flush_requests();
	$AC->__set('callback','callback_two');

$links = array(	
	'https://allo.ua/ru/feny/proizvoditel-polaris/',
	'https://allo.ua/ru/elektrochajniki/proizvoditel-polaris/',
	'https://allo.ua/ru/ochistiteli-vozduha/proizvoditel-polaris/',
	'https://allo.ua/ru/products/pylesosy/proizvoditel-polaris/',
	'https://allo.ua/ru/uvlazhniteli-vozduha/proizvoditel-polaris/',
	'https://allo.ua/ru/tostery/proizvoditel-polaris/',
	'https://allo.ua/ru/mul-tivarki/proizvoditel-polaris/',
	'https://allo.ua/ru/sushki-dlja-fruktov-i-ovoschej/proizvoditel-polaris/',
	'https://allo.ua/ru/napol-nye-vesy/proizvoditel-polaris/',
	'https://allo.ua/ru/products/utugi/proizvoditel-polaris/',
	'https://allo.ua/ru/products/blendery/proizvoditel-polaris/',
	'https://allo.ua/ru/stajlery/proizvoditel-polaris/',
	'https://allo.ua/ru/massazhery/proizvoditel-polaris/',
	'https://allo.ua/ru/mashinki-strizhki/proizvoditel-polaris/',
	'https://allo.ua/ru/products/masorubki/proizvoditel-polaris/',
	'https://allo.ua/ru/skovorody/proizvoditel-polaris/',
	'https://allo.ua/ru/kosmeticheskie-prinadlezhnosti/proizvoditel-polaris/',
	'https://allo.ua/ru/kastrjuli/proizvoditel-polaris/',
	'https://allo.ua/ru/kovshi/proizvoditel-polaris/',
	'https://allo.ua/ru/prinadlezhnosti-dlja-sousov-i-specij/proizvoditel-polaris/',
	'https://allo.ua/ru/kuhonnye-nozhi/proizvoditel-polaris/',
	'https://allo.ua/ru/aksessuary-k-bt/proizvoditel-polaris/',
	'https://allo.ua/ru/aksessuary-k-mjasorubkam/proizvoditel-polaris/',
	'https://allo.ua/ru/nabory-dlja-strizhki/proizvoditel-polaris/',
	'https://allo.ua/ru/miksery/proizvoditel-polaris/',
);

$is_any = 0;
foreach ($links as $url) {
	if (!in_array($url, $already_scanned)) {
		echo 'сканирую адрес:'.PHP_EOL.$url.$i.PHP_EOL;
		$AC->get($url, null, $options);
		$is_any = 1;
	} else {
		echo 'уже сканировал:'.PHP_EOL.$url.PHP_EOL;
	}
}
if ($is_any) {
	$AC->execute(WINDOW_SIZE);
}

while ($bad_urls) {
	$AC->flush_requests();
	foreach ($bad_urls as $urls) {
	  $AC->get($urls, null, $options);
	}
	$bad_urls = array();
	$AC->execute(WINDOW_SIZE);
}

//if (!$proper_links) die('Нет ссылок для сканирования');

/*
foreach ($proper_links as $url) {
	$AC->flush_requests();
	$AC->__set('callback','callback_two');

	$qOfPaginationPages = 0;

	$AC->get($url, null, $options);
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {
		$AC->flush_requests();
		foreach ($bad_urls as $urls) {
		  $AC->get($urls, null, $options);
		}
		$bad_urls = array();
		$AC->execute(WINDOW_SIZE);
	}

	if ($qOfPaginationPages > 1) {
		$qOfPaginationPages = 4; // Костыль !!! Уменьшает нагрузку, уберает страницы без наличия

		$AC->flush_requests();
		$AC->__set('callback','callback_two');

		$is_scan = 0;
		for ($i = 2; $i <= $qOfPaginationPages; $i++) {
			if (!in_array($url.'&p='.$i, $already_scanned)) {
				AngryCurl::add_debug_msg('сканирую адрес: '.$url.'&p='.$i);
		  	$AC->get($url.'&p='.$i, null, $options);
		  	$is_scan = 1;
		  } else {
				AngryCurl::add_debug_msg('уже сканировал: '.$url.'&p='.$i);
			}			
		}
		if ($is_scan) {
			$AC->execute(WINDOW_SIZE);
		}

		while ($bad_urls) {
			$AC->flush_requests();
			foreach ($bad_urls as $urls) {
			  $AC->get($urls, null, $options);
			}
			$bad_urls = array();
			$AC->execute(WINDOW_SIZE);
		}
	}
}
*/
file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';

/** 
 * Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $city;
  global $bad_urls;
	global $time_start;
	global $proper_links;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url; 	
		if (round(microtime(1) - $time_start, 0) >= 700) $bad_urls = array();
  } else {
		preg_match("~class=\"city-name.*>(.+)<~isU", $response, $region);
		AngryCurl::add_debug_msg('request  region: '.$city);
		AngryCurl::add_debug_msg('response region: '.trim($region[1]));  	

  	preg_match_all("~category-filter-hover.*href=\"(.+)\".*return false.*>(.+)<~isU", $response, $matches, PREG_SET_ORDER);
  	//file_put_contents('/var/www/polaris.ua/engines/allo.ua/1.txt', print_r($matches, 1));
		$deny_links_array = array(
				'Смартфони та телефони',
				'Навушники і акустика',
				'Планшети, ноутбуки та ПК',
				'Туризм та риболовля',
				'Сантехніка та ремонт',
				'Товари для дітей',
				'Автотовари',
				'Смартфоны и телефоны',
				'Наушники и акустика',
				'Планшеты, ноутбуки и ПК',
				'Туризм и рыбалка',
				'Сантехника и ремонт',
				'Детские товары',
				'Автотовары',
			);

		foreach ($matches as $key => $value) {
			if (!in_array(trim($value[2]), $deny_links_array)) {
				$proper_links[] = 'https:'.trim($value[1]);
			}
		}

  }	 
}


function callback_two($response, $info, $request) {
  global $regexpP;
  global $regexpP2;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $itemsArray;  
  global $qOfPaginationPages;
  global $bad_urls;
	global $time_start;
	global $city;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]); 

	//echo $response;

  if ($info['http_code'] !== 200 || strlen($response) < 6000) {   
  	AngryCurl::add_debug_msg('bad request: '.strlen($response));         
    $bad_urls[] = $request->url; 	
		if (round(microtime(1) - $time_start, 0) >= 180) { $bad_urls = array(); } 
  } else {
		preg_match("~data-geo-label=\"(.+)\"~isU", $response, $region);
		AngryCurl::add_debug_msg('request  region: '.$city);
		AngryCurl::add_debug_msg('response region: '.trim($region[1])); 

		preg_match($regexpP, $response, $matches);
		preg_match_all($regexpP2, $matches[0], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			if (is_numeric($value)) $temparrpage[] = $value;
		}
		if (@max($temparrpage) > $qOfPaginationPages) $qOfPaginationPages = @max($temparrpage);	

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //



	  //print_r($matches2);
	  foreach ($matches2 as $key) {
	  	if (strripos(mb_strtolower($key[0]), 'уценк') === false && strripos(mb_strtolower($key[0]), 'уцінк') === false) {
	  		if (strripos($key[0], 'v-price-box__old') !== false && stripos($key[0], 'buy-button--default') !== false) {
					preg_match($regexpPrices3, $key[0], $matches);
					//print_r($matches);
					$matches[1] = trim($matches[1]);
					if (stripos($matches[1], 'http') === false) $matches[1] = 'https:'.$matches[1];
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
					$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);

					if (@$matches[1] && $matches[2]) {
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}						
	  		} else {
					preg_match($regexpPrices2, $key[0], $matches);
					//print_r($matches);
					if (@$matches[1] && $matches[2] && stripos($key[0], 'buy-button--default') !== false) {
						$matches[1] = trim($matches[1]);
						if (stripos($matches[1], 'http') === false) $matches[1] = 'https:'.$matches[1];
						$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
						$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
						
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}	else {
						preg_match($regexpPrices4, $key[0], $matches);
						if (@$matches[1] && $matches[2]) {
							$matches[1] = trim($matches[1]);
							if (stripos($matches[1], 'http') === false) $matches[1] = 'https:'.$matches[1];
							$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
							$matches[3] = '0';

							price_change_detect(trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
							$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
							AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
						}
					}				
	  		}	
	  	} // Уценка
	  }
	  file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
  }
}
