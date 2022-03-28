<?php
/**
 * skidka.ua
 */
$regexpP1 			= "~class=\"pagination\">(.+)</ul>~isU";
$regexpP2 			= "~<a.*>(.+)<~isU";
$regexpPrices   = "~<li class=\"catalog__item(.+)</li~isU";
$regexpPrices2  = "~href=\"(.+)\".*title=\"(.+)\".*class=\"item__price\">(.+)<~isU";
$regexpPrices3  = "~href=\"(.+)\".*title=\"(.+)\"~isU";

$already_scanned = array();
$already_scanned = scanned_links($itemsArray);
$already_scanned = array();
print_r($already_scanned);

$url = 'https://can.ua/search/?p=0&text=polaris';
for ($pag=0; $pag <= 16; $pag++) { 
	if (!in_array('https://can.ua/search/?p='.$pag.'&text=polaris', $already_scanned)) {
		AngryCurl::add_debug_msg('сканирую адрес: '.'https://can.ua/search/?p='.$pag.'&text=polaris');
		$i = 1;
		while (regular_one('https://can.ua/search/?p='.$pag.'&text=polaris')<1 && $i<3) {
			$i++;
		}
	} else {
		AngryCurl::add_debug_msg('уже сканировал: '.'https://can.ua/search/?p='.$pag.'&text=polaris');
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
	global $itemsArray;  
	global $time_start;

	echo $url.PHP_EOL;
	
	$proxy_array = glob('/var/www/lib/proxies/15.proxy');
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
	$cmd = 'timeout -k 51s 55s casperjs /var/www/polaris.ua/engines/can.ua/casper.js --ignore-ssl-errors=true --ssl-protocol=any '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4];
	echo $cmd.PHP_EOL;
	$phantomjs = exec("$cmd 2>&1", $out, $err);
	// Режем данные, сохраняем в массив
	$response = stripcslashes($phantomjs);

	file_put_contents("/var/www/polaris.ua/engines/can.ua/content.txt", $response);

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
	  //print_r($matches2);
	  foreach ($matches2 as $key) {
			if (strripos($key[1], 'status-in_stock') !== false) {
				preg_match($regexpPrices2, $key[1], $matches);
				if ($matches[1]) {
					price_change_detect($matches[1], $matches[2], preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], escapeshellarg($useragent), ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent, $url);
					echo $matches[2].' | '.preg_replace('~[\D]+~', '' , $matches[3]).PHP_EOL;	
				}				
			} else {
				preg_match($regexpPrices3, $key[1], $matches);
				if ($matches[1]) {
					$matches[1] = trim($matches[1]);
					$matches[2] = trim($matches[2]);
					price_change_detect($matches[1], $matches[2], '0', date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], escapeshellarg($useragent), ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], '0', date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent, $url);
					echo $matches[2].' | 0'.PHP_EOL;						
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
