<?php
/**
 * tehnomaster.com
 */
$regexpP 			 = "~class=\"pager\"(.+)</div>~isU"; 	// Пагинация
$regexpP2  		 = "~<a.*>(.+)<~isU";  
$regexpPrices  = "~class=\"item_body\"(.+)class=\"events\"~isU"; 
$regexpPrices2 = "~href=\"(.+)\".*title=\"(.+)\".*class=\"price uah\">(.+)<~isU";
$regexpPrices3 = "~href=\"(.+)\".*title=\"(.+)\"~isU";
$url = 'https://tehnomaster.com/index.php?view=search&text_filter=polaris&id%24text_filter=';

/*
$options = array(
								//CURLOPT_COOKIE => 'city_id='.$region.';city_id_geo='.$region,
								CURLOPT_COOKIEJAR       => '/var/www/polaris.ua/cookies/1.txt',
        				CURLOPT_COOKIEFILE      => '/var/www/polaris.ua/cookies/1.txt',
                CURLOPT_CONNECTTIMEOUT 	=> 60,
                CURLOPT_TIMEOUT        	=> 60,
                CURLOPT_AUTOREFERER     => true,
                CURLOPT_FOLLOWLOCATION  => true,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_HEADER 					=> 0, 
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
		if (!in_array('https://tehnomaster.com/view/search.html?text_filter=polaris&page='.$i, $already_scanned)) {
			AngryCurl::add_debug_msg('сканирую адрес: '.'https://tehnomaster.com/view/search.html?text_filter=polaris&page='.$i);
	  	$AC->get('https://tehnomaster.com/view/search.html?text_filter=polaris&page='.$i, null, $options);
	  	$is_scan = 1;
	  } else {
			AngryCurl::add_debug_msg('уже сканировал: '.'https://tehnomaster.com/view/search.html?text_filter=polaris&page='.$i);
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
*/
regular_one();

file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';

/** 
 * Callback Functions           
 */
function regular_one() {
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


	$proxarr = get_proxy_and_ua('/var/www/lib/proxies/15.proxy', '/var/www/lib/useragents_short.txt');

	preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	if (!$matches_proxy) {
	 	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	}

	$cmd = 'timeout -k 120s 121s casperjs /var/www/polaris.ua/engines/tehnomaster.com/casper.js --ignore-ssl-errors=true --ssl-protocol=any '.escapeshellarg($url).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'];

	echo $cmd.PHP_EOL;
	$response = exec($cmd, $out, $err);
	$response = implode(" ", $out);

	//file_put_contents('/var/www/polaris.ua/engines/tehnomaster.com/content.txt', $response);

	$glob = glob('/var/www/polaris.ua/engines/tehnomaster.com/content/*.txt'); //https://www.ozon.ru/brand/polaris-17476997/?page=
	//print_r($glob);die();

	if (count($glob)) {
		foreach ($glob as $addr) {
			echo 'response ok'.PHP_EOL;

			preg_match('~content/(.+).txt~isU', $addr, $mReqUrl);
			$request_url = 'https://tehnomaster.com/view/search.html?text_filter=polaris&page='.$mReqUrl[1];
			
			$response = $response.file_get_contents($addr);
			//file_put_contents(filename, $response);

			$response = htmlspecialchars_decode($response);
			//$response = str_replace('\u002F', "/", $response);
			
		  $count_all_items = 0;
	

			preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
		  //print_r($matches2);
		  foreach ($matches2 as $key) {
				preg_match($regexpPrices2, $key[0], $matches);
				//print_r($matches);
				if (@$matches[1] && $matches[2] && stripos($key[0], 'super_bttn big buy') !== false) {
					$matches[1] = 'https:'.trim($matches[1]);
					
					
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
					$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
					
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $useragent, $request_url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
				}	else {
					preg_match($regexpPrices3, $key[0], $matches);
					if (@$matches[1] && $matches[2]) {
						$matches[1] = 'https:'.trim($matches[1]);
						
						
						$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
						$matches[3] = '0';

						price_change_detect(trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $useragent, $request_url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}
				}	
		  }
			//file_put_contents('/var/www/polaris/engines/ozon.ru/checkarray.txt', print_r($checkitems, 1));
			unlink($addr);
		}
		return 1;
	} else {
		return 0;
	}
}


function __regular_one() {
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


	$proxarr = get_proxy_and_ua('/var/www/lib/proxies/15.proxy', '/var/www/lib/useragents_short.txt');

	preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	if (!$matches_proxy) {
	 	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	}

	$cmd = 'timeout -k 120s 121s casperjs /var/www/polaris.ua/engines/tehnomaster.com/casper.js --ignore-ssl-errors=true --ssl-protocol=any '.escapeshellarg($url).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'];

	echo $cmd.PHP_EOL;
	$response = exec($cmd, $out, $err);
	$response = implode(" ", $out);

	file_put_contents('/var/www/polaris.ua/engines/tehnomaster.com/content.txt', $response);

	if (strlen($response) > 500) {
		echo 'response ok'.PHP_EOL;

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);
	  foreach ($matches2 as $key) {
			preg_match($regexpPrices2, $key[0], $matches);
			//print_r($matches);
			if (@$matches[1] && $matches[2] && stripos($key[0], 'super_bttn big buy') !== false) {
				$matches[1] = 'https:'.trim($matches[1]);
				
				
				$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
				$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
				
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}	else {
				preg_match($regexpPrices3, $key[0], $matches);
				if (@$matches[1] && $matches[2]) {
					$matches[1] = 'https:'.trim($matches[1]);
					
					
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
					$matches[3] = '0';

					price_change_detect(trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual');
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
				}
			}	
	  }
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}

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

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]); 

	

  if ($info['http_code'] !== 200 || strlen($response) < 500) {            
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
			if (@$matches[1] && $matches[2] && stripos($key[0], 'super_bttn big buy') !== false) {
				$matches[1] = 'https:'.trim($matches[1]);
				
				
				$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
				$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
				
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}	else {
				preg_match($regexpPrices3, $key[0], $matches);
				if (@$matches[1] && $matches[2]) {
					$matches[1] = 'https:'.trim($matches[1]);
					
					
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
