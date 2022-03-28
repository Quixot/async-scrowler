<?php
/**
 * globus.ru
 */

	$urlStart = 'https://online.globus.ru/search/?q=polaris&PAGEN_1=';
	$regexpP1	= "~r-pagination(.+)</div>~isU";
	$regexpP2 = "~<a.*>(.+)<~isU";
	$regexpPrices = "~js-catalog-section__item(.+)ig-cart~isU";
	$regexpPrices2 = "~href=\"(.+)\".*class=\"catalog-section__item__title\">(.+)<.*class=\"item-price__rub\">(.+)<~isU";

	$regexpCat = "~<a href=.*class=\"pim-list__item\">(.+)</a>~isU";
	$regexpCat2 = "~href=\"(.+)\".*data-full-text.*>(.+)<.*item-price-actual-main\">(.+)<~isU";

	$regexpRegion = "~ig ig-pin.*<span>(.+)<~isU";
	$regexpRegion2 = "~class=\"cur-city\".*<a.*>(.+)<~isU";

	
	$region = 'globus_hyper_id=73';
	$options 			 = array(
								CURLOPT_COOKIE 					=> $region,
								CURLOPT_COOKIEJAR 			=> '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        				//CURLOPT_COOKIEFILE    => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
                CURLOPT_CONNECTTIMEOUT  => 30,
                CURLOPT_TIMEOUT         => 240,
                CURLOPT_AUTOREFERER     => TRUE,
                CURLOPT_FOLLOWLOCATION  => TRUE,
                CURLOPT_HEADER 					=> true, 
                CURLOPT_SSL_VERIFYPEER 	=> 0,
                CURLOPT_SSL_VERIFYHOST 	=> 0
	);


	$qOfPagesArray = array();
	$AC->get($urlStart.'1', null, $options);
	$AC->get($urlStart.'2', null, $options);
	$AC->get('https://online.globus.ru/catalog/dom-khobbi-tekhnika/bytovaya-i-tsifrovaya-tekhnika/ukhod-za-odezhdoy-i-domom/polaris/', null, $options);
	$AC->get('https://online.globus.ru/catalog/dom-khobbi-tekhnika/tovary-dlya-kukhni/polaris/');
	$AC->get('https://online.globus.ru/catalog/dom-khobbi-tekhnika/bytovaya-i-tsifrovaya-tekhnika/tekhnika-dlya-kukhni/polaris/');
	$AC->get('https://online.globus.ru/catalog/dom-khobbi-tekhnika/bytovaya-i-tsifrovaya-tekhnika/tekhnika-dlya-ukhoda-za-soboy/polaris/');
	
	
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {
	  foreach ($bad_urls as $url) {
	    $AC->get($url, null, $options);     
	  }
	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}

	echo 'К-во страниц:'.$qOfPaginationPages.PHP_EOL;

	if ($qOfPaginationPages > 2) {
		//$AC->flush_requests();
		//$AC->__set('callback', 'callback_two');
		for ($i = 3; $i <= $qOfPaginationPages; $i++) {
		  
			  $AC->get($urlStart.$i, null, $options);
		 
		}
		$AC->execute(WINDOW_SIZE);

		while ($bad_urls) {
			if (round(microtime(1) - $time_start, 0) >= 180) break;
		  $AC->flush_requests();
		  foreach ($bad_urls as $url) {
		    $AC->get($url, null, $options);     
		  }
		  $bad_urls = array();
		  $AC->execute(WINDOW_SIZE);
		}
	}

	$AC->flush_requests();
	$AC->__set('callback', 'callback_two');

	$qOfPagesArray = array();
	//$AC->get('https://www.globus.ru/catalog/dom-khobbi-tekhnika/bytovaya-i-tsifrovaya-tekhnika/tekhnika-dlya-kukhni/?page=1&atr_pt_brand%5B%5D=Polaris&count=36', null, $options);
	//$AC->get('https://www.globus.ru/catalog/dom-khobbi-tekhnika/bytovaya-i-tsifrovaya-tekhnika/tekhnika-dlya-ukhoda-za-soboy/?page=1&atr_pt_brand%5B%5D=Polaris&count=36', null, $options);
	//$AC->get('https://www.globus.ru/catalog/dom-khobbi-tekhnika/bytovaya-i-tsifrovaya-tekhnika/ukhod-za-odezhdoy-i-domom/?page=1&atr_pt_brand%5B%5D=Polaris&count=36', null, $options);
	//$AC->get('https://www.globus.ru/catalog/dom-khobbi-tekhnika/bytovaya-i-tsifrovaya-tekhnika/prochaya-tekhnika/?page=1&atr_pt_brand%5B%5D=Polaris', null, $options);
	//$AC->get('https://www.globus.ru/catalog/dom-khobbi-tekhnika/tovary-dlya-kukhni/?page=1&atr_pt_brand%5B%5D=Polaris', null, $options);
	//$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {
	  foreach ($bad_urls as $url) {
	    $AC->get($url, null, $options);     
	  }
	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}	

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $regexpP1;
	global $regexpP2;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;

	global $regexpCat;
	global $regexpCat2;

	global $regexpRegion;
	global $time_start;
	global $itemsArray;

	//file_put_contents('/var/www/polaris/engines/globus.ru/content.txt', $response);
	//die();

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200 || strlen($response) < 500) {
  	if ($info['http_code'] !== 404) {
    	$bad_urls[] = $request->url;
    	if (round(microtime(1) - $time_start, 0) >= 340) $bad_urls=array();
  	}
  } else {
  	preg_match($regexpRegion, $response, $matchesReg);
  	AngryCurl::add_debug_msg(trim($matchesReg[1]));

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

  	preg_match_all($regexpPrices, $response, $matches_items, PREG_SET_ORDER);
  	//print_r($matches_items);
  	foreach ($matches_items as $key) {
	  	//if (strripos($key[1], 'В корзину') !== false) {
	  		preg_match($regexpPrices2, $key[1], $matches);
	  		//print_r($matches);
	  		if ($matches[1] && $matches[2]) {
		  		$matches[1] = 'https://online.globus.ru'.trim($matches[1]);
		  		$matches[2] = trim($matches[2]);
		  		$matches[3] = preg_replace('~[^\d]+~', '' , $matches[3]);
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);	
	  		}			
			//}
		}
  }
}


function callback_two($response, $info, $request) {
	global $regexpP1;
	global $regexpP2;
  global $qOfPaginationPages;
  global $bad_urls;

	global $regexpCat;
	global $regexpCat2;

	global $regexpRegion2;
	global $time_start;
	global $itemsArray;

	//file_put_contents('/var/www/polaris/engines/globus.ru/'.time(), $response);

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200 || strlen($response) < 500) {      
  	if ($info['http_code'] !== 404) {      
	    $bad_urls[] = $request->url;
	    if (round(microtime(1) - $time_start, 0) >= 540) $bad_urls=array();
	  }
  } else {
  	preg_match($regexpRegion2, $response, $matchesReg);
  	AngryCurl::add_debug_msg(trim($matchesReg[1]));
/*
		preg_match($regexpP1, $response, $matches);
		//print_r($matches);
		preg_match_all($regexpP2, $matches[1], $matches2);
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
*/
  	preg_match_all($regexpCat, $response, $matches_items, PREG_SET_ORDER);
  	//print_r($matches_items);die();
  	foreach ($matches_items as $key) {
	  	//if (strripos($key[1], 'В корзину') !== false) {
	  		preg_match($regexpCat2, $key[0], $matches);
	  		//print_r($matches);
	  		if ($matches[1] && $matches[2]) {
		  		$matches[1] = 'https://online.globus.ru'.trim($matches[1]);
		  		$matches[2] = trim($matches[2]);
		  		$matches[3] = preg_replace('~[^\d]+~', '' , $matches[3]);
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);	
	  		}			
			//}
		}
  }
}
