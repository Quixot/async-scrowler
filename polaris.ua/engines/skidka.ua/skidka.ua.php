<?php
/**
 * skidka.ua
 */
$regexpP1 			= "~class=\"pagination\">(.+)</ul>~isU";
$regexpP2 			= "~<a.*>(.+)<~isU";
$regexpPrices   = "~class=\"one-item \"(.+)one-item-descr~isU";
$regexpPrices2  = "~class=\"one-item-tit.*<a href=\"(.+)\".*>(.+)<.*class=\"now-item-price.*>(.+)<~isU"; // Режем карточки товара
$regexpPrices3  = "~class=\"one-item-tit.*<a href=\"(.+)\".*>(.+)<~isU"; // Режем карточки товара нет в наличии
$regexpPricesName = "~class=\"big-img-wrap\".*alt=\"(.+)\"~isU";
$regexpItemPage = "~itemprop=\"price\">.*>(.+)<~isU";

$directLinks = explode("\n", file_get_contents('/var/www/polaris.ua/engines/'.ENGINE_CURR.'/links.txt'));
array_walk($directLinks, 'trim_value');

$already_scanned = array();
$already_scanned = scanned_links($itemsArray);
//$already_scanned = array();
print_r($already_scanned);

$url = 'https://skidka.ua/search/2/?query=polaris&by=61';
for ($pag=1; $pag <= 19; $pag++) { 
//foreach ($directLinks as $url) {
		if (!in_array('https://skidka.ua/search/'.$pag.'/?query=polaris&by=61', $already_scanned)) {
			AngryCurl::add_debug_msg('сканирую адрес: '.'https://skidka.ua/search/'.$pag.'/?query=polaris&by=61');
			$i = 1;
			while (regular_one('https://skidka.ua/search/'.$pag.'/?query=polaris&by=61')<1 && $i<3) {
				$i++;
			}
		} else {
			AngryCurl::add_debug_msg('уже сканировал: '.'https://skidka.ua/search/'.$pag.'/?query=polaris&by=61');
		}
}	



file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';

/** 
 *              Callback Functions           
 */
function regular_one($url) {
  global $regexpP1;
  global $regexpP2;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPricesName;
	global $itemsArray;  
	global $time_start;

	echo $url.PHP_EOL;
	
	$proxy_array = glob('/var/www/lib/proxies/*.proxy');
	$alive_proxy_list = '';
	foreach ($proxy_array as $key) {
		$alive_proxy_list .= file_get_contents($key);
		$alive_proxy_list .= "\n";
	}
	$alive_proxy_list = trim($alive_proxy_list);
	$proxy_list = explode("\n", $alive_proxy_list);
	$useragent_list = explode("\n", file_get_contents( '/var/www/lib/useragents_short.txt' ));
	array_walk($proxy_list, 'trim_value');
	array_walk($useragent_list, 'trim_value');

/**
 * Блок выбора прокси
 */
	$useragent_index = mt_rand(0, count($useragent_list)-1);
	$useragent = $useragent_list[$useragent_index];
  $proxy_auth = $proxy_list[ mt_rand(0, count($proxy_list)-1) ];
  preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
  if (!$matches_proxy) {
   	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
  }
	$proxy = $matches_proxy[1].':'.$matches_proxy[2];	
	$auth  = $matches_proxy[3].':'.$matches_proxy[4]; 
/**
 * Блок выбора прокси
 */
	$cmd = 'timeout -k 51s 55s casperjs /var/www/polaris.ua/engines/skidka.ua/casper.js --ignore-ssl-errors=true --ssl-protocol=any '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4];
	echo $cmd;
	$response = exec($cmd, $out, $err);
	$response = stripcslashes(implode(" ", $out));

	file_put_contents("/var/www/polaris.ua/engines/skidka.ua/content.txt", $response);

	//echo $response;
	if ($response) {
		
		preg_match($regexpP1, $response, $matches);
		//print_r($matches);
		preg_match_all($regexpP2, $matches[1], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			echo "value:" . $value . "\n";
			if (is_numeric($value)) {
				$temparrpage[] = $value;
			}
		}
		if (@max($temparrpage) > $qOfPaginationPages) {
			$qOfPaginationPages = @max($temparrpage);	    	
		}

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  print_r($matches2);
	  foreach ($matches2 as $key) {
	  	preg_match($regexpPricesName, $key[1], $matchesN);
			preg_match($regexpPrices2, $key[1], $matches);
			$matchesN[1] = trim($matchesN[1]);
			$matchesN[1] = str_replace(' - фото', '', $matchesN[1]);
			$matches[2] = trim($matches[2]);
			if (strlen($matchesN[1]) > strlen($matches[2])) {
				$matches[2] = $matchesN[1];
			}
			$matches[1] = 'https://skidka.ua'.trim($matches[1]);
			$matches[2] = trim($matches[2]);
			//print_r($matches);
			if (strripos($key[1], 'add-to-basket-action') !== false || strripos($key[1], 'В магазин') !== false) { // Тут дополнительно нужно проверять наличие. Если кнопка оранжевая, сканируем	
				if ($matches[1]) {
					price_change_detect($matches[1], $matches[2], preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $proxyArr[0].':'.$proxyArr[1], $authArr[0].':'.$authArr[1], escapeshellarg($useragent), ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $proxyArr[0].':'.$proxyArr[1], $useragent, $url);
					echo $matches[2].' | '.preg_replace('~[\D]+~', '' , $matches[3]).PHP_EOL;	
				}				
			} else {
				preg_match($regexpPrices3, $key[1], $matches);
				if (strripos($key[1], 'Нет в наличии') !== false AND strripos($matches[1], 'http') !== false) {
					if ($matches[1]) {
						$matches[1] = 'https://skidka.ua'.trim($matches[1]);
						$matches[2] = trim($matches[2]);
						price_change_detect($matches[1], $matches[2], '0', date("d.m.y-H:i:s"), $proxyArr[0].':'.$proxyArr[1], $authArr[0].':'.$authArr[1], escapeshellarg($useragent), ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], '0', date("d.m.y-H:i:s"), $proxyArr[0].':'.$proxyArr[1], $useragent, $url);
						echo $matches[2].' | 0'.PHP_EOL;						
					}					
				}
			}
		}
		file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
		return 1;
  } else {
  	$bad_urls[] = $url;
  	return 0;
  }
}

function regular_two($url) {
  global $regexpP;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPricesName;
	global $itemsArray;  
	global $time_start;

	echo $url.PHP_EOL;
	
	$proxy_array = glob('/var/www/lib/proxies/*.proxy');
	$alive_proxy_list = '';
	foreach ($proxy_array as $key) {
		$alive_proxy_list .= file_get_contents($key);
		$alive_proxy_list .= "\n";
	}
	$alive_proxy_list = trim($alive_proxy_list);
	$proxy_list = explode("\n", $alive_proxy_list);
	$useragent_list = explode("\n", file_get_contents( '/var/www/lib/useragents_short.txt' ));
	array_walk($proxy_list, 'trim_value');
	array_walk($useragent_list, 'trim_value');

/**
 * Блок выбора прокси
 */
	$useragent_index = mt_rand(0, count($useragent_list)-1);
	$useragent = $useragent_list[$useragent_index];
  $proxy_auth = $proxy_list[ mt_rand(0, count($proxy_list)-1) ];
  preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
  if (!$matches_proxy) {
   	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
  }
	$proxy = $matches_proxy[1].':'.$matches_proxy[2];	
	$auth  = $matches_proxy[3].':'.$matches_proxy[4]; 
/**
 * Блок выбора прокси
 */
	$cmd = 'timeout -k 31s 31s casperjs /var/www/polaris.ua/engines/skidka.ua/casper.js '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$proxyArr[0].' '.$proxyArr[1].' '.$authArr[0].' '.$authArr[1];
	echo $cmd;
	$phantomjs = exec("$cmd 2>&1", $out, $err);
	// Режем данные, сохраняем в массив
	$response = stripcslashes($phantomjs);

	if ($response) {
    preg_match($regexpP, $response, $matches); // Сколько страниц цен      
    $temp = ceil(preg_replace('~[^\d]+~', '' , $matches[1]) / 30);
    if ($qOfPaginationPages < $temp) {
    	$qOfPaginationPages = $temp;
    } 

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);
	  foreach ($matches2 as $key) {
	  	preg_match($regexpPricesName, $key[1], $matchesN);
			preg_match($regexpPrices2, $key[1], $matches);
			$matchesN[1] = trim($matchesN[1]);
			$matchesN[1] = str_replace(' - фото', '', $matchesN[1]);
			$matches[2] = trim($matches[2]);
			if (strlen($matchesN[1]) > strlen($matches[2])) {
				$matches[2] = $matchesN[1];
			}
			//print_r($matches);
			if (strripos($key[1], 'add-to-basket-action') !== false || strripos($key[1], 'В магазин') !== false) { // Тут дополнительно нужно проверять наличие. Если кнопка оранжевая, сканируем	
				if ($matches[1]) {
					price_change_detect(trim($matches[1]), trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $proxyArr[0].':'.$proxyArr[1], $authArr[0].':'.$authArr[1], escapeshellarg($useragent), ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $proxyArr[0].':'.$proxyArr[1]);
					echo trim($matches[2]).' | '.preg_replace('~[\D]+~', '' , $matches[3]).PHP_EOL;	
				}				
			} else {
				preg_match($regexpPrices3, $key[1], $matches);
				if (strripos($key[1], 'Нет в наличии') !== false AND strripos($matches[1], 'http:') !== false) {
					if ($matches[1]) {
						price_change_detect(trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), $proxyArr[0].':'.$proxyArr[1], $authArr[0].':'.$authArr[1], escapeshellarg($useragent), ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), $proxyArr[0].':'.$proxyArr[1]);
						echo trim($matches[2]).' | 0'.PHP_EOL;						
					}					
				}
			}
		}
		file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
		return 1;
  } else {
  	$bad_urls[] = $url;
  	return 0;
  }
}
