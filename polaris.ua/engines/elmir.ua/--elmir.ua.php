<?php
/**
 * elmir.ua
 */
if ($argv[2] == 'polaris') {
	$polaris = '.ua';
} else {
	$polaris = '';
}
if (file_exists('/var/www/'.$argv[2].$polaris.'/engines/elmir.ua/data/'.date("d.m.y").'_elmir.ua_'.$argv[2].'_kiev.data') && date('H') != '11') {
  $itemsArray = unserialize(file_get_contents('/var/www/'.$argv[2].$polaris.'/engines/elmir.ua/data/'.date("d.m.y").'_elmir.ua_'.$argv[2].'_kiev.data'));
  echo "Today .data file\n";
} else {
	$itemsArray = array();	
	echo "New .data file\n";
}

$proxy_list 		= explode("\n", file_get_contents( '/var/www/lib/proxyelite.txt' ));
$useragent_list = explode("\n", file_get_contents( '/var/www/lib/useragents_short.txt' ));
array_walk($proxy_list, 'trim_value');
array_walk($useragent_list, 'trim_value');

$regexpPrices  = "~class=\"item\">(.+)</tr>~isU";
$regexpPrices2 = "~class=\"name\".*href=\"(.+)\".*>(.+)<.*class=\"price cost\">(.+)<~isU";
$regexpPrices3 = "~class=\"name\".*href=\"(.+)\".*>(.+)<~isU";

$proxy_log = array_flip($proxy_list);  // Сколько раз сработал прокси
$bad_urls = array();

$start_time = microtime(1);
	
	$url = 'https://elmir.ua/?q='.ENGINE_TYPE.'&size=9999&view=list';
	$useragent_index = mt_rand(0, count($useragent_list)-1);
	$useragent = $useragent_list[$useragent_index];
	$proxy_index = mt_rand(0, count($proxy_list)-1);
	$proxy_log[$proxy_list[$proxy_index]]++;
	$proxy_auth = explode(';', $proxy_list[$proxy_index]);
	$proxy = trim($proxy_auth[0]);	
	$auth  = trim(@$proxy_auth[1]); 

/**
 * 
 */
	$proxy = '185.47.205.108:24531';
	$auth = 'veffxs:yuzx0AxY';
/**
 * 
 */

	$cookie = '/var/www/js/engines/elmir.ua/cookies/'.$useragent_index.'_'.str_replace(':', '_', $proxy).'.cook'; // cookies
	echo "\n\n";
	echo "/*--------------------------------------*/\n".$proxy."\n";
	echo $url."\n";
	echo $auth."\n";
	//echo $cookie."\n";
	echo $useragent."\n";
	$start_time = microtime(1);
	//$phantomjs = ExecWaitTimeout('/var/www/sessions/phantomjs/bin/phantomjs --cookies-file='.$cookie.' --proxy='.$proxy.' --proxy-auth='.$auth.' /var/www/js/engines/elmir.ua/run.js '.escapeshellarg($url).' '.escapeshellarg($useragent), 60);      
	if (!file_exists('/var/www/js/engines/elmir.ua/response.txt')) {
		//$phantomjs = exec('/var/www/sessions/phantomjs/bin/phantomjs --cookies-file='.$cookie.' --proxy='.$proxy.' --proxy-auth='.$auth.' /var/www/js/engines/elmir.ua/run.js '.escapeshellarg($url).' '.escapeshellarg($useragent)); 
		$cmd = '/var/www/sessions/phantomjs/bin/phantomjs --cookies-file='.$cookie.' --proxy='.$proxy.' --proxy-auth='.$auth.' /var/www/js/engines/elmir.ua/run.js '.escapeshellarg($url).' '.escapeshellarg($useragent);
		echo $cmd.PHP_EOL;
		$phantomjs = exec("$cmd 2>&1", $out, $err);     
		// Режем данные, сохраняем в массив

		$response = stripcslashes($phantomjs);
		//file_put_contents('/var/www/js/engines/elmir.ua/'.time(), $response);
	} else {
		$response = file_get_contents('/var/www/js/engines/elmir.ua/response.txt');
	}

	//echo $response;
	//file_put_contents('/var/www/js/engines/elmir.ua/'.time(), $response);
	if ($response === '408' || strlen($response) < 1000) {
		$bad_urls[] = $url;
	} else {
		if ($response) {
	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  	print_r($matches2);
	  	foreach ($matches2 as $key) {
	  		if (strripos($key[1], 'status stat-1') !== false || strripos($key[1], 'status stat-2') !== false) {
					preg_match($regexpPrices2, $key[1], $matches);
					if (trim($matches[1]) && $matches[2]) {
						price_change_detect(trim($matches[1]), trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $proxy, $auth, $useragent, ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $proxy);
						echo trim($matches[1]) . "\n";
					}	
	  		} else {
	  			$matches = array();
	  			preg_match($regexpPrices3, $key[1], $matches);

					if (trim($matches[1]) && $matches[2]) {
						price_change_detect(trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), $proxy, $auth, $useragent, ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), $proxy);
						echo trim($matches[1]) . "\n";
					}	  			
	  		}								
			}
		}
	}

file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';
