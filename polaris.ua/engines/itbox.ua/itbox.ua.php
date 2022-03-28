<?php
/**
 * itbox.ua
 * http://api.itbox.ua/api/v1/search/term=philips;view=table;page=2/?
 */
$regexpP 			 = "~class=\"pagination\"(.+)</ul>~isU"; 	// Пагинация
$regexpP2  		 = "~<a.*>(.+)<~isU";  
$regexpPrices  = "~data-product-code=(.+)class=\"stuff-info info-rating-row~isU";
$regexpPrices2 = "~class=\"stuff-caption\".*href=\"(.+)\".*>(.+)<.*class=\"stuff-price__digits\">(.+)<~isU";
$regexpPrices3 = "";
$options 			 = array(
								CURLOPT_COOKIEJAR       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        				CURLOPT_COOKIEFILE      => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT        => 20,
                CURLOPT_AUTOREFERER     => TRUE,
                CURLOPT_FOLLOWLOCATION  => TRUE,
                CURLOPT_HEADER => 0, 
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0
	);

$already_scanned = array();
$already_scanned = scanned_links($itemsArray);
//$already_scanned = array();
print_r($already_scanned);

$AC->get('https://www.itbox.ua/search/?Search=polaris', null, $options);
$AC->get('https://www.itbox.ua/search/?Search=polaris', null, $options);
$AC->execute(WINDOW_SIZE);	

while ($bad_urls) {
  $AC->flush_requests();
  foreach ($bad_urls as $urls) {
    $AC->get($urls, null, $options);
  }
  unset($urls);
  $bad_urls = array();
  $AC->execute(WINDOW_SIZE);
}	
unset($urls);

if ($qOfPaginationPages > 1) {
	//$qOfPaginationPages = 4; // Костыль !!! Уменьшает нагрузку, уберает страницы без наличия

	$is_scan = 0;
	for ($i = 2; $i <= $qOfPaginationPages; $i++) {
		if (!in_array('https://www.itbox.ua/search/page='.$i.'/?Search=polaris', $already_scanned)) {
			AngryCurl::add_debug_msg('сканирую адрес: '.'https://www.itbox.ua/search/page='.$i.'/?Search=polaris');
	  	$AC->get('https://www.itbox.ua/search/page='.$i.'/?Search=polaris', null, $options);
	  	$is_scan = 1;
	  } else {
			AngryCurl::add_debug_msg('уже сканировал: '.'https://www.itbox.ua/search/page='.$i.'/?Search=polaris');
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
 *              Callback Functions           
 */

function callback_one($response, $info, $request) {
  global $regexpP;
  global $regexpP2;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 1800) { $bad_urls = array(); }
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
  		if (strripos($key[1], 'нет в наличии') === false) {
				preg_match($regexpPrices2, $key[1], $matches);
				//print_r($matches);
				if (@trim($matches[1]) && @trim($matches[2])) {
					if (strripos($matches[1], 'http://') === false) {
						$matches[1] = 'http://www.itbox.ua'.$matches[1];
					}
		  		if (strripos($matches[3], '.') !== false) {
		  			$pricecl = preg_replace('~[\D]+~', '' , substr($matches[3], 0, strripos($matches[3], '.')));
		  		} else {
		  			$pricecl = preg_replace('~[\D]+~', '' , $matches[3]);
		  		}

					price_change_detect(trim($matches[1]), trim($matches[2]), $pricecl, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(trim($matches[2]), $pricecl, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$pricecl);
				}
  		} else {
				preg_match($regexpPrices2, $key[1], $matches);
				if (@trim($matches[1]) && @trim($matches[2])) {
					if (strripos($matches[1], 'http://') === false) {
						$matches[1] = 'http://www.itbox.ua'.$matches[1];
					}
					price_change_detect(trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | 0');
				}
  		}						
		}
  }
}
