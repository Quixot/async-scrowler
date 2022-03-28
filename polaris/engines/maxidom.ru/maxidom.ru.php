<?php
/**
 * maxidom.ru
 */
switch (EXTRA_PARAM) {
case 'moscow': $region = '8'; break;
case 'spb': $region = '2'; break;
case 'kazan': $region = '4'; break;
case 'novgorod': $region = '3'; break;
case 'samara': $region = '6'; break;
case 'ufa': $region = '7'; break;
case 'yekaterinburg': $region = '5'; break;
 	default:
 		die("Unknown region\n");  	 		
}


	$urlStart 		 = 'https://www.maxidom.ru/search/catalog/?amount=100&q=polaris&category_search=0';
	$regexpPagin	 = "~По вашему запросу было найдено <strong>(.+)<~isU";
	$regexpPrices  = "~<article(.+)</article~isU";
	$regexpPrices2 = "~<a itemprop=\"name\" href=\"(.+)\".*>(.+)<.*itemprop=\"price\">(.+)<~isU";
	$regexpRegion = "~class=\"city.*>(.+)</a~isU";
	$options 			 = array(
								CURLOPT_COOKIE => 'MAXI_LOC_ID='.$region,//.$region,
								CURLOPT_COOKIEFILE       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
                CURLOPT_CONNECTTIMEOUT => 60,
                CURLOPT_TIMEOUT        => 60,
                CURLOPT_AUTOREFERER     => TRUE,
                CURLOPT_FOLLOWLOCATION  => TRUE,
                CURLOPT_HEADER => true, 
                CURLOPT_SSL_VERIFYPEER => 0	
	);

// Загрузка отсканированных ссылок:
foreach ($itemsArray as $key => $value) {
	$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
	//echo (time() - $date->format('U')).PHP_EOL; 
	if (time() - $date->format('U') <= 7200) {
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
print_r($already_scanned);

/*
	$links = array(

'https://www.maxidom.ru/catalog/blendery/polaris/',
'https://www.maxidom.ru/catalog/napolnye-ventiljatory/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/',
'https://www.maxidom.ru/catalog/vesy-kukhonnye-ehlektronnye/polaris/',
'https://www.maxidom.ru/catalog/vyprjamiteli-dlja-volos/polaris/',
'https://www.maxidom.ru/catalog/kofemolki-ehlektricheskie/polaris/',
'https://www.maxidom.ru/catalog/mashinki-dlja-strizhki-ehlektricheskie/polaris/',
'https://www.maxidom.ru/catalog/ehlektropechi/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/',
'https://www.maxidom.ru/catalog/multivarki/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/',
'https://www.maxidom.ru/catalog/mjasorubki-ehlektricheskie/polaris/',
'https://www.maxidom.ru/catalog/otparivateli/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/',
'https://www.maxidom.ru/catalog/paroochistiteli/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/',
'https://www.maxidom.ru/catalog/mikrovolnovye-pechi/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/',
'https://www.maxidom.ru/catalog/pylesosy-s-pylesbornikom/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/',
'https://www.maxidom.ru/catalog/pezozazhigalki/polaris/',
'https://www.maxidom.ru/catalog/obogrevateli-masljanye/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/',
'https://www.maxidom.ru/catalog/teploventiljatory/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/',
'https://www.maxidom.ru/catalog/termopoty/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/',
		);

	//$qOfPagesArray = array();
	//$AC->get($urlStart, null, $options);
/*	$AC->get('https://www.maxidom.ru/search/catalog/?q=polaris&category_search=0', null, $options);
	$AC->get('https://www.maxidom.ru/search/catalog/?q=polaris&category_search=0&PAGEN_3=2', null, $options);
	$AC->get('https://www.maxidom.ru/search/catalog/?q=polaris&category_search=0&PAGEN_3=3', null, $options);
	$AC->get('https://www.maxidom.ru/search/catalog/?q=polaris&category_search=0&PAGEN_3=4', null, $options);
	$AC->get('https://www.maxidom.ru/search/catalog/?q=polaris&category_search=0&PAGEN_3=5', null, $options);
	//$AC->get('https://www.maxidom.ru/catalog/mikrovolnovye-pechi/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/?amount=100', null, $options);
	//$AC->get('https://www.maxidom.ru/catalog/plity/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/?amount=100', null, $options);
	$AC->get('https://www.maxidom.ru/catalog/melkaja-tekhnika-dlja-kukhni/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/?amount=100', null, $options);
	$AC->get('https://www.maxidom.ru/catalog/kofevarki-ehspresso/polaris/', null, $options);
	$AC->get('https://www.maxidom.ru/catalog/pylesosy/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/?amount=100', null, $options);
	$AC->get('https://www.maxidom.ru/catalog/melkaja-bytovaja-tekhnika/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/?amount=100', null, $options);
	$AC->get('https://www.maxidom.ru/catalog/klimaticheskaja-tekhnika/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/?amount=100', null, $options);
	$AC->get('https://www.maxidom.ru/catalog/tovary-dlja-krasoty/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/?amount=100', null, $options);
*/
	$links = array(
		'https://www.maxidom.ru/catalog/melkaja-tekhnika-dlja-kukhni/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/?amount=100', 
		'https://www.maxidom.ru/catalog/kofevarki-ehspresso/polaris/', 
		'https://www.maxidom.ru/catalog/pylesosy/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/?amount=100', 
		'https://www.maxidom.ru/catalog/melkaja-bytovaja-tekhnika/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/?amount=100', 
		'https://www.maxidom.ru/catalog/klimaticheskaja-tekhnika/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/?amount=100', 
		'https://www.maxidom.ru/catalog/tovary-dlja-krasoty/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/?amount=100', 
		'https://www.maxidom.ru/catalog/mikrovolnovye-pechi/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/?amount=100',
		'https://www.maxidom.ru/catalog/ehlektropechi/filter/item_firm-is-ca826ab09217a52cb99eb73b0d37c778/apply/',
		'https://www.maxidom.ru/catalog/pezozazhigalki/polaris/',
		'https://www.maxidom.ru/catalog/kofemolki-ehlektricheskie/polaris/',
	);

	$is_any = 0;
	foreach ($links as $url) {
		if (!in_array($url, $already_scanned)) {
			echo 'сканирую адрес:'.PHP_EOL.$url.PHP_EOL;
			$AC->get($url, null, $options);
			$is_any = 1;
		} else {
			echo 'уже сканировал:'.PHP_EOL.$url.PHP_EOL;
		}
	}
	if ($is_any) {
		$AC->execute(10);
	}

	while ($bad_urls) {
		$AC->flush_requests();
		foreach ($bad_urls as $urls) {
		  $AC->get($urls, NULL, $options);
		}
		unset($urls);
		$bad_urls = array();
		$AC->execute(10);
	}
	unset($urls);


	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpPagin;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $time_start;
	global $itemsArray;
	global $regexpRegion;

	//proxy_statistics($response, $info, $request);
	//file_put_contents('/var/www/engines/auchan.ru/'.time(), $response);

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 600 || $info['http_code'] == 404) { $bad_urls = array(); }
  } else {
  	//file_put_contents('/var/www/polaris/engines/maxidom.ru/content.txt', $response);
  	// Region
  	preg_match($regexpRegion, $response, $mReg);
  	AngryCurl::add_debug_msg('Region: '.$mReg[1]);
  	//print_r($mReg);
  	//sleep(5);
  	//die();

    preg_match($regexpPagin, $response, $matches);
    //file_put_contents(AC_DIR.'/items/'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.txt', preg_replace('~[^\d]+~', '' , $matches[1]));
/*
    $temp = ceil(preg_replace('~[^\d]+~', '' , $matches[1]) / 96);
    if ($temp > $qOfPaginationPages) {      
	    $qOfPaginationPages = $temp;
    }
*/
  	preg_match_all($regexpPrices, $response, $matches_items, PREG_SET_ORDER);
  	//print_r($matches_items);
  	foreach ($matches_items as $key) {
	  	if (strripos($key[1], 'В наличии') !== false) {
	  		preg_match($regexpPrices2, $key[1], $matches);
	  		if ($matches[1] && $matches[2]) {
		  		$matches[1] = 'https://www.maxidom.ru'.trim($matches[1]);
		  		$matches[2] = trim($matches[2]);
		  		$matches[3] = preg_replace('~[^\d]+~', '' , $matches[3]);
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);		
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);	
	  		}			
			}
		}
  }
}
