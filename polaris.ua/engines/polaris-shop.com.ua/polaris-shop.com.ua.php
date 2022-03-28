<?php
/**
 * polaris-shop.com.ua
 */
$regexpLinks = "~class=\"popup-cat__submenu-item.*href=\"(.+)\"~isU";
$regexpP 			 = "~class=\"page-list\"(.+)</ul~isU"; 	// Пагинация
$regexpP2  		 = "~<a.*>(.+)<~isU";  
$regexpPrices  = "~<li class=\"card-product(.+)class=\"more-info~isU"; 
$regexpPrices2 = "~href=\"(.+)\".*title=\"(.+)\".*class=\"action-price\">(.+)<~isU";
$regexpPrices3 = "~href=\"(.+)\".*title=\"(.+)\"~isU";
$url = 'https://polaris-shop.com.ua/';

$options = array(
								//CURLOPT_COOKIE => 'city_id='.$region.';city_id_geo='.$region,
								//CURLOPT_COOKIEJAR       => '/var/www/polaris.ua/cookies',
        				//CURLOPT_COOKIEFILE      => '/var/www/polaris.ua/cookies',
                CURLOPT_CONNECTTIMEOUT 	=> 30,
                CURLOPT_TIMEOUT        	=> 30,
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

print_r($links);

$AC->flush_requests();
$AC->__set('callback','callback_two');

foreach ($links as $url) {
	$qOfPaginationPages = 0;
	$bad_urls = array();
	$AC->get($url.'?limit=33', null, $options);
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
		$is_scan = 0;
		for ($i = 2; $i <= $qOfPaginationPages; $i++) {
			if (!in_array($url.'?limit=33&sort=raitng&page='.$i, $already_scanned)) {
				AngryCurl::add_debug_msg('сканирую адрес: '.$url.'?limit=33&sort=raitng&page='.$i);
		  	$AC->get($url.'?limit=33&sort=raitng&page='.$i, null, $options);
		  	$is_scan = 1;
		  } else {
				AngryCurl::add_debug_msg('уже сканировал: '.$url.'?limit=33&sort=raitng&page='.$i);
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

file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';

/** 
 * Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpLinks;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $itemsArray;  
  global $links;
  global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]); 

	//echo $response;

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url; 	
		if (round(microtime(1) - $time_start, 0) >= 270) { $bad_urls = array(); } 
  } else {
		preg_match_all($regexpLinks, $response, $matches2);
		//print_r($matches2);
		$links = $matches2[1];
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

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]); 

	//echo $response;

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url; 	
		if (round(microtime(1) - $time_start, 0) >= 270) { $bad_urls = array(); } 
  } else {
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
			preg_match($regexpPrices2, $key[0], $matches);
			//print_r($matches);
			if (@$matches[1] && $matches[2] && stripos($key[0], 'buy-btn') !== false) {
				$matches[1] = trim($matches[1]);
				
				
				$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
				$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
				
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}	else {
				preg_match($regexpPrices3, $key[0], $matches);
				if (@$matches[1] && $matches[2]) {
					$matches[1] = trim($matches[1]);
					
					
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
					$matches[3] = '0';

					price_change_detect(trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
				}
			}	
	  }
	  file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
  }
}
