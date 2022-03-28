<?php
/**
 * wildberries.ru
 */
$itemsArray = array();

$regexp_links = "~class=\"sidemenu(.+)~isU";

$regexpP1 = "~class=\"pageToInsert\"(.+)</div>~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexp1  = "~class=\"dtList(.+)class=\"sizes~isU";
$regexp1  = "~data-card-index=(.+)product-card__sizes~isU";
$regexp2  = "~href=\"(.+)\".*alt=\"(.+)\".*class=\"price-commission__free-commission\">(.+)</~isU";
$regexpName = "~class=\"pp\">Модель:<span>(.+)<~isU";
$regexpName2 = "~class=\"article j-article\">(.+)<~isU";
$regexpRegion = "~class=\"set-city-ip\".*>(.+)<~isU";


if (ENGINE_LOOP != 2) {
	if (ENGINE_LOOP == 13) {
		$itemsArray = array();
	}
	//regular_casual();


	$options = array(
								//CURLOPT_COOKIE => $region,
								//CURLOPT_COOKIEJAR       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        				CURLOPT_COOKIEFILE      => '/var/www/polaris/engines/wildberries.ru/cookies/'.EXTRA_PARAM.'.txt',
								//CURLOPT_COOKIEFILE => '/var/www/polaris/engines/wildberries.ru/cook2.txt',
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT        => 20,
                CURLOPT_AUTOREFERER     => TRUE,
                CURLOPT_FOLLOWLOCATION  => TRUE,
                CURLOPT_HEADER => true, 
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0
	);

	//echo file_get_contents('/var/www/polaris/engines/wildberries.ru/cookies/'.EXTRA_PARAM.'.txt');die();

	//$AC->get('https://www.wildberries.ru/brands/polaris/blendery?bid=eae8cbb1-a680-4604-8716-ecf0361ea533', null, $options);
	$AC->get('https://www.wildberries.ru/brands/polaris/tehnika-dlya-kuhni', null, $options);
	$AC->get('https://www.wildberries.ru/brands/polaris/posuda-i-inventar', null, $options);
	$AC->get('https://www.wildberries.ru/brands/polaris/bytovaya-tehnika', null, $options);
	$AC->get('https://www.wildberries.ru/brands/polaris/bytovaya-tehnika?page=2', null, $options);
	//$AC->get('', null, $options);
	/*
	$AC->get('https://www.wildberries.ru/catalog/0/search.aspx?search=polaris%20polaris&brand=3300;105170', null, $options);
	$AC->get('https://www.wildberries.ru/catalog/0/search.aspx?brand=3300;105170&search=polaris%20polaris&page=2', null, $options);
	$AC->get('https://www.wildberries.ru/catalog/0/search.aspx?brand=3300;105170&search=polaris%20polaris&page=3', null, $options);
	$AC->get('https://www.wildberries.ru/catalog/0/search.aspx?brand=3300;105170&search=polaris%20polaris&page=4', null, $options);
	*/
	//$AC->get('https://www.wildberries.ru/brands/polaris/posuda-i-inventar?bid=bada261b-4ef6-4b3b-b657-c468199a63ec', null, $options);
	$AC->execute(WINDOW_SIZE);

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

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';
} elseif (ENGINE_LOOP == 2) {
	$itemsArray = array();
	$itemsArray = unserialize(file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data_profile/'.date("d.m.y").'_'.ENGINE_CURR.'.profile_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.data'));
	regular_one();
}

/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;
	global $regexp1;
	global $regexp2;
	global $itemsArray;
  global $qOfPaginationPages;  
  global $bad_urls;
  global $pos_without_name;
  global $time_start;
  global $regexpRegion;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {                
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 120) $bad_urls=array();
  } else {
  	//file_put_contents('/var/www/polaris/engines/wildberries.ru/content.txt', $response);
  	//preg_match("~class=\"final-cost\">(.+)<~isU", $response, $pr);
  	//print_r($pr);
  	//die();
  	preg_match_all($regexp1, $response, $matches2, PREG_SET_ORDER);
  	//print_r($matches2); //die();
  	foreach ($matches2 as $key) {  		
			preg_match($regexp2, $key[1], $matches);
			print_r($matches);
			$matches[1] = trim($matches[1]);

			if (stripos($matches[1], 'http') === false) {
				$matches[1] = 'https://www.wildberries.ru'.trim($matches[1]);
			} else {
				$matches[1] = trim($matches[1]);
			}

			if (stripos($matches[1], '?') !== false) {
				$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
			}

			$matches[3] = html_entity_decode($matches[3]);
			$matches = clean_info($matches, array(1,2,3));

			preg_match("/[\d]+/", $matches[2], $matchd);
			if (@$matchd[0] <= 0) {
				$pos_without_name[$matches[1]] = 1;
			}

			if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			} 							  		
		}
  }
}






function regular_one() {
	global $regexp1;
	global $regexp2;

	global $regexpName;
	global $regexpName2;

	global $itemsArray;
	global $city;
	global $cookfilepath;

	// Переделаем кукисы в правильный стандарт
	$cookfilepath = AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/'.EXTRA_PARAM.'.txt';
	if (!file_exists($cookfilepath) /*|| time() - filemtime($cookfilepath) > 3600*/) {
		die('нет кукисов или старый файл '.$cookfilepath.PHP_EOL);
	}

	/**
	 * Блок выбора прокси
	 */
	$useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';
		  
	$proxy_auth = file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/proxy/'.EXTRA_PARAM.'.txt');	  
	preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	if (!$matches_proxy) {
	 	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	}
	/**
	 * Блок выбора прокси
	 */
	$links = 'https://www.wildberries.ru/catalog/0/search.aspx?search=polaris%20polaris&brand=3300;105170,https://www.wildberries.ru/catalog/0/search.aspx?brand=3300;105170&search=polaris%20polaris&page=2,https://www.wildberries.ru/catalog/0/search.aspx?brand=3300;105170&search=polaris%20polaris&page=3,https://www.wildberries.ru/catalog/0/search.aspx?brand=3300;105170&search=polaris%20polaris&page=4';
	//$links = 'https://www.wildberries.ru/catalog/0/search.aspx?brand=3300;105170&search=polaris%20polaris&page=2';
	$cmd = 'timeout -k 800s 801s casperjs /var/www/polaris/engines/wildberries.ru/club_prices.js --ignore-ssl-errors=true --ssl-protocol=any "'.$links.'" '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4];
	//die();
	
	if ($links) {
		echo 'request: '.$cmd.PHP_EOL;
		$response = exec($cmd, $out, $err);
		$response = implode(" ", $out);
	}
	
	if ($response) {
  	preg_match_all($regexp1, $response, $matches2, PREG_SET_ORDER);

  	//print_r($matches2);
  	foreach ($matches2 as $key) {  		
			preg_match($regexp2, $key[1], $matches);
			//print_r($matches);
			$matches[1] = trim($matches[1]);

			if (stripos($matches[1], 'http') === false) {
				$matches[1] = 'https://www.wildberries.ru'.trim($matches[1]);
			} else {
				$matches[1] = trim($matches[1]);
			}

			if (stripos($matches[1], '?') !== false) {
				$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
			}

			$matches[3] = html_entity_decode($matches[3]);
			$matches = clean_info($matches, array(1,2,3));

			preg_match("/[\d]+/", $matches[2], $matchd);
			if (@$matchd[0] <= 0) {
				$pos_without_name[$matches[1]] = 1;
			}

			if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], 'manual', $useragent, ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			} 							  		
		}
	  //file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	  file_put_contents('/var/www/polaris/engines/wildberries.ru/data_profile/'.date("d.m.y").'_wildberries.ru.profile_polaris_moscow.data', serialize($itemsArray));
		
		// 
		//exec('php /var/www/polaris/engines/wildberries.ru/wildberries.ru.profile.php', $out, $err);

		return 1;
	} else {
		return 0;
	}
}








function regular_casual() {
	global $regexp1;
	global $regexp2;

	global $regexpName;
	global $regexpName2;

	global $itemsArray;
	global $city;
	global $cookfilepath;

	global $wbl;
	global $store;
	global $region;

	/**
	 * Блок выбора прокси
	 */
	$useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';
		  
	$proxy_auth = file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/proxy_casual/'.EXTRA_PARAM.'.txt');	  
	//echo $proxy_auth;die();
	preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	if (!$matches_proxy) {
	 	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	}
	//print_r($matches_proxy);die();
	/**
	 * Блок выбора прокси
	 */
	$links = 'https://www.wildberries.ru/catalog/0/search.aspx?search=polaris%20polaris&brand=3300;105170,https://www.wildberries.ru/catalog/0/search.aspx?brand=3300;105170&search=polaris%20polaris&page=2,https://www.wildberries.ru/catalog/0/search.aspx?brand=3300;105170&search=polaris%20polaris&page=3,https://www.wildberries.ru/catalog/0/search.aspx?brand=3300;105170&search=polaris%20polaris&page=4';
	$cmd = 'timeout -k 800s 801s casperjs /var/www/polaris/engines/wildberries.ru/casual_prices.js --ignore-ssl-errors=true --ssl-protocol=any "'.$links.'" '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4].' '.EXTRA_PARAM;
	echo 'request: '.$cmd.PHP_EOL;
	//die();
	if ($links) {
		$response = exec($cmd, $out, $err);
		$response = implode(" ", $out);
	}
	
	if ($response) {
		//file_put_contents('/var/www/polaris/engines/wildberries.ru/content.txt', $response);

  	preg_match_all($regexp1, $response, $matches2, PREG_SET_ORDER);
  	//file_put_contents('/var/www/polaris/engines/wildberries.ru/content_print.txt', print_r($matches2, 1));
  	//print_r($matches2);
  	foreach ($matches2 as $key) {  		
			preg_match($regexp2, $key[1], $matches);
			//print_r($matches);
			$matches[1] = trim($matches[1]);

			if (stripos($matches[1], 'http') === false) {
				$matches[1] = 'https://www.wildberries.ru'.trim($matches[1]);
			} else {
				$matches[1] = trim($matches[1]);
			}

			if (stripos($matches[1], '?') !== false) {
				$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
			}

			$matches[3] = html_entity_decode($matches[3]);
			$matches = clean_info($matches, array(1,2,3));

			preg_match("/[\d]+/", $matches[2], $matchd);
			if (@$matchd[0] <= 0) {
				$pos_without_name[$matches[1]] = 1;
			}

			if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], 'manual', $useragent, ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			} 							  		
		}
	  //file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	  //file_put_contents('/var/www/polaris/engines/wildberries.ru/data_profile/'.date("d.m.y").'_wildberries.ru.profile_polaris_moscow.data', serialize($itemsArray));
		
		// 
		//exec('php /var/www/polaris/engines/wildberries.ru/wildberries.ru.profile.php', $out, $err);

		return 1;
	} else {
		return 0;
	}
}
















function callback_two($response, $info, $request) {
	global $regexp1;
	global $regexp2;
	global $itemsArray;
	global $bad_urls;
	global $pos_without_name;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);       
  } else {

  	//file_put_contents('/var/www/polaris/engines/wildberries.ru/content.txt', $response);

  	preg_match_all($regexp1, $response, $matches2, PREG_SET_ORDER);
  	
  	foreach ($matches2 as $key) {  		
			preg_match($regexp2, $key[1], $matches);
			$matches[1] = trim($matches[1]);

			if (stripos($matches[1], 'http') === false) {
				$matches[1] = 'https://www.wildberries.ru'.trim($matches[1]);
			} else {
				$matches[1] = trim($matches[1]);
			}

			if (stripos($matches[1], '?') !== false) {
				$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
			}

			$matches[3] = html_entity_decode($matches[3]);
			$matches = clean_info($matches, array(1,2,3));

			preg_match("/[\d]+/", $matches[2], $matchd);
			if (@$matchd[0] <= 0) {
				$pos_without_name[$matches[1]] = 1;
			}

			if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			} 							  		
		}	
  }
}

function callback_three($response, $info, $request) {
	global $regexpName;
	global $regexpName2;
	global $itemsArray;
	global $bad_urls;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);       
  } else { 		
		preg_match($regexpName, $response, $matches);
		//print_r($matches);
		if (@$matches[1]) {
			$itemsArray[$request->url][0] = $itemsArray[$request->url][0].' '.trim($matches[1]);
			AngryCurl::add_debug_msg(trim($matches[1]));							  		
		}	else {
			preg_match($regexpName2, $response, $matches);
			if (@$matches[1]) {
				$itemsArray[$request->url][0] = $itemsArray[$request->url][0].' '.trim($matches[1]);
				AngryCurl::add_debug_msg(trim($matches[1]));							  		
			}
		}
  }
}



function callback_four($response, $info, $request) {
	global $itemsArray;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {                
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);
  } else {
  	$ajaxcontent = json_decode($response);
  	//var_dump($ajaxcontent);

  	foreach ($ajaxcontent->data->products as $index) {
  		$itemsArray['https://www.wildberries.ru/catalog/'.trim($index->id).'/detail.aspx'][1] = trim($index->salePrice);
			AngryCurl::add_debug_msg($index->id.' | '.$index->name.' | '.$index->salePrice);
  	}
  }
}


