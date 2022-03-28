<?php
/**
 * protovar.com.ua
 */
$regexpLinksBlock = "~<div class=\"block\">(.+)class=\"block_bot\"~isU";
$regexpLinks = "~<li><a href=\"(.+)\"~isU";
$regexpP 			 = "~class=\"page-list\"(.+)</ul~isU"; 	// Пагинация
$regexpP2  		 = "~<a.*>(.+)<~isU";  
$regexpPrices  = "~class=\"pr_block0\"(.+)pr_block5~isU"; 
$regexpPrices2 = "~pr_name.*href=\"(.+)\".*>(.+)<.*class=\"left mt6\".*>(.+)<~isU";
$regexpPrices3 = "~pr_name.*href=\"(.+)\".*>(.+)<~isU";
$url = 'https://protovar.com.ua/search/7334';

regular_one();

/*
$options = array(
								//CURLOPT_COOKIE => 'city_id='.$region.';city_id_geo='.$region,
								//CURLOPT_COOKIEJAR       => '/var/www/polaris.ua/cookies',
        				//CURLOPT_COOKIEFILE      => '/var/www/polaris.ua/cookies',
                CURLOPT_CONNECTTIMEOUT 	=> 40,
                CURLOPT_TIMEOUT        	=> 40,
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

print_r($links);

$AC->flush_requests();
$AC->__set('callback','callback_two');

foreach ($links as $url) {
	$qOfPaginationPages = 0;
	$bad_urls = array();
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
		$is_scan = 0;
		for ($i = 2; $i <= $qOfPaginationPages; $i++) {
			if (!in_array($url.$i, $already_scanned)) {
				AngryCurl::add_debug_msg('сканирую адрес: '.$url.$i);
		  	$AC->get($url.$i, null, $options);
		  	$is_scan = 1;
		  } else {
				AngryCurl::add_debug_msg('уже сканировал: '.$url.$i);
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
*/

file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';

/** 
 * Callback Functions           
 */
function regular_one() {
  global $regexpLinksBlock;
  global $regexpLinks;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $itemsArray;  
  global $links;
  global $bad_urls;
	global $time_start;


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
	$cmd = 'timeout -k 120s 121s casperjs /var/www/polaris.ua/engines/protovar.com.ua/casper.js --ignore-ssl-errors=true --ssl-protocol=any '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4];

	echo $cmd.PHP_EOL;
	$response = exec($cmd, $out, $err);
	$response = implode(" ", $out);

	//file_put_contents('/var/www/polaris/engines/protovar.com.ua/content.txt', $response);
	$glob = glob('/var/www/polaris.ua/engines/protovar.com.ua/content/*.txt');

	if (count($glob)) {
		foreach ($glob as $addr) {
			echo 'response ok'.PHP_EOL;

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
				if (@$matches[1] && $matches[2] && stripos($key[0], 'in_cart') !== false) {
					$matches[1] = trim($matches[1]);
					
					
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
					$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
					
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].' '.$matches_proxy[2], $matches_proxy[3].' '.$matches_proxy[4], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].' '.$matches_proxy[2], $useragent);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
				}	else {
					preg_match($regexpPrices3, $key[0], $matches);
					if (@$matches[1] && $matches[2]) {
						$matches[1] = trim($matches[1]);
						
						
						$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
						$matches[3] = '0';

						price_change_detect(trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), $matches_proxy[1].' '.$matches_proxy[2], $matches_proxy[3].' '.$matches_proxy[4], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), $matches_proxy[1].' '.$matches_proxy[2], $useragent);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}
				}	
			}
			unlink($addr);
	  }
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}


function __regular_one() {
  global $regexpLinksBlock;
  global $regexpLinks;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $itemsArray;  
  global $links;
  global $bad_urls;
	global $time_start;


	$proxarr = get_proxy_and_ua('/var/www/lib/proxies/15.proxy', '/var/www/lib/useragents_short.txt');

	preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	if (!$matches_proxy) {
	 	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	}

	$cmd = 'timeout -k 120s 121s casperjs /var/www/polaris.ua/engines/protovar.com.ua/casper.js --ignore-ssl-errors=true --ssl-protocol=any '.escapeshellarg($url).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'];

	echo $cmd.PHP_EOL;die();
	$response = exec($cmd, $out, $err);
	$response = implode(" ", $out);

	file_put_contents('/var/www/polaris/engines/protovar.com.ua/content.txt', $response);

	if (strlen($response) > 500) {
		echo 'response ok'.PHP_EOL;

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);
	  foreach ($matches2 as $key) {
			preg_match($regexpPrices2, $key[0], $matches);
			//print_r($matches);
			if (@$matches[1] && $matches[2] && stripos($key[0], 'in_cart') !== false) {
				$matches[1] = trim($matches[1]);
				
				
				$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
				$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
				
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['login'].' '.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $useragent);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}	else {
				preg_match($regexpPrices3, $key[0], $matches);
				if (@$matches[1] && $matches[2]) {
					$matches[1] = trim($matches[1]);
					
					
					$matches[2] = trim(strip_tags(str_replace('&quot;', '', $matches[2])));
					$matches[3] = '0';

					price_change_detect(trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['login'].' '.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $useragent);
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
  global $regexpLinksBlock;
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
  	preg_match($regexpLinksBlock, $response, $matches);
		preg_match_all($regexpLinks, $matches[1], $matches2);
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
			if (@$matches[1] && $matches[2] && stripos($key[0], 'in_cart') !== false) {
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
  }
}
