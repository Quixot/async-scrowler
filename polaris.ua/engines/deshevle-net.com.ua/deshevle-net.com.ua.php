<?php
/**
 * deshevle-net.com.ua
 */
$regexpP 			 = "~class=\"search_qnt\">(.+)</span~isU";
$regexpPrices  = "~class=\"catalog_tile_item(.+)cti_add_compare~isU"; 
$regexpPrices2 = "~href=\"(.+)\".*title=\"(.+)\".*class=\"cti_price\".*>(.+)<~isU";
$regexpPrices3 = "~href=\"(.+)\".*title=\"(.+)\"~isU";
$url = 'https://www.deshevle-net.com.ua/search/rows-30.html?s%5Btext%5D=polaris';

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

if ($qOfPaginationPages > 1) {
	//$qOfPaginationPages = 4; // Костыль !!! Уменьшает нагрузку, уберает страницы без наличия

	$is_scan = 0;
	for ($i = 2; $i <= $qOfPaginationPages; $i++) {
		if (!in_array('https://www.deshevle-net.com.ua/search/rows-30/page-'.$i.'.html?s%5Btext%5D=polaris', $already_scanned)) {
			AngryCurl::add_debug_msg('сканирую адрес: '.'https://www.deshevle-net.com.ua/search/rows-30/page-'.$i.'.html?s%5Btext%5D=polaris');
	  	$AC->get('https://www.deshevle-net.com.ua/search/rows-30/page-'.$i.'.html?s%5Btext%5D=polaris', null, $options);
	  	$is_scan = 1;
	  } else {
			AngryCurl::add_debug_msg('уже сканировал: '.'https://www.deshevle-net.com.ua/search/rows-30/page-'.$i.'.html?s%5Btext%5D=polaris');
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
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
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
		$qOfPaginationPages = ceil(preg_replace('~[\D]+~', '' , $matches[1])/30);	

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);
	  foreach ($matches2 as $key) {
			preg_match($regexpPrices2, $key[0], $matches);
			//print_r($matches);
			if (@$matches[1] && $matches[2] && stripos($key[0], 'basket.add') !== false) {
				$matches[1] = 'https://www.deshevle-net.com.ua'.trim($matches[1]);
				
				
				$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
				$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
				
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}	else {
				preg_match($regexpPrices3, $key[0], $matches);
				if (@$matches[1] && $matches[2]) {
					$matches[1] = 'https://www.deshevle-net.com.ua'.trim($matches[1]);
					
					
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
					$matches[3] = '0';

					price_change_detect(trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
				}
			}	
	  }
  }
}