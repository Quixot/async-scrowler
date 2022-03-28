<?php
/**
 * elex.ru
 */
switch (EXTRA_PARAM) {
  case 'moscow':
    $region = '143398';
    break;
 	default:
 		die("Unknown region\n");  	 		
}

$options = array(
								CURLOPT_COOKIEJAR       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        				CURLOPT_COOKIEFILE      => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        				CURLOPT_REFERER         => 'https://elex.ru/',
                CURLOPT_CONNECTTIMEOUT => 120,
                CURLOPT_TIMEOUT        => 120,
                CURLOPT_AUTOREFERER     => TRUE,
                CURLOPT_FOLLOWLOCATION  => TRUE,
                CURLOPT_HEADER => true, 
                CURLOPT_SSL_VERIFYPEER => 0	
	); 

$urlStart = 'https://'.ENGINE_CURR.'/search/index.php?city='.$region.'&q='.ENGINE_TYPE.'&PAGEN_3=';
$regexpP = "~class=\"pag_pages\"(.+)</div>~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexpPrices1 = "~class=\"product__item\"(.+)class=\"product__options\"~isU";
$regexpPrices2 = "~class=\"product__info\".*href=\"(.+)\".*span>(.+)<.*class=\"product__new\">(.+)<~isU";

/**
 * МЕГАЦИКЛ
 */
for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
	if ($iGlobalLoop > 0) {
		$AC->flush_requests();
		$AC->__set('callback','callback_one');
	}	
	// Узнаем, сколько позиций в пагинации
	$AC->get($urlStart.'1', null, $options);
	$AC->get($urlStart.'2', null, $options);
	$AC->get($urlStart.'3', null, $options);
	$AC->execute(3);

	$AC->flush_requests();
	$AC->__set('callback','callback_two');
	$AC->get('https://elex.ru/catalog/tekhnika-dlya-kukhni/kukhonnaya-tekhnika/elektrochayniki/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tekhnika-dlya-kukhni/kukhonnaya-tekhnika/elektrochayniki/?arrFilter_60_1123879612=Y&sort=&method=&view=&ajax=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&PAGEN_2=2&city='.$region);
	$AC->get('https://elex.ru/catalog/tekhnika-dlya-kukhni/kukhonnaya-tekhnika/blendery/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tekhnika-dlya-kukhni/kukhonnaya-tekhnika/kukhonnye-vesy/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tovary-dlya-doma/pylesosy02936/pylesosy-konteynernye/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/krasota-i-zdorove/ukladka-volos/elektroshchiptsy/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/krasota-i-zdorove/vesy-napolnye/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tekhnika-dlya-kukhni/kukhonnaya-tekhnika/multivarki02944/aksessuary-dlya-multivarok/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/interesno/gotovim-vkusno/pomoshchniki-na-kukhne/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tovary-dlya-doma/klimaticheskaya-tekhnika/obogrevatelnye-pribory/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tekhnika-dlya-kukhni/kukhonnaya-tekhnika/tostery-rostery/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tekhnika-dlya-kukhni/kukhonnaya-tekhnika/miksery/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tovary-dlya-doma/utyugi02934/utyugi/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tekhnika-dlya-kukhni/kukhonnaya-tekhnika/multivarki02944/multivarki/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tekhnika-dlya-kukhni/kukhonnaya-tekhnika/sokovyzhimalki/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/krasota-i-zdorove/vannochki-dlya-nog/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tovary-dlya-doma/bytovaya-tekhnika/ukhod-za-veshchami/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tekhnika-dlya-kukhni/prigotovlenie-kofe/kofemolki/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tovary-dlya-doma/bytovaya-tekhnika/posuda00881/aksessuary-dlya-kukhni00882/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tovary-dlya-doma/bytovaya-tekhnika/otparivateli/ruchnye-otparivateli/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tovary-dlya-doma/pylesosy02936/meshki-dlya-pylesosov/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/krasota-i-zdorove/ukladka-volos/feny/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/krasota-i-zdorove/ukladka-volos/multistaylery/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tekhnika-dlya-kukhni/posuda00879/antiprigarnaya-posuda/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tekhnika-dlya-kukhni/kukhonnaya-tekhnika/myasorubki02954/myasorubki/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tovary-dlya-doma/klimaticheskaya-tekhnika/sistemy-obrabotki-vozdukha/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tovary-dlya-doma/bytovaya-tekhnika/otparivateli/napolnye-otparivateli/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->get('https://elex.ru/catalog/tovary-dlya-doma/klimaticheskaya-tekhnika/ventilyatory/?arrFilter_60_1123879612=Y&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C&city='.$region);
	$AC->execute(WINDOW_SIZE);

	if ($qOfPaginationPages > 1) {
		//$qOfPaginationPages = 15; // КОСТЫЛЬ
		$AC->flush_requests();
		$AC->__set('callback','callback_two');				
		for ($i = 1; $i <= $qOfPaginationPages; $i++) {
		  $AC->get($urlStart.$i, null, $options);
		}
		$AC->execute(WINDOW_SIZE);
/*
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
*/
	}

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));

} // МЕГАЦИКЛ
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP;
  global $regexpP2;
	global $regexpPrices1;
	global $regexpPrices2;
	global $itemsArray;
	global $errorsArray;
  global $qOfPaginationPages;
  global $bad_urls;
  global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {            
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

	  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
	  //print_r($matches);
		foreach ($matches as $key) {
			preg_match($regexpPrices2, $key[1], $matches2);
			//print_r($matches2);
			if (strripos($key[1], 'Купить') !== false) {
				if ($matches2[1] && $matches2[2]) {
					price_change_detect('https://'.ENGINE_CURR.$matches2[1], trim($matches2[2]), preg_replace('~[^\d.]+~', '', $matches2[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://'.ENGINE_CURR.$matches2[1]] = array(
						trim($matches2[2]), 
						preg_replace('~[^\d.]+~', '', $matches2[3]),
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url
					);			
					AngryCurl::add_debug_msg($matches2[2].' | '.preg_replace('~[^\d.]+~', '', $matches2[3]));	
				} else {
					if ($matches2[1] && $matches2[2]) {
						price_change_detect('https://'.ENGINE_CURR.$matches2[1], trim($matches2[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray['https://'.ENGINE_CURR.$matches2[1]] = array(
							trim($matches2[2]), 
							'0',
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url
						);			
						AngryCurl::add_debug_msg($matches2[2].' | 0');						
					}
				}
			}
		}

  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices1;
	global $regexpPrices2;
	global $itemsArray;
	global $errorsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {
    
      $bad_urls[] = $info['url'];
    
		if (round(microtime(1) - $time_start, 0) >= 1200) { $bad_urls = array(); }       
  } else {
	  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
	  if (!$matches) {
	  	$bad_urls[] = $info['url'];
	  	if (round(microtime(1) - $time_start, 0) >= 1200) { $bad_urls = array(); }       
	  }
	  //print_r($matches);
		foreach ($matches as $key) {
			preg_match($regexpPrices2, $key[1], $matches2);
			//print_r($matches2);
			if (strripos($key[1], 'Купить') !== false) {
				if ($matches2[1] && $matches2[2]) {
					price_change_detect('https://'.ENGINE_CURR.$matches2[1], trim($matches2[2]), preg_replace('~[^\d.]+~', '', $matches2[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://'.ENGINE_CURR.$matches2[1]] = array(
						trim($matches2[2]), 
						preg_replace('~[^\d.]+~', '', $matches2[3]),
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url
					);			
					AngryCurl::add_debug_msg($matches2[2].' | '.preg_replace('~[^\d.]+~', '', $matches2[3]));	
				} else {
					if ($matches2[1] && $matches2[2]) {
						price_change_detect('https://'.ENGINE_CURR.$matches2[1], trim($matches2[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray['https://'.ENGINE_CURR.$matches2[1]] = array(
							trim($matches2[2]), 
							'0',
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url
						);			
						AngryCurl::add_debug_msg($matches2[2].' | 0');						
					}
				}
			}
		}
  }
}
