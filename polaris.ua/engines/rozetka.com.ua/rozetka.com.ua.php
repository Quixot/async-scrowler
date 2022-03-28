<?php
//rozetka.com.ua
	$regexpAll 		 = "~class=\"rz-search-result-qnty\".*>(.+)</~isU";
	$regexpPrices  = "~catalog-grid__cell(.+)</li>~isU";
	$regexpPrices2 = "~goods-tile__heading.*href=\"(.+)\".*title=\"(.+)\".*class=\"goods-tile__price-value\">(.+)<~isU";
	$regexpPrices3 = "~goods-tile__heading.*href=\"(.+)\".*title=\"(.+)\"~isU";

	$already_scanned = array();
	$already_scanned = scanned_links($itemsArray);
	$already_scanned = array();
	print_r($already_scanned);


if (ENGINE_LOOP == 13) {
	$regions = array('kiev');

	foreach ($regions as $region) {

		$content_file_path = '/var/www/polaris.ua/engines/rozetka.com.ua/content/kiev.txt';
		if (file_exists($content_file_path) && time() - filemtime($content_file_path) < 13600) {

			$itemsArray = array();

			$AC = new AngryCurl('callback_three');
			$AC->init_console();
			$response = file_get_contents($content_file_path);

			callback_three($response, $region);

			if ($itemsArray) {
				file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
			}
		} else {
			echo 'Старый файл: '.$content_file_path.PHP_EOL;
		}
	}
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '.ua_' . EXTRA_PARAM . '.csv';

} else {


	$i = 1;
	while ( regular_one('https://rozetka.com.ua/search/?text=polaris&producer=266&seller=rozetka')<1 && $i<3 ) {//&page=2
		$i++;
	}

	if ($qOfPaginationPages > 1) {
		for ($iPag=2; $iPag <= $qOfPaginationPages; $iPag++) { 
			if (!in_array('https://rozetka.com.ua/search/?text=polaris&producer=266&seller=rozetka&page='.$iPag, $already_scanned)) {
				AngryCurl::add_debug_msg('сканирую адрес: '.'https://rozetka.com.ua/search/?text=polaris&producer=266&seller=rozetka&page='.$iPag);
				$i = 1;
				while (regular_one('https://rozetka.com.ua/search/?text=polaris&producer=266&seller=rozetka&page='.$iPag)<1 && $i<3) {
					$i++;
				}
			} else {
				AngryCurl::add_debug_msg('уже сканировал: '.'https://rozetka.com.ua/search/?text=polaris&producer=266&seller=rozetka&page='.$iPag);
			}
		}
	}

	file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
	$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';
}

/** 
 *              Callback Functions           
 */
function callback_three($response, $region) {
	global $itemsArray;
	global $bad_urls;
	global $region;
	global $city;
	global $regexpRegion;
	global $time_start;

	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;

	if ($response) {
		//echo 'response ok'.PHP_EOL;
		//file_put_contents('/var/www/polaris/engines/dns-shop.ru/content.txt', $response);
  	preg_match($regexpRegion, $response, $mregion);
  	$mregion[1] = trim($mregion[1]);
  	echo 'Регион: '.$mregion[1].' | '.$region.PHP_EOL;


 	

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);

	  foreach ($matches2 as $key) {
	  	if (strripos($key[0], 'goods-tile__availability--available') !== false || strripos($key[0], 'Есть в наличии') !== false || strripos($key[0], 'Є в наявності') !== false) {
				preg_match($regexpPrices2, $key[1], $matches);
				$matches[1] = trim($matches[1]);
				$matches[2] = trim($matches[2]);
				$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
				
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual'.' '.'manual', 'manual'.' '.'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);	
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual'.' '.'manual', 'manual', 'manual');
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			} else {
				preg_match($regexpPrices3, $key[1], $matches);
				$matches[1] = trim($matches[1]);
				$matches[2] = trim($matches[2]);
				$matches[3] = '0';
				
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual'.' '.'manual', 'manual'.' '.'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);	
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), 'manual'.' '.'manual', 'manual', 'manual');
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}
		}
		if ($itemsArray) {
			file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
		}
		
		//$itemsManual = array_unique($itemsManual);
		//file_put_contents("/var/www/polaris/engines/dns-shop.ru/1.txt", print_r($itemsManual, 1));
		//die('К-во: '.$i);
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}



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

	$cmd = 'timeout -k 50s 51s casperjs /var/www/polaris.ua/engines/rozetka.com.ua/casper.js --ignore-ssl-errors=true --ssl-protocol=any '.escapeshellarg($url).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'];

	echo $cmd.PHP_EOL;die();
	$response = exec($cmd, $out, $err);
	$response = implode(" ", $out);

	file_put_contents('/var/www/polaris.ua/engines/rozetka.com.ua/content.txt', $response);
	if (strlen($response) > 500) {
		echo 'response ok'.PHP_EOL;

		preg_match($regexpAll, $response, $matches);
		$qOfPaginationPages = ceil(preg_replace('~[\D]+~', '' , $matches[1])/36);
		

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);

	  foreach ($matches2 as $key) {
	  	if (strripos($key[0], 'goods-tile__availability--available') !== false || strripos($key[0], 'Есть в наличии') !== false || strripos($key[0], 'Є в наявності') !== false) {
				preg_match($regexpPrices2, $key[1], $matches);
				$matches[1] = trim($matches[1]);
				$matches[2] = trim($matches[2]);
				$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
				
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['login'].' '.$proxarr['password'], $useragent, ENGINE_CURR, ENGINE_TYPE);	
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $useragent, $url);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			} else {
				preg_match($regexpPrices3, $key[1], $matches);
				$matches[1] = trim($matches[1]);
				$matches[2] = trim($matches[2]);
				$matches[3] = '0';
				
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['login'].' '.$proxarr['password'], $useragent, ENGINE_CURR, ENGINE_TYPE);	
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $useragent, $url);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}
		}
		file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}
