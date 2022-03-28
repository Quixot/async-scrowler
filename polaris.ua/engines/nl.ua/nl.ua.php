<?php
//nl.ua
switch (EXTRA_PARAM) {
	case 'kiev': 		$city = 'Киев'; 		$region = 'af1687b6-d464-11d9-b3f8-505054503030'; 	break;
	case 'kharkov': $city = 'Харьков'; 	$region = '322f45af-5c9b-11dd-9208-005056977ffc'; break;
	case 'dnepr': 	$city = 'Днепр'; 		$region = '6a93c4a0-65f1-11db-9418-0030482d3858'; 	break;
	case 'odessa': 	$city = 'Одесса'; 	$region = '43b55028-a4be-11db-a253-0030482d3858'; break;
	case 'lvov': 		$city = 'Львов'; 		$region = '0742e3be-0134-11db-be96-0030482d3858'; 	break;
 	default:
 		die("Unknown region\n"); 		
}	

$regexpP 			 = "~leftRightBtnItemsCatalog(.+)leftRightBtnItemsCatalog~isU"; 	// Пагинация
$regexpP2  		 = "~numberPagesItemsCatalog\">(.+)<~isU";  
$regexpPrices  = "~class=\"item product(.+)preview_catalog.*</div>~isU"; 
$regexpPrices2 = "~href=.*href=\"(.+)\".*class=\"name\">(.+)</span.*class=\"stable_price.*>(.+)грн.~isU";
$regexpPrices3 = "~href=.*href=\"(.+)\".*class=\"name\">(.+)</span.*class=\"discount\">(.+)грн.~isU";
$regexpPrices4 = "~href=.*href=\"(.+)\".*class=\"name\">(.+)</span~isU";


$options = array(
								CURLOPT_COOKIE => 'nl_store='.$region,
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
$AC->get('https://www.nl.ua/ru/bytovaya_tehnika/filter/ad_trademark-is-polaris/apply/', null, $options);
//https://www.nl.ua/ru/bytovaya_tehnika/tehnika_dlya_doma/filter/ad_trademark-is-polaris/apply/
$AC->execute(WINDOW_SIZE);

while ($bad_urls) {
	$AC->flush_requests();
	foreach ($bad_urls as $urls) {
	  $AC->get($urls, null, $options);
	}
	$bad_urls = array();
	$AC->execute(WINDOW_SIZE);
}

if ($qOfPaginationPages > 111) {
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

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url; 	
		if (round(microtime(1) - $time_start, 0) >= 2700) { $bad_urls = array(); } 
  } else {
		preg_match("~<div class=\"city\" style=\"height: 16px;\">(.+)<~isU", $response, $region);
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
	  file_put_contents('/var/www/polaris.ua/engines/nl.ua/1.txt', print_r($matches2, 1));
	  //print_r($matches2);
	  foreach ($matches2 as $key) {
	  	//if (strripos(mb_strtolower($key[0]), 'уценка') === false) {
	  		if (1 == 2) { //strripos($key[0], 'class="discount">') !== false
					preg_match($regexpPrices3, $key[0], $matches);

					$matches[1] = 'https://www.nl.ua'.trim($matches[1]);
					
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));

			  	if (@strripos($matches[3], '.') !== false) {
			  		$matches[3] = preg_replace('~[\D]+~', '' , substr($matches[3], 0, strripos($matches[3], '.')));
			  	} else {
			  		$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
			  	}

					if (@$matches[1] && $matches[2]) {
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}						
	  		} else {
					preg_match($regexpPrices2, $key[0], $matches);
					//print_r($matches);
					if (@$matches[1] && $matches[2]) {
						$matches[1] = 'https://www.nl.ua'.trim($matches[1]);
						
						$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
				  	if (@strripos($matches[3], '.') !== false) {
				  		$matches[3] = preg_replace('~[\D]+~', '' , substr($matches[3], 0, strripos($matches[3], '.')));
				  	} else {
				  		$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
				  	}
						
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}	else {
						preg_match($regexpPrices4, $key[0], $matches);
						if (@$matches[1] && $matches[2]) {
							$matches[1] = 'https://www.nl.ua'.trim($matches[1]);
							
							$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
							$matches[3] = '0';

							price_change_detect(trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
							$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
							AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
						}
					}				
	  		}	
	  	//} // Уценка
	  }
  }
}
