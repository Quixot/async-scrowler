<?php
//aleco.com.ua
$regexpP 			 = "~class=\"pagination(.+)</ul>~isU"; 	// Пагинация
$regexpP2  		 = "~<input.*>(.+)<~isU";  
$regexpPrices  = "~product-item product-item__tile column(.+)data-product-id~isU"; 
$regexpPrices2 = "~href=.*href=\"(.+)\".*>(.+)</a.*class=\"price--title.*<span.*>(.+)</span~isU";
$regexpPrices3 = "~href=.*href=\"(.+)\".*>(.+)</a~isU";


$already_scanned = array();
$already_scanned = scanned_links($itemsArray);
//$already_scanned = array();
print_r($already_scanned);
//die();

$options = array(
								//CURLOPT_COOKIE => 'city_id='.$region.';city_id_geo='.$region,
								CURLOPT_COOKIEJAR       => '/var/www/polaris.ua/cookies',
        				CURLOPT_COOKIEFILE      => '/var/www/polaris.ua/cookies',
                CURLOPT_CONNECTTIMEOUT 	=> 20,
                CURLOPT_TIMEOUT        	=> 20,
                CURLOPT_AUTOREFERER     => true,
                CURLOPT_FOLLOWLOCATION  => true,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_HEADER 					=> true, 
                CURLOPT_SSL_VERIFYPEER 	=> 0,
                CURLOPT_SSL_VERIFYHOST 	=> 0,
);

$AC = new AngryCurl('callback_one');
	$alive_proxy_list = file_get_contents('/var/www/polaris.ua/engines/aleco.com.ua/proxyhotline.txt');
	if ($alive_proxy_list) {
		$alive_proxy_list = explode("\n", $alive_proxy_list);		
		$AC->__set('array_proxy', $alive_proxy_list);
		$AC->__set('n_proxy', count($alive_proxy_list));
		$AC->add_debug_msg("Ускоренная загрузка proxy:\n");	
	}
	$AC->load_useragent_list( '/var/www/lib/useragents_short.txt' );	
	$AC->init_console();	

$AC->get('https://hotline.ua/bt/feny-stajlery/299563/', null, $options);
$AC->execute(WINDOW_SIZE);

file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';


function regular_one($url) {
  global $regexpP;
  global $regexpP2;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;  
  global $qOfPaginationPages;
  global $bad_urls;
	global $time_start;
	global $city;


	$proxarr = get_proxy_and_ua('/var/www/lib/proxies/*.proxy', '/var/www/lib/useragents_short.txt');

	preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	if (!$matches_proxy) {
	 	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	}

	$cmd = 'timeout -k 50s 51s casperjs /var/www/polaris.ua/engines/aleco.com.ua/casper.js '.escapeshellarg($url).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'];

	echo $cmd.PHP_EOL;
	$response = exec($cmd, $out, $err);
	$response = implode(" ", $out);

	//file_put_contents('/var/www/philips/engines/stylus.ua/content.txt', $response);
	if (strlen($response) > 500) {
		echo 'response ok'.PHP_EOL;

		preg_match($regexpP, $response, $matches);
		preg_match_all($regexpP2, $matches[0], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			if (is_numeric(trim($value))) $temparrpage[] = trim($value);
		}
		if (@max($temparrpage) > $qOfPaginationPages) $qOfPaginationPages = @max($temparrpage);	

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);
	  foreach ($matches2 as $key) {
	  	if (strripos(mb_strtolower($key[0]), 'уценка') === false) {
	  		if (stripos($key[0], 'Купить') !== false) {

	  			preg_match($regexpPrices2, $key[1], $matches);

	  		
					$matches[1] = trim($matches[1]);
					$matches[2] = trim(strip_tags($matches[2]));
					$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);

					if (@$matches[1] && $matches[2]) {
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['login'].' '.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $useragent, $url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}						
	  		} else {
					preg_match($regexpPrices3, $key[1], $matches);
					//print_r($matches);
					if (@$matches[1] && $matches[2]) {
						$matches[1] = trim($matches[1]);
						$matches[2] = trim(strip_tags($matches[2]));
						$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
						
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $proxarr['login'].' '.$proxarr['password'], $proxarr['ua'], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $proxarr['address'].' '.$proxarr['port'], $useragent, $url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}			
	  		}	
	  	} // Уценка
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
	global $itemsArray;  
  global $qOfPaginationPages;
  global $bad_urls;
	global $time_start;
	global $city;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

	file_put_contents('/var/www/polaris.ua/engines/aleco.com.ua/content.txt', $response);
	die();

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url; 	
		if (round(microtime(1) - $time_start, 0) >= 60) $bad_urls = array();
  } else {
		preg_match($regexpP, $response, $matches);
		preg_match_all($regexpP2, $matches[0], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			if (is_numeric(trim($value))) $temparrpage[] = trim($value);
		}
		if (@max($temparrpage) > $qOfPaginationPages) $qOfPaginationPages = @max($temparrpage);	

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);
	  foreach ($matches2 as $key) {
	  	if (strripos(mb_strtolower($key[0]), 'уценка') === false) {
	  		if (stripos($key[0], 'Купить') !== false) {

	  			preg_match($regexpPrices2, $key[1], $matches);

	  		
					$matches[1] = trim($matches[1]);
					$matches[2] = trim(strip_tags($matches[2]));
					$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);

					if (@$matches[1] && $matches[2]) {
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}						
	  		} else {
					preg_match($regexpPrices3, $key[1], $matches);
					//print_r($matches);
					if (@$matches[1] && $matches[2]) {
						$matches[1] = trim($matches[1]);
						$matches[2] = trim(strip_tags($matches[2]));
						$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
						
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}			
	  		}	
	  	} // Уценка
	  }
  }
}
