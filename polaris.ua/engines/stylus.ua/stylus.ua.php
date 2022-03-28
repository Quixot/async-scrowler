<?php
//stylus.ua
	$urlStart 		 = 'https://stylus.com.ua/search?q=' . ENGINE_TYPE . ';p=';	// Адрес
	$regexpAll 		 = "~class=\"page-subtitle\".*>(.+)<~isU";
	$regexpPrices  = "~class=\"products-listing-item(.+)hidden-block-wrap~isU";
	$regexpPrices2 = "~class=\"name-block.*href=\"(.+)\".*>(.+)<.*class=\"regular-price\">(.+)<~isU";
	$regexpPrices3 = "~class=\"name-block.*href=\"(.+)\".*>(.+)<~isU";

	$already_scanned = array();
	$already_scanned = scanned_links($itemsArray);
	//$already_scanned = array();
	print_r($already_scanned);

	$i = 1;
	while ( regular_one('https://stylus.ua/search?q=polaris')<1 && $i<5 ) {
		$i++;
	}

	echo 'Страниц: '.$qOfPaginationPages.PHP_EOL;

	if ($qOfPaginationPages > 1) {
		for ($iPag=2; $iPag <= $qOfPaginationPages; $iPag++) { 
			if (!in_array('https://stylus.ua/search?p='.$iPag.';q=polaris', $already_scanned)) {
				AngryCurl::add_debug_msg('сканирую адрес: '.'https://stylus.ua/search?p='.$iPag.';q=polaris');
				$i = 1;
				while (regular_one('https://stylus.ua/search?p='.$iPag.';q=polaris')<1 && $i<3) {
					$i++;
				}
			} else {
				AngryCurl::add_debug_msg('уже сканировал: '.'https://stylus.ua/search?p='.$iPag.';q=polaris');
			}
		}
	}

	file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
	$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';


function regular_one($url) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpAll;
	global $qOfPaginationPages;
	global $itemsArray;
	global $bad_urls;
	global $time_start;


	$proxarr = get_proxy_and_ua('/var/www/lib/proxies/*.proxy', '/var/www/lib/useragents_short.txt');

	preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	if (!$matches_proxy) {
	 	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	}

	$cmd = 'timeout -k 35s 36s casperjs /var/www/polaris.ua/engines/stylus.ua/casper.js --ignore-ssl-errors=true --ssl-protocol=any '.escapeshellarg($url).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'];

	echo $cmd.PHP_EOL;
	$response = exec($cmd, $out, $err);
	$response = implode(" ", $out);

	file_put_contents('/var/www/philips/engines/stylus.ua/content.txt', $response);
	if (strlen($response) > 500) {
		echo 'response ok'.PHP_EOL;

		preg_match($regexpAll, $response, $matches);
		$qOfPaginationPages = ceil(preg_replace('~[\D]+~', '' , $matches[1])/30);

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  foreach ($matches2 as $key) {
	  	if (strripos($key[0], 'Купить') !== false) {
				preg_match($regexpPrices2, $key[1], $matches);
				$matches[1] = 'https://stylus.ua/'.trim($matches[1]);
				$matches[2] = str_replace('&quot;', ' ', trim($matches[2]));
				$matches[2] = str_replace('&amp;', ' ', $matches[2]);
				$matches[2] = str_replace('&apos;', ' ', $matches[2]);
				$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
				
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['login'].' '.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);	
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $useragent, $url);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			} else {
				preg_match($regexpPrices3, $key[1], $matches);
				$matches[1] = 'https://stylus.ua/'.trim($matches[1]);
				$matches[2] = str_replace('&quot;', ' ', trim($matches[2]));
				$matches[2] = str_replace('&amp;', ' ', $matches[2]);
				$matches[2] = str_replace('&apos;', ' ', $matches[2]);
				$matches[3] = '0';
				
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['login'].' '.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);	
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $useragent, $url);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);

			}
		}
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}
