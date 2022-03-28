<?php
//mta.ua
switch (EXTRA_PARAM) {
	case 'kiev': 		$city = 'Киев'; 		$region = '4'; 	break;
	case 'kharkov': $city = 'Харьков'; 	$region = '13'; break;
	case 'dnepr': 	$city = 'Днепр'; 		$region = '1'; 	break;
	case 'odessa': 	$city = 'Одесса'; 	$region = '10'; break;
	case 'lvov': 		$city = 'Львов'; 		$region = '8'; 	break;
 	default:
 		die("Unknown region\n"); 		
}	

$regexpP 			 = "~leftRightBtnItemsCatalog(.+)leftRightBtnItemsCatalog~isU"; 	// Пагинация
$regexpP2  		 = "~numberPagesItemsCatalog\">(.+)<~isU";  
$regexpPrices  = "~data-category_id=(.+)filterBlockForItemsInCatalog~isU"; 
$regexpPrices2 = "~class=\"product__name.*href=\"(.+)\".*>(.+)</a.*class=\"product__price.*>(.+)</~isU";
$regexpPrices3 = "~class=\"product__name.*href=\"(.+)\".*>(.+)</a~isU";

$options = array(
								//CURLOPT_COOKIE => 'myCity='.$region,
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

/**
 * Получаем ссылки на категории
 */
$AC->get('https://mta.ua/ru/search/?search=polaris', null, $options);
//$AC->get('https://mta.ua/ru/search/?search=polaris', null, $options);
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
	$AC->flush_requests();
	$AC->__set('callback','callback_one');

	$is_scan = 0;
	for ($i = 2; $i <= $qOfPaginationPages; $i++) {
		if (!in_array('https://mta.ua/ru/search/page='.$i.'?search=polaris', $already_scanned)) {
			AngryCurl::add_debug_msg('сканирую адрес: '.'https://mta.ua/ru/search/page='.$i.'?search=polaris');
	  	$AC->get('https://mta.ua/ru/search/page='.$i.'?search=polaris', null, $options);
	  	$is_scan = 1;
	  } else {
			AngryCurl::add_debug_msg('уже сканировал: '.'https://mta.ua/ru/search/page='.$i.'?search=polaris');
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

file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';

/** 
 * Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP;
  global $regexpP2;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;  
  global $qOfPaginationPages;
  global $bad_urls;
	global $time_start;
	global $city;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]); 

	//echo $response;

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url; 	
		if (round(microtime(1) - $time_start, 0) >= 2700) { $bad_urls = array(); } 
  } else {
		preg_match("~id=\"geoCityName\">(.+)<~isU", $response, $region);
		AngryCurl::add_debug_msg('request  region: '.$city);
		AngryCurl::add_debug_msg('response region: '.trim($region[1])); 

		//file_put_contents('/var/www/polaris.ua/engines/mta.ua/content.txt', $response);die($response);

		preg_match($regexpP, $response, $matches);
		preg_match_all($regexpP2, $matches[0], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			if (is_numeric($value)) $temparrpage[] = $value;
		}
		if (@max($temparrpage) > $qOfPaginationPages) $qOfPaginationPages = @max($temparrpage);	

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //file_put_contents('/var/www/polaris.ua/engines/mta.ua/1.txt', print_r($matches2, 1));
	  //print_r($matches2);
	  foreach ($matches2 as $key) {
	  	//if (strripos(mb_strtolower($key[0]), 'уценка') === false) {
	  		if (strripos($key[1], 'addToBasket') !== false) {
					preg_match($regexpPrices2, $key[1], $matches);
					//print_r($matches);

					$matches[1] = trim($matches[1]);
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
					$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);

					if (@$matches[1] && $matches[2]) {
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}									
	  		}	else {
					preg_match($regexpPrices3, $key[1], $matches);

					$matches[1] = trim($matches[1]);
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
					$matches[3] = '0';

					if (@$matches[1] && $matches[2]) {
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}		  			
	  		}
	  	//} // Уценка
	  }
  }
}
