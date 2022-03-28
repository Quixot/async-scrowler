<?php
/**
 * palladium.ua
 */
$regexpP 			 = "~class=\"re-pagination\">(.+)</div>~isU";
$regexpP2 		 = "~<a.*>(.+)<~isU";
$regexpPrices  = "~<div class=\"prod-item hover-prod\">(.+)class=\"addToCompare~isU";
$regexpPrices2 = "~\"second-fit\">.*class=\"title-prod\".*<a.*href=\"(.+)\">(.+)</a.*class=\"price-group\".*>.*class=\"b\">(.+)<~isU";
$regexpPrices3 = "~\"second-fit\">.*class=\"title-prod\".*<a.*href=\"(.+)\">(.+)</a~isU";

$already_scanned = array();
$already_scanned = scanned_links($itemsArray);
//$already_scanned = array();
print_r($already_scanned);

$urlarray = array(
	'https://palladium.ua/advanced_search_result.php?keywords=polaris',
	'https://palladium.ua/advanced_search_result.php?keywords=polaris&page=2',
);

	foreach ($urlarray as $url) {
		if (!in_array($url, $already_scanned)) {
			$i = 1;
			while ( regular_one($url)<1 && $i<4 ) {
				$i++;
			}
		} else {
			echo 'уже сканировал:'.PHP_EOL.$url.PHP_EOL;
		}
	}

file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';


/** 
 *              Callback Functions           
 */
function regular_one($url) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
	global $bad_urls;
	global $time_start;


	$proxarr = get_proxy_and_ua('/var/www/lib/proxies/15.proxy', '/var/www/lib/useragents_short.txt');

	$cmd = 'timeout -k 60 61s casperjs /var/www/polaris.ua/engines/palladium.ua/casper.js '.escapeshellarg($url).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'];

	echo $cmd.PHP_EOL;
	$response = exec($cmd, $out, $err);
	$response = implode(" ", $out);
		file_put_contents('/var/www/polaris.ua/engines/palladium.ua/content.txt', $response);
		//die();
		//echo $response;

		if (strlen($response) > 1500) {
		  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
		  foreach ($matches2 as $key) {
				preg_match($regexpPrices2, $key[1], $matches);
				if (@trim($matches[1])) {
					price_change_detect(trim($matches[1]), trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['login'].' '.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['ua'], $url);
					AngryCurl::add_debug_msg(trim($matches[2]).' |'.trim($matches[2]).' | '.preg_replace('~[\D]+~', '' , $matches[3]));

					
				}	else {
					preg_match($regexpPrices3, $key[1], $matches);
					if (@trim($matches[1])) {
						price_change_detect(trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), $proxyArr[0].':'.$proxyArr[1], $authArr[0].':'.$authArr[1], escapeshellarg($proxarr['ua']), ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['ua'], $url);
						AngryCurl::add_debug_msg(trim($matches[2]).' | 0');		
					}				
				}
			}

			return 1;		
		} else {
	  	echo 'bad response'.PHP_EOL;
	  	return 0;	
		}
}
