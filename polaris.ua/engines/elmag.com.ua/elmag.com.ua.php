<?php
//elmag.com.ua
switch (EXTRA_PARAM) {
	case 'kiev': 		$city = 'Киев'; 		$region = '0'; 	break;
	case 'kharkov': $city = 'Харьков'; 	$region = '3'; break;
	case 'dnepr': 	$city = 'Днепр'; 		$region = '1'; 	break;
	case 'odessa': 	$city = 'Одесса'; 	$region = '2'; break;
 	default:
 		die("Unknown region\n"); 		
}	

$regexpP 			 = "~class=\"pagination(.+)pager_bttn_text~isU";
$regexpP2  		 = "~<a.*>(.+)<~isU";  

$regexpPrices  = "~class=\"item_body\">(.+)style=\"clear: both;~isU"; 
$regexpPrices2 = "~class=\"productItemCard.*href=\"(.+)\".*title=\"(.+)\".*class=\"price uah\">(.+)<~isU";
$regexpPrices3 = "~class=\"productItemCard.*href=\"(.+)\".*title=\"(.+)\"~isU";

$options = array(
								CURLOPT_COOKIE => 'chosen_city='.$region,
								//CURLOPT_COOKIEJAR       => '/var/www/polaris.ua/engines/xxx/cookies2.txt',
        				//CURLOPT_COOKIEFILE      => '/var/www/polaris.ua/engines/denika.ua/cookies.txt',
                CURLOPT_CONNECTTIMEOUT 	=> 100,
                CURLOPT_TIMEOUT        	=> 100,
                CURLOPT_AUTOREFERER     => true,
                CURLOPT_FOLLOWLOCATION  => true,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_HEADER 					=> true, 
                CURLOPT_SSL_VERIFYPEER 	=> 0,
                CURLOPT_SSL_VERIFYHOST 	=> 0,
);

$already_scanned = array();
$already_scanned = scanned_links($itemsArray);
//$already_scanned = array();
print_r($already_scanned);

/**
 * Получаем ссылки на категории
 */
$AC->get('https://elmag.com.ua/view/search.html?text_filter=polaris&city='.EXTRA_PARAM, null, $options); //&page=1
$AC->get('https://elmag.com.ua/view/search.html?text_filter=polaris&city='.EXTRA_PARAM, null, $options); //&page=1
$AC->execute(WINDOW_SIZE);


while ($bad_urls) {
	$AC->flush_requests();
	foreach ($bad_urls as $urls) {
	  $AC->get($urls, null, $options);
	}
	$bad_urls = array();
	$AC->execute(WINDOW_SIZE);
}

if ($qOfPaginationPages <=0) {
	$qOfPaginationPages = 14;
}

if ($qOfPaginationPages > 1) {
	$AC->flush_requests();
	$AC->__set('callback','callback_one');

	$is_scan = 0;
	for ($i = 1; $i < $qOfPaginationPages; $i++) {
		if (!in_array('https://elmag.com.ua/view/search.html?text_filter=polaris&page='.$i, $already_scanned)) {
			AngryCurl::add_debug_msg('сканирую адрес: '.'https://elmag.com.ua/view/search.html?text_filter=polaris&page='.$i);
	  	$AC->get('https://elmag.com.ua/view/search.html?text_filter=polaris&page='.$i, null, $options);
	  	$is_scan = 1;
	  } else {
			AngryCurl::add_debug_msg('уже сканировал: '.'https://elmag.com.ua/view/search.html?text_filter=polaris&page='.$i);
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
 * Callback Functions           
 */
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

  if ($info['http_code'] !== 200 || !$response) {            
    $bad_urls[] = $request->url; 	
		if (round(microtime(1) - $time_start, 0) >= 700) { $bad_urls = array(); } 
  } else {
  	//file_put_contents('/var/www/polaris.ua/engines/elmag.com.ua/content.txt', $response); //die($response);
		preg_match("~id=\"ctop\".*>(.+)<~isU", $response, $region);
		AngryCurl::add_debug_msg('request  region: '.$city);
		AngryCurl::add_debug_msg('response region: '.trim($region[1])); 

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
	  	if (stripos($key[0], 'Товара нет в наличии') === false) {
		  	preg_match($regexpPrices2, $key[1], $matches);

				if (@$matches[1] && $matches[2]) {
					$matches[1] = trim($matches[1]);
					if (stripos($matches[1], 'http') === false) $matches[1] = 'https:'.$matches[1];
					$matches[2] = trim($matches[2]);
					$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
							
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
		  	}
		  	file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
	  	} else {
		  	preg_match($regexpPrices3, $key[1], $matches);

				if (@$matches[1] && $matches[2]) {
					$matches[1] = trim($matches[1]);
					if (stripos($matches[1], 'http') === false) $matches[1] = 'https:'.$matches[1];
					$matches[2] = trim($matches[2]);
					$matches[3] = '0';
							
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
		  	}
	  	}

	  }
  }
}
