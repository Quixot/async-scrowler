<?php
/**
 * metro-cc.ru
 */
	switch (EXTRA_PARAM) {
		case 'moscow': $region = 'msk.'; break;
		case 'spb': $region = 'spb.'; break;
		case 'arhangelsk': $region = 'arh.'; break;
		case 'chelyabinsk': $region = 'chel.'; break;
		case 'kazan': $region = 'kazan.'; break;
		case 'krasnodar': $region = 'krd.'; break;
		case 'krasnoyarsk': $region = 'krsk.'; break;
		case 'novgorod': $region = 'nn.'; break;
		case 'novosibirsk': $region = 'nsk.'; break;
		case 'omsk': $region = 'omsk.'; break;
		case 'perm': $region = 'perm.'; break;
		case 'pyatigorsk': $region = 'kmv.'; break;
		case 'rostov': $region = 'rostov.'; break;
		case 'samara': $region = 'samara.'; break;
		case 'ufa': $region = 'ufa.'; break;
		case 'volgograd': $region = 'volgograd.'; break;
		case 'voronezh': $region = 'voronezh.'; break;
		case 'yekaterinburg': $region = 'ekat.'; break;		
	 	default:
 		die("Unknown region\n");  	 		
	}	

	$urlStart = 'https://'.$region.'metro-cc.ru/search?filter_name=polaris&sorting=0&limit=72&in_stock=0&virtual_stock=0';
	$regexpP1	= "~<nav class=\"nav_pager(.+)</ul>~isU";
	$regexpP2 = "~<span>(.+)<~isU";
	$regexpPrices  = "~class=\"catalog-i_w(.+)bottom-line -->~isU";
	$regexpPrices2 = "~class=\"catalog-i_link\" href=\"(.+)\".*class=\"title\">(.+)<.*class=\"int\">(.+)<~isU";
	$regP2 = "~href=\"(.+)\".*>(.+)<.*class=\"catalog-item_price-.*current\">(.+)</~isU";
	//$regP3 = "~href=\"(.+)\".*>(.+)<.*class=\"catalog-item_price-lvl_current\">(.+)</~isU";
	
	$regexpPrices2 = "~class=\"catalog-i_link\" href=\"(.+)\"~isU";

	$regP = "~class=\"catalog-item\"(.+)<!----></div></div></div></div>~isU";
	$regP = "~class=\"catalog-item(.+)<!----></div></div>~isU";
	

	$region_name = '~header__tradecenter_head-address.*span>(.+)<~isU';

	$options 			 = array(
								//CURLOPT_COOKIE => $cook,
								CURLOPT_COOKIEJAR       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        				//CURLOPT_COOKIEFILE      => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
                CURLOPT_CONNECTTIMEOUT => 60,
                CURLOPT_TIMEOUT        => 60,
                CURLOPT_AUTOREFERER     => TRUE,
                CURLOPT_FOLLOWLOCATION  => TRUE,
                CURLOPT_HEADER => 0, 
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0
	);

	$qOfPagesArray = array();

	$AC->get('https://'.$region.'metro-cc.ru/category/elektronika-tekhnika/krupnaya?manufacturer_id%5B0%5D=1690&page=1', null, $options);

	$AC->get('https://'.$region.'metro-cc.ru/category/elektronika-tekhnika/melkaya/elektrochajniki?manufacturer_id%5B0%5D=1690', null, $options);
	$AC->get('https://'.$region.'metro-cc.ru/category/elektronika-tekhnika/melkaya?manufacturer_id%5B0%5D=1690&page=1', null, $options);
	
	$AC->get('https://'.$region.'metro-cc.ru/category/elektronika-tekhnika/klimaticheskaya-tekhnika?manufacturer_id%5B0%5D=1690&page=1', null, $options);
	
	$AC->get('https://'.$region.'metro-cc.ru/category/posuda/prigotovlenie-pishchi?manufacturer_id%5B0%5D=1690', null, $options);
	$AC->get('https://'.$region.'metro-cc.ru/category/posuda/posuda-dlya-prigotovleniya-pishchi?manufacturer_id%5B0%5D=1690&page=1', null, $options);
	$AC->get('https://'.$region.'metro-cc.ru/category/posuda/posuda-dlya-prigotovleniya-pishchi?manufacturer_id%5B0%5D=1690&page=2', null, $options);
	/**/
	//$AC->get('https://'.$region.'metro-cc.ru/category/elektronika-tekhnika/klimaticheskaya-tekhnika?manufacturer_id%5B0%5D=1690', null, $options);
	//$AC->get('https://'.$region.'metro-cc.ru/category/elektronika-tekhnika/melkaya?manufacturer_id%5B0%5D=1690', null, $options);
	//$AC->get('https://'.$region.'metro-cc.ru/category/posuda/prigotovlenie-pishchi?manufacturer_id%5B0%5D=1690', null, $options);
	//$AC->get('https://'.$region.'metro-cc.ru/category/elektronika-tekhnika/krupnaya?manufacturer_id%5B0%5D=1690', null, $options);
	$AC->execute(WINDOW_SIZE);
	$bad_urls = array();

	while ($bad_urls) {
	  foreach ($bad_urls as $url) {
	    $AC->get($url, null, $options);     
	  }
	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}

	echo 'К-во страниц:'.$qOfPaginationPages.PHP_EOL;
	$qOfPaginationPages = 0;

	if ($qOfPaginationPages > 2) {
		//$AC->flush_requests();
		//$AC->__set('callback', 'callback_two');
		for ($i = 2; $i <= $qOfPaginationPages; $i++) {
		  
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

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $regexpP1;
	global $regexpP2;
	global $regP;
	global $regP2;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $time_start;
	global $itemsArray;
	global $region;
	global $region_name;

	//file_put_contents('/var/www/polaris/engines/metro-cc.ru/content.txt', $response);

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {
 		//if ($info['http_code'] !== 404) {            
    	$bad_urls[] = $request->url;
    	if (round(microtime(1) - $time_start, 0) >= 180) $bad_urls = array();
  	//}
  } else {
  	preg_match($region_name, $response, $region_m);
 		echo 'request  region: '.EXTRA_PARAM.PHP_EOL;
		echo 'response region: '.trim($region_m[1]).PHP_EOL; 	

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
  	if (!$matches_items) {
  		preg_match_all($regP, $response, $matches_items, PREG_SET_ORDER);
  		//print_r($matches_items);
  	}
  	
  	//file_put_contents('/var/www/polaris/engines/metro-cc.ru/content.txt', print_r($matches_items,1));

  	foreach ($matches_items as $key) {
	  	//if (strripos($key[1], 'В корзину') !== false) {
	  		preg_match($regexpPrices2, $key[1], $matches);
	  		if (!$matches) {
	  			preg_match($regP2, $key[1], $matches);
	  		}
	  		//print_r($matches);
	  		if (@$matches[1] && @$matches[2]) {
		  		$matches[1] = trim($matches[1]);
		  		if (stripos($matches[1], 'http') === false) {
		  			$matches[1] = 'https://'.$region.'metro-cc.ru'.$matches[1];
		  		}

		  		$matches[2] = trim($matches[2]);


		  		if (@strripos($matches[3], '.') !== false) {
		  			$pricecl = preg_replace('~[\D]+~', '' , substr($matches[3], 0, strripos($matches[3], '.')));
		  		} else {
		  			$pricecl = preg_replace('~[\D]+~', '' , $matches[3]);
		  		}


					price_change_detect($matches[1], $matches[2], $pricecl, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $pricecl, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$pricecl);	
	  		}	else {
	  			if (@$matches[1] && @$matches[2]) {
		  			preg_match($regexpPrices3, $key[1], $matches);
			  		$matches[1] = trim($matches[1]);
			  		if (stripos($matches[1], 'http') === false) {
			  			$matches[1] = 'https://'.$region.'metro-cc.ru'.$matches[1];
			  		}

			  		$matches[2] = trim($matches[2]);
			  		$pricecl = '0';

						price_change_detect($matches[1], $matches[2], $pricecl, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $pricecl, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$pricecl);
					}	  			
	  		}		
			//}
		}
  }
}
